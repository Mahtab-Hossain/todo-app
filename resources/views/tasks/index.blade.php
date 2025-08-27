<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">To-Do List</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="{{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-800 text-white' : 'bg-white text-gray-900' }} overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">To-Do List</h1>

                        <div class="flex items-center space-x-3">
                            <form action="{{ route('toggle.theme') }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Toggle Theme ({{ Cookie::get('theme', 'light') }})
                                </button>
                            </form>

                            <button id="add-task-btn" class="mb-4 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add Task</button>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
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
                                        <td class="p-2">{{ $task->id }}</td>
                                        <td class="p-2">{{ $task->title }}</td>
                                        <td class="p-2">{{ $task->description }}</td>
                                        <td class="p-2">{{ $task->status }}</td>
                                        <td class="p-2 flex space-x-2">
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</a>

                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="p-2 text-center">No tasks yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="task-modal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50 z-50">
        <div class="{{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-800 text-white' : 'bg-white text-gray-900' }} p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Add Task</h2>
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium">Title</label>
                    <input id="title" name="title" required value="{{ old('title') }}" class="w-full p-2 border rounded-md {{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}">
                    @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium">Description</label>
                    <textarea id="description" name="description" class="w-full p-2 border rounded-md {{ Cookie::get('theme', 'light') === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900' }}">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="button" id="close-modal" class="px-4 py-2 bg-gray-500 text-white rounded mr-2">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        (function($){
            $(function(){
                // open modal
                $('#add-task-btn').on('click', function(){ $('#task-modal').removeClass('hidden'); });
                // close modal
                $('#close-modal').on('click', function(){ $('#task-modal').addClass('hidden'); });
                // click outside to close
                $('#task-modal').on('click', function(e){
                    if (e.target === this) $(this).addClass('hidden');
                });

                // if validation errors exist, open modal again
                @if($errors->any())
                    $('#task-modal').removeClass('hidden');
                @endif
            });
        })(jQuery);
    </script>
    @endpush

</x-app-layout>