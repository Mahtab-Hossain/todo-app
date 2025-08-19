<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function index()
    {
        // Get tasks from session or empty array
        $tasks = Session::get('tasks', []);
        $theme = Cookie::get('theme', 'light'); // Default to light

        return view('tasks.index', compact('tasks', 'theme'));
    }

    public function create()
    {
        $theme = Cookie::get('theme', 'light');
        return view('tasks.create', compact('theme'));
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'title' => 'required|min:3',
            'description' => 'nullable|max:255',
        ]);

        // Get current tasks
        $tasks = Session::get('tasks', []);

        // Generate ID (simple increment)
        $id = count($tasks) + 1;

        // Add new task
        $tasks[] = [
            'id' => $id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'status' => 'pending', // Default status
        ];

        // Save back to session
        Session::put('tasks', $tasks);

        return redirect()->route('tasks.index')->with('success', 'Task added!');
    }

    public function edit($id)
    {
        $tasks = Session::get('tasks', []);
        $task = collect($tasks)->firstWhere('id', $id);

        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found');
        }

        $theme = Cookie::get('theme', 'light');
        return view('tasks.edit', compact('task', 'theme'));
    }

    public function update(Request $request, $id)
    {
        // Validate
        $validated = $request->validate([
            'title' => 'required|min:3',
            'description' => 'nullable|max:255',
            'status' => 'required|in:pending,completed',
        ]);

        // Get tasks
        $tasks = Session::get('tasks', []);

        // Find and update
        foreach ($tasks as &$task) {
            if ($task['id'] == $id) {
                $task['title'] = $validated['title'];
                $task['description'] = $validated['description'] ?? '';
                $task['status'] = $validated['status'];
                break;
            }
        }

        // Save back
        Session::put('tasks', $tasks);

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    public function destroy($id)
    {
        $tasks = Session::get('tasks', []);

        // Filter out the task
        $tasks = array_filter($tasks, fn($task) => $task['id'] != $id);

        // Re-index array
        $tasks = array_values($tasks);

        // Update IDs if needed (optional, but keeps IDs sequential)
        foreach ($tasks as $key => &$task) {
            $task['id'] = $key + 1;
        }

        Session::put('tasks', $tasks);

        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }

    public function toggleTheme()
    {
        $currentTheme = Cookie::get('theme', 'light');
        $newTheme = $currentTheme === 'light' ? 'dark' : 'light';

        // Set cookie for 1 day
        return redirect()->back()->withCookie(cookie('theme', $newTheme, 1440));
    }
}