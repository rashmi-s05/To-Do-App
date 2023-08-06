<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Get all the pending tasks and their sub-tasks
        $query = Task::whereNull('deleted_at')->whereNull('parent_id');

    // Filter by due date
    if ($request->has('filter')) {
        $filter = $request->input('filter');

        switch ($filter) {
            case 'today':
                $query->whereDate('due_date', Carbon::today());
                break;
            case 'this_week':
                $query->whereBetween('due_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'next_week':
                $query->whereBetween('due_date', [Carbon::now()->addWeek()->startOfWeek(), Carbon::now()->addWeek()->endOfWeek()]);
                break;
            case 'overdue':
                $query->whereDate('due_date', '<', Carbon::today());
                break;
        }
    }

    // Search by title
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('title', 'LIKE', "%$search%");
    }

    $tasks = $query->with('subtasks')->orderBy('due_date')->get();
    return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'due_date' => 'required|date',
            'parent_id' => 'nullable|exists:tasks,id',
        ]);

        $task = new Task([
            'title' => $request->title,
            'due_date' => $request->due_date,
            'status' => Task::STATUS_PENDING,
            'parent_id' => $request->parent_id,
        ]);

        $task->save();

        return response()->json($task, 201);
    }

    public function completeTask(Task $task)
    {
        $task->status = Task::STATUS_COMPLETED;
        $task->save();

        // If it's a main task, complete all related sub-tasks
        if ($task->parent_id === null) {
            Task::where('parent_id', $task->id)->update(['status' => Task::STATUS_COMPLETED]);
        }

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
