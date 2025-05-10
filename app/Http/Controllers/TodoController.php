<?php

namespace App\Http\Controllers;

use App\Models\Todos as Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class TodoController extends Controller
{
    public function index()
    {
        //dd( DB::connection()->getPdo());
        //dd(app()->environmentFilePath());
        //dd(DB::connection()->getDriverName());
        // Using Cache::remember to cache todos for 5 minutes
        $todos = Cache::remember('todos', 300, function () {
            return Todo::orderBy('created_at', 'desc')->get();
        });
        
        return view('todos.index', compact('todos'));
    }
    
    public function create()
    {
        return view('todos.create');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false,
        ]);
        
        // Clear the cache when a new todo is added
        Cache::forget('todos');
        
        return redirect()->route('todos.index')
            ->with('success', 'Todo created successfully!');
    }
    
    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }
    
    public function update(Request $request, Todo $todo)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->has('completed'),
        ]);
        
        // Clear the cache when a todo is updated
        Cache::forget('todos');
        
        return redirect()->route('todos.index')
            ->with('success', 'Todo updated successfully!');
    }
    
    public function destroy(Todo $todo)
    {
        $todo->delete();
        
        // Clear the cache when a todo is deleted
        Cache::forget('todos');
        
        return redirect()->route('todos.index')
            ->with('success', 'Todo deleted successfully!');
    }
    
    public function toggleComplete(Todo $todo)
    {
        $todo->update([
            'completed' => !$todo->completed,
        ]);
        
        // Clear the cache when a todo status is toggled
        Cache::forget('todos');
        
        return redirect()->route('todos.index');
    }
}