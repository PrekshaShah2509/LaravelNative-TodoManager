<?php

/**
 * TodoController Class
 * 
 * @author Preksha Shah
 * @since 2025
 * 
 * This controller handles the todo operations like create, edit, update, delete, and listing.
 * It interacts with the TodoService for managing the application logic.
 */

namespace App\Http\Controllers;

use App\Models\Todos as Todo;
use App\Services\TodoService; // Import the service
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\TodoService  $todoService
     * @return void
     */
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the todos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $todos = $this->todoService->getAllTodos();
        
        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new todo.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created todo in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->only('title', 'description');
        try {
            $this->todoService->createTodo($data);
            $this->todoService->clearCache();
            
            return redirect()->route('todos.index')
                ->with('success', 'Todo created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified todo.
     *
     * @param  \App\Models\Todos  $todo
     * @return \Illuminate\View\View
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified todo in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todos  $todo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Todo $todo)
    {
        $data = $request->only('title', 'description', 'completed');
        try {
            $this->todoService->updateTodo($todo, $data);
            $this->todoService->clearCache();
            
            return redirect()->route('todos.index')
                ->with('success', 'Todo updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified todo from storage.
     *
     * @param  \App\Models\Todos  $todo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Todo $todo)
    {
        try {
            $this->todoService->deleteTodo($todo);
            $this->todoService->clearCache();

            return redirect()->route('todos.index')
                ->with('success', 'Todo deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Toggle the completion status of the specified todo.
     *
     * @param  \App\Models\Todos  $todo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleComplete(Todo $todo)
    {
        try {
            $this->todoService->toggleTodoCompletion($todo);
            $this->todoService->clearCache();

            return redirect()->route('todos.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}
