<aside class="w-full shrink-0 bg-white border-b border-slate-200 overflow-x-auto md:h-[calc(100vh-4rem)] md:w-64 md:border-b-0 md:border-r md:overflow-y-auto">
    <nav class="flex gap-2 p-3 md:block md:space-y-1 md:p-4">

        <a href="{{ route('dashboard') }}"
           class="flex shrink-0 items-center px-4 py-3 text-sm font-medium rounded-lg
           {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-[#2C3E50] hover:bg-blue-50' }}">

            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4l4 2m-8-4l4-2">
                </path>
            </svg>

            Dashboard
        </a>

        <a href="{{ route('ticket') }}"
           class="flex shrink-0 items-center px-4 py-3 text-sm font-medium rounded-lg
           {{ request()->routeIs('ticket') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-[#2C3E50] hover:bg-blue-50' }}">

            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>

            Tickets
        </a>

    </nav>
</aside>
