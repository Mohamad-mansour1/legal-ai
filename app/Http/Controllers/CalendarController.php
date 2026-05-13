<?php

namespace App\Http\Controllers;

use App\Models\Hearing;
use App\Models\Task;

use Inertia\Inertia;

class CalendarController extends Controller
{
    public function index()
    {
        $events = [];

        /*
        |--------------------------------------------------------------------------
        | Hearings
        |--------------------------------------------------------------------------
        */

        $hearings = Hearing::with('legalCase')->get();

        foreach ($hearings as $hearing) {

            $events[] = [
                'title' => '⚖️ ' . $hearing->title,
                'date' => $hearing->hearing_date,
                'url' => '/legal-cases/' . $hearing->legal_case_id . '/edit',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Tasks
        |--------------------------------------------------------------------------
        */

        $tasks = Task::with('legalCase')->get();

        foreach ($tasks as $task) {

            if ($task->due_date) {

                $events[] = [
                    'title' => '📌 ' . $task->title,
                    'date' => $task->due_date,
                    'url' => '/legal-cases/' . $task->legal_case_id . '/edit',
                ];
            }
        }

        return Inertia::render('Calendar/Index', [
            'events' => $events,
        ]);
    }
}