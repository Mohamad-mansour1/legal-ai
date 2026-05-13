<?php

namespace App\Http\Controllers;

use App\Models\Hearing;
use App\Models\LegalCase;
use App\Models\User;
use App\Notifications\HearingReminderNotification;
use Illuminate\Http\Request;

class HearingController extends Controller
{
    public function store(Request $request, LegalCase $legalCase)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'court' => ['nullable'],
            'hearing_date' => ['required'],
            'result' => ['nullable'],
            'notes' => ['nullable'],
        ]);

        $hearing = $legalCase->hearings()->create($validated);

        if ($legalCase->assignedLawyer) {

            $legalCase->assignedLawyer->notify(
                new HearingReminderNotification($hearing)
            );

        }

        return back();
    }

    public function destroy(Hearing $hearing)
    {
        $hearing->delete();

        return back();
    }
}