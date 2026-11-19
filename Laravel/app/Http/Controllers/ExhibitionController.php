<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    public function index()
    {
        $exhibitions = Exhibition::all();

        return view('exhibitions.index', compact('exhibitions'));
    }

    public function create()
    {
        return view('exhibitions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Exhibition::create($validated);

        return redirect()->route('exhibitions.index')
            ->with('success', 'Exhibition created successfully.');
    }

    public function show(string $id)
    {
        $exhibition = Exhibition::findOrFail($id);

        return view('exhibitions.show', compact('exhibition'));
    }

    public function edit(string $id)
    {
        $exhibition = Exhibition::findOrFail($id);

        return view('exhibitions.edit', compact('exhibition'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $exhibition = Exhibition::findOrFail($id);
        $exhibition->update($validated);

        return redirect()->route('exhibitions.index')
            ->with('success', 'Exhibition updated successfully.');
    }

    public function destroy(string $id)
    {
        $exhibition = Exhibition::findOrFail($id);
        $exhibition->delete();

        return redirect()->route('exhibitions.index')
            ->with('success', 'Exhibition deleted successfully.');
    }
}
