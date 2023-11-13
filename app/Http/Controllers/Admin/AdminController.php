<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class AdminController extends Controller
{
    // Function for dashboard
    public function index()
    {
        return view('admin.index');
    }

    // Function for user
    public function userindex()
    {
        $User = User::paginate(5);

        return view('admin.Tasks.userindex', compact('User'));
    }

    // Function for tasks
    public function taskindex()
    {
        $tasks = Task::withTrashed()->paginate(5);
        return view('admin.Tasks.taskindex', compact('tasks'));
    }

    // Function for permanent delete
    public function permanentDelete($id)
    {
        $task = Task::withTrashed()->find($id);

        if ($task) {
            $task->forceDelete();

            return redirect()->back()->with('status', 'Task permanently deleted.');
        }

        return redirect()->back()->with('error', 'Task not found.');
    }

    // Function for search
    public function search(Request $request)
    {
        $query = $request->input('query');

        $tasks = Task::withTrashed()
            ->where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->paginate(5);

        return view('admin.Tasks.taskindex', compact('tasks'));
    }
}
