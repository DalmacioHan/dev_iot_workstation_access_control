@extends('layout.app')

@section('title', 'Workstation Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Top Back Link --}}
    <div class="mb-6">
        <a href="{{ route('workstation') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Workstations
        </a>
    </div>

    {{-- Main Header Card --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-100 pb-6 mb-6">
            <div>
                <div class="flex items-center space-x-3 flex-wrap gap-y-2">
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $workstation->pc_code ?? 'Workstation Name' }}
                    </h1>

                    {{-- Active Badge --}}
                    @if(($workstation->is_active ?? true))
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                            Inactive
                        </span>
                    @endif

                    {{-- Online/Offline Badge --}}
                    @if(!empty($workstation->last_seen_at) && $workstation->last_seen_at->diffInMinutes(now()) < 5)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full animate-pulse"></span> Online
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                            <span class="w-1.5 h-1.5 mr-1.5 bg-gray-500 rounded-full"></span> Offline
                        </span>
                    @endif
                </div>

                <p class="text-sm text-gray-500 mt-2">
                    Device UID:
                    <span class="font-mono text-gray-700 font-medium">
                        {{ $deviceUid ?? '—' }}
                    </span>
                </p>
            </div>

            <div class="mt-4 md:mt-0">
                <a href="#"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5h2m-1-1v2m-7 5h14M5 12h14m-7 0v8"/>
                    </svg>
                    Edit Workstation
                </a>
            </div>
        </div>

        {{-- Essentials Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">



            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Last Seen</p>
                <p class="mt-2 text-base font-semibold text-gray-800">
                    {{ !empty($workstation->last_seen_at) ? $workstation->last_seen_at->format('M d, Y h:i A') : 'Never' }}
                </p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Last Logged Student</p>
                <p class="mt-2 text-base font-semibold text-gray-800 font-mono">
                    {{-- //query the log table and get the latest log entry for this workstation and display the student id and name if the workstation is currently in use, otherwise display "Not in Use" --}}
                    {{ $workstation->most_recent_student ?? 'Available' }}
                </p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">PC PORT</p>
                <p class="mt-2 text-base font-semibold text-gray-800">
                    {{ $workstation->location ?? '' }}
                </p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">STUDENT COURSE</p>
                <p class="mt-2 text-base font-semibold text-gray-800">
                    {{ $workstation->pc_port ?? '—' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Notes / Remarks Card --}}
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-gray-900">Recent Connection Errors</h2>
        <p class="mt-3 text-sm leading-relaxed text-gray-600">
            {{ $workstation->notes ?? 'No notes available for this workstation yet.' }}
        </p>
    </div>
</div>
@endsection