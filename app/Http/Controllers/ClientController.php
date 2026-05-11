<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
        return Inertia::render('Clients/Index', [
            'clients' => Client::latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'phone' => ['nullable'],
            'email' => ['nullable', 'email'],
            'national_id' => ['nullable'],
            'address' => ['nullable'],
            'notes' => ['nullable'],
        ]);

        Client::create($validated);

        return redirect()->route('clients.index');
    }

    public function edit(Client $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => $client
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'phone' => ['nullable'],
            'email' => ['nullable', 'email'],
            'national_id' => ['nullable'],
            'address' => ['nullable'],
            'notes' => ['nullable'],
        ]);

        $client->update($validated);

        return redirect()->route('clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return back();
    }
}