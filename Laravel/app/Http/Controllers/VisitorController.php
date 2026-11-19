<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::all();

        return view('visitors.index', compact('visitors'));
    }

    public function create()
    {
        return view('visitors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:180|unique:visitors,email',
        ]);

        Visitor::create($validated);

        return redirect()->route('visitors.index')
            ->with('success', 'Visitor created successfully.');
    }

    public function show(string $id)
    {
        $visitor = Visitor::findOrFail($id);

        return view('visitors.show', compact('visitor'));
    }

    public function edit(string $id)
    {
        $visitor = Visitor::findOrFail($id);

        return view('visitors.edit', compact('visitor'));
    }

    public function update(Request $request, string $id)
    {
        $visitor = Visitor::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:180|unique:visitors,email,' . $visitor->id,
        ]);

        $visitor->update($validated);

        return redirect()->route('visitors.index')
            ->with('success', 'Visitor updated successfully.');
    }

    public function destroy(string $id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();

        return redirect()->route('visitors.index')
            ->with('success', 'Visitor deleted successfully.');
    }
}
