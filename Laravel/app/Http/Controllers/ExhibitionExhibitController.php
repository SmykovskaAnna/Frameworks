<?php

namespace App\Http\Controllers;

use App\Models\ExhibitionExhibit;
use App\Models\Exhibition;
use App\Models\Exhibit;
use Illuminate\Http\Request;

class ExhibitionExhibitController extends Controller
{
    public function index(Request $request)
    {
        $query = ExhibitionExhibit::with(['exhibition', 'exhibit']);
        foreach (['display_order', 'exhibition_id', 'exhibit_id'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, 'like', '%' . $request->input($field) . '%');
            }
        }
        $itemsPerPage = max(1, min(100, (int) $request->input('itemsPerPage', 10)));
        $exhibitionExhibits = $query->paginate($itemsPerPage)->withQueryString();
        return view('exhibition_exhibits.index', compact('exhibitionExhibits'));
    }

    public function create()
    {
        $exhibitions = Exhibition::all();
        $exhibits = Exhibit::all();

        return view('exhibition_exhibits.create', compact(
            'exhibitions',
            'exhibits'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'display_order' => 'required|integer|min:1',
            'exhibition_id' => 'required|exists:exhibitions,id',
            'exhibit_id' => 'required|exists:exhibits,id',
        ]);

        ExhibitionExhibit::create($validated);

        return redirect()->route('exhibition-exhibits.index')
            ->with('success', 'Exhibit added to exhibition successfully.');
    }

    public function show(string $id)
    {
        $exhibitionExhibit = ExhibitionExhibit::with([
            'exhibition',
            'exhibit'
        ])->findOrFail($id);

        return view('exhibition_exhibits.show', compact('exhibitionExhibit'));
    }

    public function edit(string $id)
    {
        $exhibitionExhibit = ExhibitionExhibit::findOrFail($id);
        $exhibitions = Exhibition::all();
        $exhibits = Exhibit::all();

        return view('exhibition_exhibits.edit', compact(
            'exhibitionExhibit',
            'exhibitions',
            'exhibits'
        ));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'display_order' => 'required|integer|min:1',
            'exhibition_id' => 'required|exists:exhibitions,id',
            'exhibit_id' => 'required|exists:exhibits,id',
        ]);

        $exhibitionExhibit = ExhibitionExhibit::findOrFail($id);
        $exhibitionExhibit->update($validated);

        return redirect()->route('exhibition-exhibits.index')
            ->with('success', 'Exhibition exhibit updated successfully.');
    }

    public function destroy(string $id)
    {
        $exhibitionExhibit = ExhibitionExhibit::findOrFail($id);
        $exhibitionExhibit->delete();

        return redirect()->route('exhibition-exhibits.index')
            ->with('success', 'Exhibition exhibit deleted successfully.');
    }
}
