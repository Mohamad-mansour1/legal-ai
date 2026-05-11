<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\LegalCase;
use App\Models\CaseStage;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LegalCaseController extends Controller
{
    public function index()
    {
        return Inertia::render('LegalCases/Index', [
            'cases' => LegalCase::with([
                    'client',
                    'stage',
                ])
                ->latest()
                ->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('LegalCases/Create', [
            'stages' => CaseStage::orderBy('sort_order')->get(),
            'clients' => Client::select('id', 'name')->get(),
            'trainees' => User::role('trainee')->get(),
            'lawyers' => User::role('lawyer')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required'],
            'title' => ['required'],
            'case_number' => ['nullable'],
            'court' => ['nullable'],
            'hearing_date' => ['nullable'],
            'description' => ['nullable'],
            'notes' => ['nullable'],
            'case_stage_id' => ['required', 'exists:case_stages,id'],
            'assigned_lawyer_id' => ['nullable','exists:users,id',],
            'assigned_trainee_id' => ['nullable','exists:users,id',],
        ]);

        $legalCase = LegalCase::create($validated);

        ActivityLog::create([
            'legal_case_id' => $legalCase->id,
            'user_id' => auth()->id(),
            'action' => 'case_created',
            'description' => 'case_created',
        ]);

        return redirect()->route('legal-cases.index');
    }

    public function edit(LegalCase $legalCase)
    {
        $legalCase->load(['documents', 'stage', 'activityLogs.user', 'hearings', 'tasks.assignedUser']);
        // dd(User::role('lawyer')->get());
        return Inertia::render('LegalCases/Edit', [
            'users' => User::select('id', 'name')->get(),
            'stages' => CaseStage::orderBy('sort_order')->get(),
            'legalCase' => $legalCase,
            'clients' => Client::select('id', 'name')->get(),
            'lawyers' => User::role('lawyer')->get(),
            'trainees' => User::role('trainee')->get(),
        ]);
    }

    public function update(Request $request, LegalCase $legalCase)
    {
        $oldStageId = $legalCase->case_stage_id;
        $oldStage = CaseStage::find($oldStageId);

        $validated = $request->validate([
            'client_id' => ['required'],
            'title' => ['required'],
            'case_number' => ['nullable'],
            'court' => ['nullable'],
            'hearing_date' => ['nullable'],
            'description' => ['nullable'],
            'notes' => ['nullable'],
            'case_stage_id' => ['required', 'exists:case_stages,id'],
            'assigned_lawyer_id' => ['nullable','exists:users,id',],
            'assigned_trainee_id' => ['nullable','exists:users,id',],
        ]);

        $legalCase->update($validated);
        $newStage = CaseStage::find($legalCase->case_stage_id);

        if ($oldStageId != $legalCase->case_stage_id) {
            ActivityLog::create([
                'legal_case_id' => $legalCase->id,
                'user_id' => auth()->id(),
                'action' => 'stage_changed',
                'description' => 'stage_changed',
                'old_values' => [
                    'stage_en' => $oldStage?->name_en,
                    'stage_ar' => $oldStage?->name_ar,
                ],
                'new_values' => [
                    'stage_en' => $newStage?->name_en,
                    'stage_ar' => $newStage?->name_ar,
                ],
            ]);
        }
        return redirect()->route('legal-cases.index');
    }

    public function destroy(LegalCase $legalCase)
    {
        $legalCase->delete();

        return back();
    }
}