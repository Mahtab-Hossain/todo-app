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
                    <h1 class="text-2xl font-bold mb-6 text-center">Add New Task</h1>

                    {!! Form::open(['route' => 'tasks.store', 'class' => 'space-y-4']) !!}

                    <div>
                        {!! Form::label('title', 'Title', ['class' => 'block text-sm font-medium']) !!}
                        {!! Form::text('title', old('title'), ['class' => 'w-full p-2 border rounded-md ' . ($theme === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900')]) !!}
                        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        {!! Form::label('description', 'Description', ['class' => 'block text-sm font-medium']) !!}
                        {!! Form::textarea('description', old('description'), ['class' => 'w-full p-2 border rounded-md ' . ($theme === 'dark' ? 'bg-gray-700 text-white' : 'bg-white text-gray-900')]) !!}
                        @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    {!! Form::submit('Add Task', ['class' => 'w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>