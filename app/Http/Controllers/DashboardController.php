<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\LegalCase;
use App\Models\CaseDocument;
use App\Models\Task;
use App\Models\Hearing;
use App\Models\ActivityLog;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'casesByStage' => \App\Models\CaseStage::withCount('legalCases')->get(),
            
            'casesPerLawyer' => \App\Models\User::role('lawyer')->withCount('assignedCases')->get(),

            'overdueTasks' => \App\Models\Task::where('status', '!=', 'completed')->whereNotNull('due_date')->where('due_date', '<', now())->count(),
            
            'totalClients' => Client::count(),

            'totalCases' => LegalCase::count(),

            'totalDocuments' => CaseDocument::count(),

            'pendingTasks' => Task::where('status', 'pending')->count(),

            'upcomingHearings' => Hearing::with('legalCase.client')
                ->where('hearing_date', '>=', now())
                ->orderBy('hearing_date')
                ->take(5)
                ->get(),

            'recentCases' => LegalCase::with(['client', 'stage', 'assignedLawyer'])
                ->latest()
                ->take(5)
                ->get(),

            'recentActivities' => ActivityLog::with(['user', 'legalCase'])
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }
}