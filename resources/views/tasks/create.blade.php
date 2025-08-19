<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Task
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ $theme === 'dark' ? 'bg-gray-800 text-white' : 'bg-white text-gray-900' }}">
                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-6 text-center">Add New Task</h1> <!-- Optional: Remove if duplicate -->

                    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="title" class="block text-sm font-medium">Title</label>
                            <input type="text" name="title" id="title" class="w-full p-2 border rounded-md {{ $theme === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}" value="{{ old('title') }}">
                            @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium">Description</label>
                            <textarea name="description" id="description" class="w-full p-2 border rounded-md {{ $theme === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>