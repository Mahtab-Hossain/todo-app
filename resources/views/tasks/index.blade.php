<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            To-Do List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg {{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-800 text-white' : 'bg-white text-gray-900' }}">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">To-Do List</h1>

                        <form action="{{ route('toggle.theme') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Toggle Theme (Current: {{ Cookie::get('theme', 'light') }})
                            </button>
                        </form>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('tasks.create') }}" class="mb-4 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add Task</a>

                    <div class="overflow-x-auto">
                        <table id="tasks-table" class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="p-2 text-left">ID</th>
                                    <th class="p-2 text-left">Title</th>
                                    <th class="p-2 text-left">Description</th>
                                    <th class="p-2 text-left">Status</th>
                                    <th class="p-2 text-left">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($tasks ?? [] as $task)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $task->id ?? $task['id'] ?? '' }}</td>
                                        <td class="p-2">{{ $task->title ?? $task['title'] ?? '' }}</td>
                                        <td class="p-2">{{ $task->description ?? $task['description'] ?? '' }}</td>
                                        <td class="p-2">{{ $task->status ?? $task['status'] ?? '' }}</td>
                                        <td class="p-2 flex space-x-2">
                                            <a href="{{ route('tasks.edit', $task->id ?? $task['id']) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</a>

                                            <form action="{{ route('tasks.destroy', $task->id ?? $task['id']) }}" method="POST" onsubmit="return confirm('Delete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-2 text-center">No tasks yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>