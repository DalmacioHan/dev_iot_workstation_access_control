@extends('layout.app')

@section('title', 'Device Details - ' . $device->workstation_name)

@section('content')

<div class="min-h-full bg-slate-50/70">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">


    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 3h6m-7 4h8m-9 0v14h10V7M9 7V3h6v4"/>
                </svg>
                Device Management
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Device Details
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Monitor the current status and activity of this workstation.
            </p>
        </div>

        <a
            href="{{ route('device') }}"
            class="inline-flex w-fit items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Devices
        </a>
    </div>

    {{-- Device Overview --}}
    <div class="relative mb-6 overflow-hidden rounded-3xl bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 p-6 shadow-lg sm:p-8">
        {{-- Decorative elements --}}
        <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -bottom-24 right-24 h-64 w-64 rounded-full bg-indigo-400/10"></div>

        <div class="relative">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                <div class="flex items-start gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/20 backdrop-blur-sm">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M4 6.5A2.5 2.5 0 016.5 4h11A2.5 2.5 0 0120 6.5v11a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 014 17.5v-11zM8 8h8v8H8V8zm-4 3h2m12 0h2M8 4v2m8-2v2m-8 12v2m8-2v2"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="truncate text-2xl font-bold text-white sm:text-3xl">
                                {{ $device->workstation_name }}
                            </h2>

                            @if($device->is_active)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-400/20 px-2.5 py-1 text-xs font-semibold text-emerald-100 ring-1 ring-inset ring-emerald-300/30">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-400/20 px-2.5 py-1 text-xs font-semibold text-red-100 ring-1 ring-inset ring-red-300/30">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-300"></span>
                                    Inactive
                                </span>
                            @endif

                            @if($device->last_seen_at && $device->last_seen_at->diffInMinutes(now()) < 5)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-2.5 py-1 text-xs font-semibold text-white ring-1 ring-inset ring-white/20">
                                    <span class="relative flex h-2 w-2">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-300 opacity-75"></span>
                                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-300"></span>
                                    </span>
                                    Online
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-2.5 py-1 text-xs font-semibold text-blue-100 ring-1 ring-inset ring-white/15">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-300"></span>
                                    Offline
                                </span>
                            @endif
                        </div>

                        <div class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-blue-100">
                            @if(!empty($device->pairing_code))
                                <span>Pairing Code</span>
                                <span class="font-mono font-semibold text-white">
                                    {{ $device->pairing_code }}
                                </span>
                            @else
                                <span>Device Code</span>
                                <span class="font-mono font-semibold text-white">
                                    {{ $device->device_uid }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">

                    {{-- Remote Lock (one-click) --}}
                    <button
                        type="button"
                        onclick="openRemoteLockModal('{{ route('device.lock', $device->id) }}', '{{ $device->workstation_name }} ({{ $device->device_uid }})')"
                        style="background-color:#f59e0b;color:#ffffff;"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-300/50"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        Remote Lock
                    </button>

                    {{-- Send Announcement (one-click) --}}
                    <button
                        type="button"
                        onclick="openRemoteAnnounceModal('{{ route('device.announce', $device->id) }}', '{{ $device->workstation_name }} ({{ $device->device_uid }})')"
                        style="background-color:#0284c7;color:#ffffff;"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300/50"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
                        </svg>
                        Announcement
                    </button>

                    {{-- Actions dropdown --}}
                    <div class="relative">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-white/15 px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-inset ring-white/20 backdrop-blur-sm transition hover:bg-white/25 focus:outline-none focus:ring-4 focus:ring-white/30"
                            data-dropdown-toggle="dropdown-device-actions"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                            </svg>
                            Actions
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>

                        <div
                            id="dropdown-device-actions"
                            class="absolute right-0 z-50 mt-2 hidden w-56 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xl"
                        >
                            <ul class="p-2 text-sm text-gray-700">
                                <li>
                                    <button
                                        type="button"
                                        onclick="openRemoteLockModal('{{ route('device.lock', $device->id) }}', '{{ $device->workstation_name }} ({{ $device->device_uid }})')"
                                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left transition hover:bg-amber-50 hover:text-amber-700"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                  d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                        Remote Lock PC
                                    </button>
                                </li>

                                <li>
                                    <button
                                        type="button"
                                        onclick="openRemoteAnnounceModal('{{ route('device.announce', $device->id) }}', '{{ $device->workstation_name }} ({{ $device->device_uid }})')"
                                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left transition hover:bg-sky-50 hover:text-sky-700"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                  d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
                                        </svg>
                                        Send Announcement
                                    </button>
                                </li>

                                <li>
                                    <a
                                        href="{{ route('device.edit', $device->id) }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-blue-50 hover:text-blue-600"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit Device
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Edit Device --}}
                    <a
                        href="{{ route('device.edit', $device->id) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-white/30"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit Device
                    </a>
                </div>
            </div>

            {{-- Device Metrics --}}
            <div class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:max-w-2xl">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                            <svg class="h-5 w-5 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-blue-200">
                                Last Seen
                            </p>
                            <p class="mt-0.5 text-lg font-bold text-white">
                                {{ $device->last_seen_at ? $device->last_seen_at->diffForHumans() : 'Never' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                            <svg class="h-5 w-5 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 12c0 5.591 3.824 10.29 9 11.622C17.176 22.29 21 17.591 21 12c0-1.47-.267-2.878-.764-4.176z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-blue-200">
                                Connection
                            </p>

                            <p class="mt-0.5 text-lg font-bold text-white">
                                @if($device->last_seen_at && $device->last_seen_at->diffInMinutes(now()) < 5)
                                    Connected
                                @else
                                    No Recent Signal
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Staff Commands --}}
    <div class="mb-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </div>

                    <h2 class="text-lg font-bold text-slate-900">
                        Recent Staff Commands
                    </h2>
                </div>

                <p class="mt-1 pl-11 text-sm text-slate-500">
                    Staff-issued remote locks and announcements, and their delivery status.
                </p>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                {{ $commands->count() }} {{ Str::plural('command', $commands->count()) }}
            </span>
        </div>

        @if($commands->isEmpty())
            <div class="flex min-h-[140px] flex-col items-center justify-center px-6 py-8 text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-700">
                    No staff commands yet
                </h3>

                <p class="mt-1 max-w-sm text-sm text-slate-400">
                    Lock and announcement commands issued from the Devices page will appear here.
                </p>
            </div>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach($commands as $command)
                    <li class="flex flex-col gap-2 px-6 py-4 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                        <div class="min-w-0">
                            <span class="mb-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wide">
                                @if($command->command === 'announcement')
                                    <span class="inline-flex items-center gap-1 rounded-full border border-sky-200 bg-sky-50 px-2 py-0.5 text-sky-700">
                                        Announcement
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full border border-violet-200 bg-violet-50 px-2 py-0.5 text-violet-700">
                                        Remote Lock
                                    </span>
                                @endif
                            </span>
                            <p class="truncate text-sm font-semibold text-slate-800">
                                {{ $command->message ?: 'Generic logout message (blank)' }}
                            </p>
                            <p class="mt-0.5 text-xs text-slate-400">
                                Issued {{ $command->created_at?->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex shrink-0 items-center gap-3">
                            @if($command->status === 'completed')
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Received
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                    <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @endif

                            @if($command->acknowledged_at)
                                <span class="text-xs text-slate-400">
                                    {{ $command->acknowledged_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Device Activity --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <h2 class="text-lg font-bold text-slate-900">
                        Recent Device Events
                    </h2>
                </div>

                <p class="mt-1 pl-11 text-sm text-slate-500">
                    Latest activity reported by this workstation.
                </p>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                Activity Log
            </span>
        </div>

        <div class="min-h-[180px]">
            {{-- Recent events can be rendered here --}}
            <div class="flex min-h-[180px] flex-col items-center justify-center px-6 py-10 text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-700">
                    No recent events
                </h3>

                <p class="mt-1 max-w-sm text-sm text-slate-400">
                    Device activity will appear here when events are reported by the workstation.
                </p>
            </div>
        </div>
    </div>

<x-remote-lock-modal />
<x-remote-announce-modal />

</div>


</div>
@endsection
