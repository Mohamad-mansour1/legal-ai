<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\CaseDocument;
use Illuminate\Http\Request;

class CaseDocumentController extends Controller
{
    public function store(Request $request, LegalCase $legalCase)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'file' => ['required', 'file', 'max:20480'],
        ]);

        $file = $request->file('file');

        $path = $file->store('case-documents', 'public');

        CaseDocument::create([
            'legal_case_id' => $legalCase->id,
            'title' => $validated['title'],
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return back();
    }
}