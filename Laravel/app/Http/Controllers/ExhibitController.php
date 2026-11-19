<?php

namespace App\Http\Controllers;

use App\Models\Exhibit;
use Illuminate\Http\Request;

class ExhibitController extends Controller
{
    public function index()
    {
        $exhibits = Exhibit::all();

        return view('exhibits.index', compact('exhibits'));
    }

    public function create()
    {
        return view('exhibits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'creation_date' => 'required|date',
        ]);

        Exhibit::create($validated);

        return redirect()->route('exhibits.index')
            ->with('success', 'Exhibit created successfully.');
    }

    public function show(string $id)
    {
        $exhibit = Exhibit::findOrFail($id);

        return view('exhibits.show', compact('exhibit'));
    }

    public function edit(string $id)
    {
        $exhibit = Exhibit::findOrFail($id);

        return view('exhibits.edit', compact('exhibit'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'creation_date' => 'required|date',
        ]);

        $exhibit = Exhibit::findOrFail($id);
        $exhibit->update($validated);

        return redirect()->route('exhibits.index')
            ->with('success', 'Exhibit updated successfully.');
    }

    public function destroy(string $id)
    {
        $exhibit = Exhibit::findOrFail($id);
        $exhibit->delete();

        return redirect()->route('exhibits.index')
            ->with('success', 'Exhibit deleted successfully.');
    }
}
