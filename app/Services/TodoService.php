<?php

namespace App\Services;

use App\Models\Todos as Todo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TodoService
{
    /**
     * Fetch all todos with caching.
     * 
     * This method retrieves all todos from the database. If the todos
     * have already been cached for 5 minutes, it will return the cached
     * version instead of querying the database again.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception if there is an error retrieving the todos.
     * @author Preksha Shah
     * @since 2025

     */
    public function getAllTodos()
    {
        try {
            return Cache::remember('todos', 300, function () {
                return Todo::orderBy('created_at', 'desc')->get();
            });
        } catch (\Exception $e) {
            throw new \Exception("Error retrieving todos: " . $e->getMessage());
        }
    }

    /**
     * Create a new todo.
     * 
     * This method accepts an array of data, validates it, and creates a new
     * todo record in the database. If the data is invalid, an exception is
     * thrown.
     * 
     * @param  array  $data  Data to create a new todo (title, description, etc.)
     * @return \App\Models\Todos
     * @throws \Exception if validation fails or if there is a database error.
     * @author Preksha Shah
     * @since 2025

     */
    public function createTodo(array $data)
    {
        // Validate data before creating a todo
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }

        try {
            // Create todo and return
            return Todo::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'completed' => false,
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Error creating todo: " . $e->getMessage());
        }
    }

    /**
     * Update an existing todo.
     * 
     * This method validates the updated data, then updates an existing todo
     * record in the database. It returns the updated todo instance.
     * 
     * @param  \App\Models\Todos  $todo  The todo instance to be updated.
     * @param  array  $data  The updated data for the todo.
     * @return \App\Models\Todos
     * @throws \Exception if validation fails or if there is a database error.
     * @author Preksha Shah
     * @since 2025

     */
    public function updateTodo(Todo $todo, array $data)
    {
        // Validate data before updating
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed');
        }

        try {
            // Update todo and return
            $todo->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'completed' => isset($data['completed']) ? $data['completed'] : $todo->completed,
            ]);

            return $todo;
        } catch (\Exception $e) {
            throw new \Exception("Error updating todo: " . $e->getMessage());
        }
    }

    /**
     * Delete a todo.
     * 
     * This method deletes a todo record from the database.
     * 
     * @param  \App\Models\Todos  $todo  The todo instance to be deleted.
     * @return void
     * @throws \Exception if there is an error during deletion.
     * @author Preksha Shah
     * @since 2025

     */
    public function deleteTodo(Todo $todo)
    {
        try {
            $todo->delete();
        } catch (\Exception $e) {
            throw new \Exception("Error deleting todo: " . $e->getMessage());
        }
    }

    /**
     * Toggle the completion status of a todo.
     * 
     * This method toggles the `completed` status of the given todo.
     * If the todo is completed, it will be marked as incomplete and vice versa.
     * 
     * @param  \App\Models\Todos  $todo  The todo instance to toggle completion.
     * @return \App\Models\Todos
     * @throws \Exception if there is an error while updating the todo.
     * @author Preksha Shah
     * @since 2025

     */
    public function toggleTodoCompletion(Todo $todo)
    {
        try {
            $todo->update([
                'completed' => !$todo->completed,
            ]);
            return $todo;
        } catch (\Exception $e) {
            throw new \Exception("Error toggling completion status: " . $e->getMessage());
        }
    }

    /**
     * Clear the todo cache.
     * 
     * This method clears the cached list of todos. It should be called when
     * there is a change in the todos (create, update, delete, or toggle).
     * 
     * @return void
     * 
     * @author Preksha Shah
     * @since 2025
     */
    public function clearCache()
    {
        Cache::forget('todos');
    }
}
