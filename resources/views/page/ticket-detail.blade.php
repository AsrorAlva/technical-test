@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div class="space-y-1">
            <h1 class="text-2xl font-semibold text-[#2C3E50]">Ticket Detail</h1>
            <p class="text-sm font-normal text-slate-500">Detail informasi ticket dan status pengerjaan</p>
        </div>

        <a href="{{ route('ticket') }}" class="inline-flex w-fit items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-[#2C3E50] shadow-sm hover:bg-slate-50">
            Back to Tickets
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <section class="bg-white shadow rounded-lg border border-slate-200 p-5 lg:col-span-8">
            <div class="flex flex-col gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-[#2C3E50]">{{ $ticket->title }}</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Submitted by {{ $ticket->user->name ?? 'Unknown user' }} on {{ $ticket->created_at->format('M d, Y H:i') }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @if($ticket->priority === 'high')
                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">High Priority</span>
                    @elseif($ticket->priority === 'medium')
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">Medium Priority</span>
                    @else
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Low Priority</span>
                    @endif

                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                        {{ $ticket->status === 'done' ? 'bg-green-100 text-green-800' : ($ticket->status === 'ongoing' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700') }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
            </div>

            <div class="mt-5">
                <h3 class="text-sm font-semibold uppercase text-slate-500">Description</h3>
                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-[#2C3E50]">{{ $ticket->description }}</p>
            </div>
        </section>

        <aside class="bg-white shadow rounded-lg border border-slate-200 p-5 lg:col-span-4">
            <h2 class="text-lg font-semibold text-[#2C3E50]">Ticket Information</h2>

            <dl class="mt-4 space-y-4">
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-500">Submitted By</dt>
                    <dd class="mt-1 text-sm text-[#2C3E50]">{{ $ticket->user->name ?? 'Unknown user' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-500">Email</dt>
                    <dd class="mt-1 text-sm text-[#2C3E50]">{{ $ticket->user->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-500">Created At</dt>
                    <dd class="mt-1 text-sm text-[#2C3E50]">{{ $ticket->created_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-slate-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-[#2C3E50]">{{ $ticket->updated_at->format('M d, Y H:i') }}</dd>
                </div>
            </dl>

            @if(Auth::user()->role === 'admin')
                <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="mt-6 border-t border-slate-200 pt-5">
                    @csrf
                    @method('PATCH')
                    <label for="status" class="block text-sm font-medium text-[#2C3E50]">Update Status</label>
                    <select name="status" id="status" class="mt-2 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                        <option value="submitted" {{ $ticket->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="ongoing" {{ $ticket->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="done" {{ $ticket->status === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                    <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-500">
                        Save Status
                    </button>
                </form>
            @endif
        </aside>
    </div>
</div>
@endsection
