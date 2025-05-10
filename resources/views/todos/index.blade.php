@extends('layouts.app')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold">My Todos</h2>
        <a href="{{ route('todos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Todo
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if($todos->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($todos as $todo)
                    <li class="p-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center">
                            <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="mr-3">
                                    @if($todo->completed)
                                        <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                            <div>
                                <h3 class="text-lg font-medium {{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                                    {{ $todo->title }}
                                </h3>
                                @if($todo->description)
                                    <p class="text-sm text-gray-500 mt-1">{{ $todo->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('todos.edit', $todo) }}" class="text-blue-500 hover:text-blue-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this todo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="p-4 text-center text-gray-500">
                No todos found. Create one to get started!
            </div>
        @endif
    </div>
@endsection