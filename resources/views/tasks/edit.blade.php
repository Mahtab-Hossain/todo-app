<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Task</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="{{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-800 text-white' : 'bg-white text-gray-900' }} overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Edit Task</h1>
                        <a href="{{ route('tasks.index') }}" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">Back</a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium">Title</label>
                            <input id="title" name="title" required value="{{ old('title', $task->title) }}" class="w-full p-2 border rounded-md {{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}">
                            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium">Description</label>
                            <textarea id="description" name="description" class="w-full p-2 border rounded-md {{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}">{{ old('description', $task->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium">Status</label>
                            <select id="status" name="status" class="w-full p-2 border rounded-md {{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}">
                                <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                            @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>