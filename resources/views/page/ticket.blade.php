@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-[#2C3E50]">Tickets</h1>
        <p class="text-sm font-normal text-slate-500">Manage and track all ticket requests</p>
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
    @endif
</div>
@endsection
