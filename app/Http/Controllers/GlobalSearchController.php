<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\LegalCase;
use App\Models\Task;
use App\Models\Hearing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GlobalSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');

        return Inertia::render('Search/Index', [
            'query' => $query,

            'clients' => $query
                ? Client::where('name', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->take(10)
                    ->get()
                : [],

            'cases' => $query
                ? LegalCase::with(['client', 'stage'])
                    ->where('title', 'like', "%{$query}%")
                    ->orWhere('case_number', 'like', "%{$query}%")
                    ->orWhere('court', 'like', "%{$query}%")
                    ->take(10)
                    ->get()
                : [],

            'tasks' => $query
                ? Task::with(['legalCase', 'assignedUser'])
                    ->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->take(10)
                    ->get()
                : [],

            'hearings' => $query
                ? Hearing::with('legalCase')
                    ->where('title', 'like', "%{$query}%")
                    ->orWhere('court', 'like', "%{$query}%")
                    ->orWhere('notes', 'like', "%{$query}%")
                    ->take(10)
                    ->get()
                : [],
        ]);
    }
}