@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl font-semibold text-[#2C3E50]">Dashboard</h1>
        <p class="text-sm font-normal text-slate-500">
            {{ Auth::user()->role === 'admin' ? 'Overview seluruh ticket masuk' : 'Overview ticket ' }}
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <section class="bg-white shadow rounded-lg border border-slate-200 p-5 lg:col-span-8">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-[#2C3E50]">Ticket Status Overview</h2>
                    <p class="mt-1 text-sm text-slate-500">Total ticket: {{ $totalTickets }}</p>
                </div>
                <a href="{{ route('ticket') }}" class="shrink-0 rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-500">
                    View Tickets
                </a>
            </div>

            <div class="mt-6 grid min-h-72 grid-cols-3 items-end gap-4 border-b border-l border-slate-200 px-4 pb-4">
                @php
                    $chartItems = [
                        ['label' => 'Submitted', 'value' => $statusCounts['submitted'], 'color' => 'bg-slate-500'],
                        ['label' => 'Ongoing', 'value' => $statusCounts['ongoing'], 'color' => 'bg-blue-600'],
                        ['label' => 'Done', 'value' => $statusCounts['done'], 'color' => 'bg-green-600'],
                    ];
                @endphp

                @foreach($chartItems as $item)
                    @php
                        $height = $item['value'] > 0 ? max(16, ($item['value'] / $maxStatusCount) * 100) : 4;
                        $heightClass = match (true) {
                            $height >= 90 => 'h-full',
                            $height >= 75 => 'h-3/4',
                            $height >= 50 => 'h-1/2',
                            $height >= 25 => 'h-1/4',
                            default => 'h-4',
                        };
                    @endphp
                    <div class="flex h-64 flex-col items-center justify-end gap-3">
                        <div class="text-sm font-semibold text-[#2C3E50]">{{ $item['value'] }}</div>
                        <div class="w-full max-w-24 rounded-t-md {{ $item['color'] }} {{ $heightClass }}"></div>
                        <div class="text-xs font-medium uppercase text-slate-500">{{ $item['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-white shadow rounded-lg border border-slate-200 p-5 lg:col-span-4">
            <h2 class="text-lg font-semibold text-[#2C3E50]">Recent Tickets</h2>
            <div class="mt-4 space-y-3">
                @forelse($recentTickets as $ticket)
                    <div class="border-b border-slate-100 pb-3 last:border-b-0 last:pb-0">
                        <div class="flex items-center justify-between gap-3">
                            <p class="truncate text-sm font-medium text-[#2C3E50]">{{ $ticket->title }}</p>
                            <span class="shrink-0 rounded-full px-2 py-0.5 text-xs font-semibold
                                {{ $ticket->status === 'done' ? 'bg-green-100 text-green-800' : ($ticket->status === 'ongoing' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700') }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ Auth::user()->role === 'admin' ? ($ticket->user->name ?? 'Unknown user') . ' - ' : '' }}{{ $ticket->created_at->format('M d, Y') }}
                        </p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada ticket.</p>
                @endforelse
            </div>
        </section>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="bg-white shadow rounded-lg border border-slate-200 p-5">
            <p class="text-sm font-medium text-slate-500">Submitted</p>
            <p class="mt-3 text-3xl font-semibold text-[#2C3E50]">{{ $statusCounts['submitted'] }}</p>
            <p class="mt-1 text-sm text-slate-500">Ticket belum diproses</p>
        </div>

        <div class="bg-white shadow rounded-lg border border-slate-200 p-5">
            <p class="text-sm font-medium text-slate-500">Ongoing</p>
            <p class="mt-3 text-3xl font-semibold text-blue-600">{{ $statusCounts['ongoing'] }}</p>
            <p class="mt-1 text-sm text-slate-500">Ticket sedang dikerjakan/di proses</p>
        </div>

        <div class="bg-white shadow rounded-lg border border-slate-200 p-5">
            <p class="text-sm font-medium text-slate-500">Done</p>
            <p class="mt-3 text-3xl font-semibold text-green-600">{{ $statusCounts['done'] }}</p>
            <p class="mt-1 text-sm text-slate-500">Ticket sudah selesai</p>
        </div>
    </div>
</div>
@endsection
