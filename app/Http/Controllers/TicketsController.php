<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{

    public function index(Request $request)
    {
        $ticketsList = $this->getTicketsForCurrentUser();

        $statusCounts = [
            'submitted' => $ticketsList->where('status', 'submitted')->count(),
            'ongoing' => $ticketsList->where('status', 'ongoing')->count(),
            'done' => $ticketsList->where('status', 'done')->count(),
        ];

        $totalTickets = $ticketsList->count();
        $maxStatusCount = max($statusCounts) ?: 1;
        $recentTickets = $ticketsList->take(5);

        return view('page.dashboard', compact('ticketsList', 'statusCounts', 'totalTickets', 'maxStatusCount', 'recentTickets'));
    }


    public function ticket(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:255',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:submitted,ongoing,done',
        ]);

        $ticketsList = $this->getTicketsForCurrentUser($filters);
        
        return view('page.ticket', compact('ticketsList', 'filters'));
    }

    private function getTicketsForCurrentUser(array $filters = [])
    {
        $user = Auth::user();

        $query = Ticket::with('user');

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
        if (Auth::user()->role !== 'teacher') {
            return redirect()->route('ticket')->with('error', 'Only teachers can submit tickets.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = new Ticket();
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
            return redirect()->route('ticket')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:submitted,ongoing,done',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->route('dashboard')->with('success', 'Ticket status updated successfully.');
    }

    public function show($id)
    {
        $ticket = Ticket::with('user')->findOrFail($id);

        if (Auth::user()->role !== 'admin' && $ticket->user_id !== Auth::id()) {
            return redirect()->route('ticket')->with('error', 'Unauthorized action.');
        }

        return view('page.ticket-detail', compact('ticket'));
    }
    
}
