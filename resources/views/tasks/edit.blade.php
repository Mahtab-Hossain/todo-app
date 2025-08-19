<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ $theme === 'dark' ? 'bg-gray-800 text-white' : 'bg-white text-gray-900' }}">
                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-6 text-center">Edit Task</h1> <!-- Optional: Remove if duplicate -->

                    <form action="{{ route('tasks.update', $task['id']) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-sm font-medium">Title</label>
                            <input type="text" name="title" id="title" class="w-full p-2 border rounded-md {{ $theme === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}" value="{{ $task['title'] }}">
                            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium">Description</label>
                            <textarea name="description" id="description" class="w-full p-2 border rounded-md {{ $theme === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}">{{ $task['description'] }}</textarea>
                            @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium">Status</label>
                            <select name="status" id="status" class="w-full p-2 border rounded-md {{ $theme === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}">
                                <option value="pending" {{ $task['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $task['status'] === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>