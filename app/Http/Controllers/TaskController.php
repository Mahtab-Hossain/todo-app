<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    public function index()
    {
        // ensure $tasks is always defined and returns user's tasks when authenticated
        if (auth()->check()) {
            $tasks = Task::where('user_id', auth()->id())->latest()->get();
        } else {
            $tasks = Task::latest()->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    public function data()
    {
        $tasks = Task::where('user_id', auth()->id())->select('id', 'title', 'description', 'status');
        return DataTables::of($tasks)
            ->addColumn('action', function ($task) {
                return '<a href="' . route('tasks.edit', $task->id) . '" class="px-2 py-1 bg-yellow-500 text-white rounded">Edit</a>
                        <form action="' . route('tasks.destroy', $task->id) . '" method="POST" class="inline-block ml-2">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded" onclick="return confirm(\'Delete?\')">Delete</button>
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $theme = Cookie::get('theme', 'light');
        return view('tasks.create', compact('theme'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        // create task and attach to authenticated user (if app uses user ownership)
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'user_id' => auth()->id(), // important: ensure user_id is saved
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $theme = Cookie::get('theme', 'light');
        return view('tasks.edit', compact('task', 'theme'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|min:3',
            'description' => 'nullable|max:255',
            'status' => 'required|in:pending,completed',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }

    public function toggleTheme()
    {
        $currentTheme = Cookie::get('theme', 'light');
        $newTheme = $currentTheme === 'light' ? 'dark' : 'light';

        return redirect()->back()->withCookie(cookie('theme', $newTheme, 1440));
    }
}