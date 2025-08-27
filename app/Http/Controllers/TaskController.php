<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        // if your app is multi-user, show only current user's tasks; otherwise use Task::all()
        if (auth()->check()) {
            $tasks = Task::where('user_id', auth()->id())->latest()->get();
        } else {
            $tasks = Task::latest()->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
            'user_id' => auth()->id() ?? null,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added');
    }

    public function edit(Task $task)
    {
        // optionally authorize: $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,done',
        ]);

        // assign explicitly to ensure proper binding (prevents unquoted raw being used)
        $task->title = $validated['title'];
        $task->description = $validated['description'] ?? null;
        $task->status = $validated['status'] ?? $task->status;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted');
    }
}