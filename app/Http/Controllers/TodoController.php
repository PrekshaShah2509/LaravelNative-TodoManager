<?php

/**
 * TodoController Class
 *
 * Handles all HTTP requests for Todo operations (CRUD, filter, search, toggle, etc).
 *
 * @author Preksha Shah
 * @since 2025
 */
namespace App\Http\Controllers;

use App\Models\Todos as Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * The TodoService instance.
     * @var TodoService
     * @author Preksha Shah
     */
    protected $todoService;

    /**
     * Inject the TodoService dependency.
     *
     * @param  TodoService  $todoService
     * @author Preksha Shah
     */
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the todos with optional search and filter.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     * @author Preksha Shah
     */
    public function index(Request $request)
    {
        // Get search and filter params from query string
        $search = $request->query('search');
        $filter = $request->query('filter', 'all');
        $todos = $this->todoService->searchAndFilterTodos($search, $filter);
        return view('todos.index', compact('todos', 'search', 'filter'));
    }

    /**
     * Display a listing of completed todos.
     *
     * @return \Illuminate\View\View
     * @author Preksha Shah
     */
    public function completed()
    {
        $todos = $this->todoService->getCompletedTodos();
        return view('todos.index', compact('todos'));
    }

    /**
     * Display a listing of pending todos.
     *
     * @return \Illuminate\View\View
     * @author Preksha Shah
     */
    public function pending()
    {
        $todos = $this->todoService->getPendingTodos();
        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new todo.
     *
     * @return \Illuminate\View\View
     * @author Preksha Shah
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created todo in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Preksha Shah
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
     * @param  Todo  $todo
     * @return \Illuminate\View\View
     * @author Preksha Shah
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified todo in storage.
     *
     * @param  Request  $request
     * @param  Todo  $todo
     * @return \Illuminate\Http\RedirectResponse
     * @author Preksha Shah
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
     * @param  Todo  $todo
     * @return \Illuminate\Http\RedirectResponse
     * @author Preksha Shah
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
     * @param  Todo  $todo
     * @return \Illuminate\Http\RedirectResponse
     * @author Preksha Shah
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
