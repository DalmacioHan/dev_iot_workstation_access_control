@extends('layout.app')

@section('title', 'Device Details - ' . $device->workstation_name)

@section('content')

<div class="min-h-full bg-slate-50/70">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">


    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                <x-icon name="laptop" class="h-3.5 w-3.5" />
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
            <x-icon name="arrow-left" class="h-4 w-4" />
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
                        <x-icon name="laptop" class="h-7 w-7" />
                    </div>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="truncate text-2xl font-bold text-white sm:text-3xl">
                                {{ $device->workstation_name }}
                            </h2>

                            @if($device->is_paired)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-400/20 px-2.5 py-1 text-xs font-semibold text-emerald-100 ring-1 ring-inset ring-emerald-300/30">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                                    Paired
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-400/20 px-2.5 py-1 text-xs font-semibold text-red-100 ring-1 ring-inset ring-red-300/30">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-300"></span>
                                    Not Paired
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
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">

                    {{-- Manage --}}
                    <button
                        type="button"
                        id="device-detail-manage"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-white/30"
                        data-device-name="{{ $device->workstation_name }}"
                        data-lock-url="{{ route('device.lock', $device->id) }}"
                        data-unlock-url="{{ route('device.unlock', $device->id) }}"
                        data-announce-url="{{ route('device.announce', $device->id) }}"
                        @if(auth()->user()->isSuperAdmin())
                            data-edit-url="{{ route('device.edit', $device->id) }}"
                        @endif
                        aria-haspopup="menu"
                        aria-expanded="false"
                    >
                        <x-icon name="dots-horizontal" class="h-4 w-4" aria-hidden="true" />

                        Manage

                        <x-icon name="chevron-down" class="device-detail-chevron h-4 w-4" aria-hidden="true" />
                    </button>
                </div>
            </div>

            {{-- Device Metrics --}}
            <div class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:max-w-2xl">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                            <x-icon name="clock" class="h-5 w-5 text-blue-100" />
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

            </div>
        </div>
    </div>
    {{-- Device Activity --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <x-icon name="clock" class="h-5 w-5" />
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
            @if($accessLogs->isEmpty())
                <div class="flex min-h-[180px] flex-col items-center justify-center px-6 py-10 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <x-icon name="clock" class="h-6 w-6" />
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-slate-700">
                        No recent events
                    </h3>

                    <p class="mt-1 max-w-sm text-sm text-slate-400">
                        Device activity will appear here when events are reported by the workstation.
                    </p>
                </div>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach($accessLogs as $log)
                        <li class="flex flex-col gap-2 px-6 py-4 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wide
                                        {{ strtolower($log->result) === 'allowed'
                                            ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                            : 'border-red-200 bg-red-50 text-red-700' }}">
                                        {{ $log->event_type }}
                                    </span>
                                    <span class="text-xs text-slate-400">
                                        {{ $log->occurred_at?->diffForHumans() }}
                                    </span>
                                </div>

                                <p class="mt-1 truncate text-sm font-semibold text-slate-800">
                                    {{ $log->student_name ?: 'Unknown student' }}
                                </p>

                                <p class="mt-0.5 truncate text-xs text-slate-400">
                                    Student No: {{ $log->student_external_id ?: '—' }}
                                    
                                </p>
                            </div>

                            <span class="inline-flex w-fit shrink-0 items-center rounded-full border px-2.5 py-1 text-xs font-semibold
                                {{ strtolower($log->result) === 'allowed'
                                    ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                    : 'border-red-200 bg-red-50 text-red-700' }}">
                                {{ ucfirst(strtolower($log->result)) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Recent Staff Commands --}}
    <div class="mb-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <x-icon name="lock" class="h-5 w-5" />
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
                    <x-icon name="clock" class="h-6 w-6" />
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
                                @elseif($command->command === 'unlock')
                                    <span class="inline-flex items-center gap-1 rounded-full border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-emerald-700">
                                        Remote Unlock
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

    
    {{-- Manage menu (fixed so the hero card's overflow-hidden cannot clip it) --}}
    <div
        id="device-detail-menu"
        class="fixed z-50 hidden w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white p-1.5 shadow-xl"
        role="menu"
        aria-label="Manage device"
    >

        <div class="px-3 pb-1.5 pt-2">
            <p
                id="device-detail-menu-title"
                class="truncate text-xs font-semibold text-slate-900"
            ></p>
        </div>


        <button
            type="button"
            class="device-detail-lock flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-amber-50 hover:text-amber-700"
            role="menuitem"
        >
            <x-icon name="lock" class="h-4 w-4" aria-hidden="true" />

            Remote Lock
        </button>


        <button
            type="button"
            class="device-detail-unlock flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700"
            role="menuitem"
        >
            <x-icon name="lock-open" class="h-4 w-4" aria-hidden="true" />

            Remote Unlock
        </button>


        <button
            type="button"
            class="device-detail-announce flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-sky-50 hover:text-sky-700"
            role="menuitem"
        >
            <x-icon name="megaphone-a" class="h-4 w-4" aria-hidden="true" />

            Send Announcement
        </button>


        @if(auth()->user()->isSuperAdmin())
            <div class="my-1 h-px bg-slate-100"></div>

            <a
                id="device-detail-edit"
                href="{{ route('device.edit', $device->id) }}"
                class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-blue-50 hover:text-blue-700"
                role="menuitem"
            >
                <x-icon name="edit" class="h-4 w-4" aria-hidden="true" />

                Edit Device
            </a>
        @endif

    </div>


    <style>
        .device-detail-chevron {
            transition: transform 160ms ease;
        }

        #device-detail-manage[aria-expanded="true"] .device-detail-chevron {
            transform: rotate(180deg);
        }
    </style>


    <script>
        (function () {

            const buttonEl =
                document.getElementById('device-detail-manage');

            const menuEl =
                document.getElementById('device-detail-menu');

            const titleEl =
                document.getElementById('device-detail-menu-title');

            if (!buttonEl || !menuEl) {
                return;
            }


            function closeMenu() {

                menuEl.classList.add('hidden');
                buttonEl.setAttribute('aria-expanded', 'false');

            }


            function openMenu() {

                titleEl.textContent =
                    buttonEl.getAttribute('data-device-name') || 'Device';

                menuEl.classList.remove('hidden');

                const rect = buttonEl.getBoundingClientRect();
                const gap = 8;

                const width = menuEl.offsetWidth;
                const height = menuEl.offsetHeight;

                const left = Math.min(
                    Math.max(gap, rect.right - width),
                    window.innerWidth - width - gap
                );

                let top = rect.bottom + gap;

                if (top + height > window.innerHeight - gap) {
                    top = rect.top - height - gap;
                }

                menuEl.style.left = Math.max(gap, left) + 'px';
                menuEl.style.top = Math.max(gap, top) + 'px';

                buttonEl.setAttribute('aria-expanded', 'true');

            }


            buttonEl.addEventListener('click', function (event) {

                event.stopPropagation();

                if (menuEl.classList.contains('hidden')) {
                    openMenu();
                } else {
                    closeMenu();
                }

            });


            menuEl.querySelector('.device-detail-lock')
                .addEventListener('click', function () {

                    const url =
                        buttonEl.getAttribute('data-lock-url');

                    const deviceName =
                        buttonEl.getAttribute('data-device-name') || 'this PC';

                    closeMenu();

                    if (!url || typeof openRemoteLockModal !== 'function') {
                        return;
                    }

                    openRemoteLockModal(url, deviceName);

                });


            menuEl.querySelector('.device-detail-unlock')
                .addEventListener('click', function () {

                    const url =
                        buttonEl.getAttribute('data-unlock-url');

                    const deviceName =
                        buttonEl.getAttribute('data-device-name') || 'this PC';

                    closeMenu();

                    if (!url || typeof openRemoteUnlockModal !== 'function') {
                        return;
                    }

                    openRemoteUnlockModal(url, deviceName);

                });


            menuEl.querySelector('.device-detail-announce')
                .addEventListener('click', function () {

                    const url =
                        buttonEl.getAttribute('data-announce-url');

                    const deviceName =
                        buttonEl.getAttribute('data-device-name') || 'this PC';

                    closeMenu();

                    if (!url || typeof openRemoteAnnounceModal !== 'function') {
                        return;
                    }

                    openRemoteAnnounceModal(url, deviceName);

                });


            const editEl =
                document.getElementById('device-detail-edit');

            if (editEl) {
                editEl.addEventListener('click', closeMenu);
            }


            document.addEventListener('click', function (event) {

                if (menuEl.classList.contains('hidden')) {
                    return;
                }

                if (menuEl.contains(event.target)) {
                    return;
                }

                if (buttonEl.contains(event.target)) {
                    return;
                }

                closeMenu();

            });


            document.addEventListener('keydown', function (event) {

                if (event.key === 'Escape') {
                    closeMenu();
                }

            });


            window.addEventListener('scroll', closeMenu, true);
            window.addEventListener('resize', closeMenu);

        })();
    </script>


<x-remote-lock-modal />
<x-remote-unlock-modal />
<x-remote-announce-modal />

</div>


</div>
@endsection
