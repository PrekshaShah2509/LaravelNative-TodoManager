@extends('layouts.app')

@section('content')
    <div class="mb-4 flex flex-col gap-3 md:flex-row md:justify-between md:items-center">
        <h2 class="text-2xl font-bold text-gray-800">My Todos</h2>
        <form method="GET" action="{{ route('todos.index') }}" class="flex flex-col gap-2 md:flex-row md:gap-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search todos..." class="border border-gray-300 rounded-lg px-3 py-2 w-full md:w-64 focus:ring-2 focus:ring-blue-400 focus:outline-none transition" />
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">Search</button>
        </form>
        <a href="{{ route('todos.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition text-center w-full md:w-auto">
            + Add New Todo
        </a>
    </div>

    <div class="mb-4 flex gap-2 flex-wrap">
        @php $filters = ['all' => 'All', 'completed' => 'Completed', 'pending' => 'Pending']; @endphp
        @foreach($filters as $key => $label)
            <a href="{{ route('todos.index', array_merge(request()->all(), ['filter' => $key])) }}"
               class="px-4 py-2 rounded-lg font-medium transition {{ ($filter ?? 'all') === $key ? 'bg-blue-600 text-white shadow' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        @if($todos->count() > 0)
            <ul class="divide-y divide-gray-100">
                @foreach($todos as $todo)
                    <li class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-gray-50 transition">
                        <div class="flex items-start gap-3 w-full">
                            <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="mt-1">
                                @csrf
                                @method('PATCH')
                                <input type="checkbox" onchange="this.form.submit()" {{ $todo->completed ? 'checked' : '' }} class="h-5 w-5 text-green-500 focus:ring-green-400 border-gray-300 rounded shadow-sm transition" title="Toggle complete" />
                            </form>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-semibold truncate {{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                                        {{ $todo->title }}
                                    </h3>
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold {{ $todo->completed ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $todo->completed ? 'Completed' : 'Pending' }}
                                    </span>
                                </div>
                                @if($todo->description)
                                    <p class="text-sm text-gray-500 mt-1 truncate">{{ $todo->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('todos.edit', $todo) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded transition" title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this todo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-2 rounded transition" title="Delete">
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
            <div class="p-6 text-center text-gray-400 text-lg">
                No todos found. Create one to get started!
            </div>
        @endif
    </div>
@endsection