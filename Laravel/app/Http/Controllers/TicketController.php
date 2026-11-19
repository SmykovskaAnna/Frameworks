<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Visitor;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['visitor', 'exhibition'])->get();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $visitors = Visitor::all();
        $exhibitions = Exhibition::all();

        return view('tickets.create', compact('visitors', 'exhibitions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'ticket_type' => 'required|string|max:50',
            'visitor_id' => 'required|exists:visitors,id',
            'exhibition_id' => 'required|exists:exhibitions,id',
        ]);

        Ticket::create($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function show(string $id)
    {
        $ticket = Ticket::with(['visitor', 'exhibition'])->findOrFail($id);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $visitors = Visitor::all();
        $exhibitions = Exhibition::all();

        return view('tickets.edit', compact('ticket', 'visitors', 'exhibitions'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'purchase_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'ticket_type' => 'required|string|max:50',
            'visitor_id' => 'required|exists:visitors,id',
            'exhibition_id' => 'required|exists:exhibitions,id',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
