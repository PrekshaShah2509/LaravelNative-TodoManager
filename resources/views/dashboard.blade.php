@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Total Todos</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $todos->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Completed</h3>
            <p class="text-3xl font-bold text-green-600">{{ $todos->where('completed', true)->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-2">Pending</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $todos->where('completed', false)->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('todos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                    Create New Todo
                </a>
                <a href="{{ route('todos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                    View All Todos
                </a>
            </div>
        </div>
    </div>
@endsection 