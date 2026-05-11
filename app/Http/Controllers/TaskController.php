<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\LegalCase;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, LegalCase $legalCase)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'description' => ['nullable'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'priority' => ['required'],
            'status' => ['required'],
            'due_date' => ['nullable'],
        ]);

        $legalCase->tasks()->create($validated);

        return back();
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return back();
    }
}