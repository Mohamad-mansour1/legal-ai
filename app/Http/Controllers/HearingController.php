<?php

namespace App\Http\Controllers;

use App\Models\Hearing;
use App\Models\LegalCase;
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

        $legalCase->hearings()->create($validated);

        return back();
    }

    public function destroy(Hearing $hearing)
    {
        $hearing->delete();

        return back();
    }
}