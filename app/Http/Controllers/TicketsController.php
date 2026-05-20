<?php

namespace App\Http\Controllers;

use App\Models\tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $ticketsList = tickets::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            $ticketsList = tickets::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }
        
        return view('page.dashboard', compact('ticketsList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = new tickets();
        $ticket->user_id = Auth::id();
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->priority = $request->priority;
        $ticket->status = 'submitted';
        $ticket->save();

        return redirect()->route('dashboard')->with('success', 'Ticket created successfully.');
    }

    /**
     * Update the ticket status (admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:submitted,ongoing,done',
        ]);

        $ticket = tickets::findOrFail($id);
        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->route('dashboard')->with('success', 'Ticket status updated successfully.');
    }
}
