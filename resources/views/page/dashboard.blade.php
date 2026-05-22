@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl font-semibold text-[#2C3E50]">Dashboard</h1>
        <p class="text-sm font-normal text-slate-500">List tiket yang masuk</p>
    </div>

    <div class="bg-white shadow rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold leading-relaxed text-[#2C3E50]">
                {{ Auth::user()->role === 'admin' ? 'All Submitted Tickets' : 'Your Tickets' }}
            </h3>

            <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 gap-3 md:grid-cols-12">
                <div class="md:col-span-5">
                    <label for="search" class="sr-only">Search tickets</label>
                    <input
                        type="search"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Search title, description, or user"
                        class="block w-full rounded-md border border-slate-300 px-3 py-2 text-sm font-normal shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                    >
                </div>

                <div class="md:col-span-3">
                    <label for="priority" class="sr-only">Filter priority</label>
                    <select name="priority" id="priority" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-normal shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                        <option value="">All priorities</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label for="status" class="sr-only">Filter status</label>
                    <select name="status" id="status" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-normal shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                        <option value="">All statuses</option>
                        <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                <div class="flex gap-2 md:col-span-1">
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Filter
                    </button>
                </div>

                @if(request()->hasAny(['search', 'priority', 'status']))
                    <div class="md:col-span-12">
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">Reset filter</a>
                    </div>
                @endif
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Title / Desc</th>
                        @if(Auth::user()->role === 'admin')
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Submitted By</th>
                        @endif
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Priority</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($ticketsList as $ticket)
                        <tr class="odd:bg-white even:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[#2C3E50]">{{ $ticket->title }}</div>
                                <div class="text-sm font-normal text-slate-500 truncate max-w-xs">{{ \Illuminate\Support\Str::limit($ticket->description, 50) }}</div>
                            </td>
                            @if(Auth::user()->role === 'admin')
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-normal text-[#2C3E50]">{{ $ticket->user->name ?? 'Unknown' }}</div>
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($ticket->priority === 'high')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">High</span>
                                @elseif($ticket->priority === 'medium')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Medium</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Low</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-normal text-slate-500">
                                {{ $ticket->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="block w-full pl-3 pr-10 py-1 text-base border-slate-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm">
                                            <option value="submitted" {{ $ticket->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                            <option value="ongoing" {{ $ticket->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                            <option value="done" {{ $ticket->status === 'done' ? 'selected' : '' }}>Done</option>
                                        </select>
                                    </form>
                                @else
                                    @if($ticket->status === 'done')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Done</span>
                                    @elseif($ticket->status === 'ongoing')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Ongoing</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Submitted</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role === 'admin' ? 5 : 4 }}" class="px-6 py-4 whitespace-nowrap text-sm font-normal text-slate-500 text-center">
                                No tickets found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
