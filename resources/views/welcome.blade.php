<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>To-Do App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles (from Breeze/Tailwind) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-900 text-white sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <!-- Customized Logo: Replace with your app name or image -->
                    <div class="text-4xl font-bold text-red-500">
                        To-Do App
                    </div>
                </div>

                <div class="mt-8 bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <!-- Customized Welcome Text -->
                            <h2 class="text-2xl font-bold mb-4">Welcome to Your To-Do Management System</h2>
                            <p class="mb-4">
                                Organize your tasks efficiently with our simple, session-based To-Do app. 
                                Log in to add, edit, and manage your tasks securely.
                            </p>
                            <p class="mb-4">
                                Features include CSRF protection, validation, and theme switching (light/dark).
                            </p>
                        </div>

                        <div class="flex items-center justify-center">
                            <!-- Auth Links (kept from default, but styled) -->
                            @if (Route::has('login'))
                                <div class="space-x-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Log in</a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>