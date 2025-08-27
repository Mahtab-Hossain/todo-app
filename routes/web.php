<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// dashboard redirects to tasks and requires auth
Route::get('/dashboard', function () {
    return redirect()->route('tasks.index');
})->middleware(['auth'])->name('dashboard');

// all authenticated routes
Route::middleware('auth')->group(function () {
    // resourceful task routes (index, create, store, edit, update, destroy)
    Route::resource('tasks', TaskController::class);

    // optional: DataTables / AJAX endpoint if your frontend expects it
    Route::get('/tasks/data', [TaskController::class, 'data'])->name('tasks.data');

    // theme toggle: accept GET and POST so both links and forms work
    Route::match(['get', 'post'], '/toggle-theme', function () {
        $current = request()->cookie('theme', 'light');
        $next = $current === 'dark' ? 'light' : 'dark';
        return redirect()->back()->withCookie(cookie()->forever('theme', $next));
    })->name('toggle.theme');

    // profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';