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

</div>


</div>
@endsection
