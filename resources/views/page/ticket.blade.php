@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl font-semibold text-[#2C3E50]">Tickets</h1>
        <p class="text-sm font-normal text-slate-500">
            {{ Auth::user()->role === 'admin' ? 'Kelola status semua ticket' : 'Submit ticket baru untuk kebutuhan sekolah' }}
        </p>
    </div>

    @if(Auth::user()->role === 'teacher')
    <div class="bg-white shadow rounded-lg border border-slate-200 overflow-hidden mb-8">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-semibold leading-relaxed text-[#2C3E50] mb-4">Create New Ticket</h3>
            <form action="{{ route('tickets.store') }}" method="POST" class="space-y-4 max-w-2xl">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-[#2C3E50]">Issue Title</label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="e.g. Classroom 3A Projector not working"
                        class="mt-1 block w-full border {{ $errors->has('title') ? 'border-red-300' : 'border-slate-300' }} rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-[#2C3E50]">Detailed Description</label>
                    <textarea name="description" id="description" rows="3" required
                        class="mt-1 block w-full border {{ $errors->has('description') ? 'border-red-300' : 'border-slate-300' }} rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="priority" class="block text-sm font-medium text-[#2C3E50]">Priority</label>
                    <select name="priority" id="priority" class="mt-1 block w-full bg-white border border-slate-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="bg-white shadow rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold leading-relaxed text-[#2C3E50]">All Tickets</h3>

            <form method="GET" action="{{ route('ticket') }}" class="grid grid-cols-1 gap-3 md:grid-cols-12">
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
                        <a href="{{ route('ticket') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">Reset filter</a>
                    </div>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Title / Desc</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Submitted By</th>
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-normal text-[#2C3E50]">{{ $ticket->user->name ?? 'Unknown' }}</div>
                            </td>
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
                                <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="block w-full pl-3 pr-10 py-1 text-base border-slate-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm">
                                        <option value="submitted" {{ $ticket->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                        <option value="ongoing" {{ $ticket->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                        <option value="done" {{ $ticket->status === 'done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm font-normal text-slate-500 text-center">
                                No tickets found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
