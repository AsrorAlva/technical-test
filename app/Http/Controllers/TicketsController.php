<?php

namespace App\Http\Controllers;

use App\Models\tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:255',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:submitted,ongoing,done',
        ]);

        $ticketsList = $this->getTicketsForCurrentUser($filters);

        return view('page.dashboard', compact('ticketsList', 'filters'));
    }

    /**
     * Display the tickets listing page.
     */
    public function ticket()
    {
        $ticketsList = $this->getTicketsForCurrentUser();
        
        return view('page.ticket', compact('ticketsList'));
    }

    private function getTicketsForCurrentUser(array $filters = [])
    {
        $user = Auth::user();

        $query = tickets::with('user');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->get();
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

        return redirect()->route('ticket')->with('success', 'Ticket created successfully.');
    }

    /**
     * Update the ticket status (admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('ticket')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:submitted,ongoing,done',
        ]);

        $ticket = tickets::findOrFail($id);
        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->route('ticket')->with('success', 'Ticket status updated successfully.');
    }
}
