@extends('layout.app')

@section('title', 'Devices')

@section('content')

<div class="min-h-full bg-slate-50/70">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6.5A2.5 2.5 0 016.5 4h11A2.5 2.5 0 0120 6.5v11a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 014 17.5v-11z"/>
                </svg>
                Device Management
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Devices
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage registered workstations and monitor their current status.
            </p>
        </div>
        
        {{-- Add Device --}}
        @if(auth()->user()->isSuperAdmin())
        <a
            href="{{ route('device.create') }}"
            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200"
        >
            <svg class="h-4.5 w-4.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 5v14m-7-7h14"/>
            </svg>
            Add Device
        </a>
        @endif
    </div>

    {{-- Filters --}}
    <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center">

            {{-- Search --}}
            <form class="w-full flex-1" method="GET" action="{{ route('device') }}">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <label for="search" class="sr-only">Search devices</label>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"/>
                        </svg>
                    </div>

                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-11 pr-11 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="Search by device code or name..."
                    />

                    @if(request('search'))
                        <a
                            href="{{ route('device', request('status') ? ['status' => request('status')] : []) }}"
                            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                            title="Clear search"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10 7.293 11.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>

            {{-- Status Filter --}}
            <form action="{{ route('device') }}" method="GET" class="w-full lg:w-48">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <label for="status" class="sr-only">Status</label>

                <select
                    id="status"
                    name="status"
                    onchange="this.form.submit()"
                    class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 px-4 text-sm font-medium text-slate-700 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                >
                    <option value="">All Status</option>
                    <option value="paired" @selected(request('status') === 'paired')>Paired</option>
                    <option value="unpaired" @selected(request('status') === 'unpaired')>Unpaired</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Devices Table --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex flex-col gap-2 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 6.5A2.5 2.5 0 016.5 4h11A2.5 2.5 0 0120 6.5v11a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 014 17.5v-11z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-base font-bold text-slate-900">
                            Registered Devices
                        </h2>
                        <p class="text-xs text-slate-500">
                            Workstations connected to your system.
                        </p>
                    </div>
                </div>
            </div>

            <div class="inline-flex w-fit items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                {{ $devices->total() }} {{ Str::plural('device', $devices->total()) }}
            </div>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="border-b border-slate-100 bg-slate-50/70 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold sm:px-8">
                            Device
                        </th>
                        <th scope="col" class="px-6 py-4 font-semibold sm:px-8">
                            Workstation Name
                        </th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-4 text-center font-semibold sm:px-8">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($devices as $device)
                        <tr class="group bg-white transition-colors hover:bg-blue-50/30">

                            {{-- Device Code --}}
                            <td class="px-6 py-5 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500 transition-colors group-hover:bg-blue-100 group-hover:text-blue-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M4 6.5A2.5 2.5 0 016.5 4h11A2.5 2.5 0 0120 6.5v11a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 014 17.5v-11z"/>
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-mono text-sm font-semibold text-slate-800">
                                            {{ $device->device_uid }}
                                        </p>
                                        <p class="mt-0.5 text-xs text-slate-400">
                                            Device Code
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Workstation --}}
                            <td class="px-6 py-5 sm:px-8">
                                <p class="font-semibold text-slate-800">
                                    {{ $device->workstation_name }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    Workstation
                                </p>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5 text-center">
                                @if($device->is_paired)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Paired
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Not Paired
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-5 sm:px-8">
                                <div class="flex items-center justify-center">

                                    <button
                                        type="button"
                                        class="device-manage inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                                        data-device-name="{{ $device->workstation_name }} ({{ $device->device_uid }})"
                                        data-view-url="{{ route('device.show', $device->id) }}"
                                        data-lock-url="{{ route('device.lock', $device->id) }}"
                                        data-announce-url="{{ route('device.announce', $device->id) }}"
                                        @if(auth()->user()->isSuperAdmin())
                                            data-edit-url="{{ route('device.edit', $device->id) }}"
                                            data-delete-url="{{ route('device.destroy', $device->id) }}"
                                            data-delete-message="Are you sure you want to delete {{ $device->workstation_name }} ({{ $device->device_uid }})? This action cannot be undone."
                                        @endif
                                        aria-haspopup="menu"
                                        aria-expanded="false"
                                        title="Manage this device"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" d="M4 7h16M4 17h16"/>
                                            <circle cx="9" cy="7" r="2"/>
                                            <circle cx="15" cy="17" r="2"/>
                                        </svg>

                                        Manage

                                        <svg class="device-manage-chevron h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>

                                    <h3 class="mt-4 text-base font-bold text-slate-800">
                                        No devices found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Try adjusting your search or status filter.
                                    </p>

                                    @if(request('search') || request('status'))
                                        <a
                                            href="{{ route('device') }}"
                                            class="mt-4 inline-flex items-center rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                                        >
                                            Clear Filters
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($devices->hasPages())
        <div class="mt-6">
            {{ $devices->onEachSide(1)->links('vendor.pagination.flowbite') }}
        </div>
    @endif

    {{-- Shared Manage menu. One fixed node for every row so the table's
         overflow-x-auto wrapper cannot clip it. --}}
    <div
        id="device-actions-menu"
        class="fixed z-50 hidden w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white p-1.5 shadow-xl"
        role="menu"
        aria-label="Manage device"
    >

        <div class="px-3 pb-1.5 pt-2">
            <p
                id="device-actions-menu-title"
                class="truncate text-xs font-semibold text-slate-900"
            ></p>
        </div>


        <a
            id="device-menu-view"
            href="#"
            class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-blue-50 hover:text-blue-700"
            role="menuitem"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0Z"/>
            </svg>

            View Device
        </a>


        <button
            type="button"
            class="device-menu-lock flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-amber-50 hover:text-amber-700"
            role="menuitem"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>

            Remote Lock
        </button>


        <button
            type="button"
            class="device-menu-announce flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-sky-50 hover:text-sky-700"
            role="menuitem"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
            </svg>

            Send Announcement
        </button>


        @if(auth()->user()->isSuperAdmin())
            <div class="my-1 h-px bg-slate-100"></div>

            <a
                id="device-menu-edit"
                href="#"
                class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-amber-50 hover:text-amber-700"
                role="menuitem"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>

                Edit Device
            </a>


            <button
                type="button"
                class="device-menu-delete flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700"
                role="menuitem"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>

                Delete Device
            </button>
        @endif

    </div>


    <style>
        .device-manage-chevron {
            transition: transform 160ms ease;
        }

        .device-manage[aria-expanded="true"] .device-manage-chevron {
            transform: rotate(180deg);
        }
    </style>


    <script>
        (function () {

            const menuEl =
                document.getElementById('device-actions-menu');

            const titleEl =
                document.getElementById('device-actions-menu-title');

            const viewEl =
                document.getElementById('device-menu-view');

            const editEl =
                document.getElementById('device-menu-edit');

            let activeButton = null;


            if (!menuEl) {
                return;
            }


            function closeMenu() {

                if (menuEl.classList.contains('hidden')) {
                    return;
                }

                menuEl.classList.add('hidden');

                if (activeButton) {
                    activeButton.setAttribute('aria-expanded', 'false');
                    activeButton = null;
                }

            }


            function positionMenu(button) {

                const rect = button.getBoundingClientRect();
                const gap = 8;

                menuEl.classList.remove('hidden');

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

            }


            function openMenu(button) {

                if (activeButton === button) {
                    closeMenu();
                    return;
                }

                closeMenu();

                titleEl.textContent =
                    button.getAttribute('data-device-name') || 'Device';

                if (viewEl) {
                    viewEl.href =
                        button.getAttribute('data-view-url') || '#';
                }

                if (editEl) {
                    editEl.href =
                        button.getAttribute('data-edit-url') || '#';
                }

                menuEl.dataset.lockUrl =
                    button.getAttribute('data-lock-url') || '';

                menuEl.dataset.announceUrl =
                    button.getAttribute('data-announce-url') || '';

                menuEl.dataset.deleteUrl =
                    button.getAttribute('data-delete-url') || '';

                menuEl.dataset.deleteMessage =
                    button.getAttribute('data-delete-message') || '';

                menuEl.dataset.deviceName =
                    button.getAttribute('data-device-name') || 'this PC';

                activeButton = button;

                button.setAttribute('aria-expanded', 'true');

                positionMenu(button);

            }


            document.addEventListener('click', function (event) {

                const button = event.target.closest('.device-manage');

                if (!button) {
                    return;
                }

                event.stopPropagation();

                openMenu(button);

            });


            menuEl.querySelector('.device-menu-lock')
                .addEventListener('click', function () {

                    const url = menuEl.dataset.lockUrl;
                    const deviceName = menuEl.dataset.deviceName;

                    closeMenu();

                    if (!url || typeof openRemoteLockModal !== 'function') {
                        return;
                    }

                    openRemoteLockModal(url, deviceName);

                });


            menuEl.querySelector('.device-menu-announce')
                .addEventListener('click', function () {

                    const url = menuEl.dataset.announceUrl;
                    const deviceName = menuEl.dataset.deviceName;

                    closeMenu();

                    if (!url || typeof openRemoteAnnounceModal !== 'function') {
                        return;
                    }

                    openRemoteAnnounceModal(url, deviceName);

                });


            const deleteEl =
                menuEl.querySelector('.device-menu-delete');

            if (deleteEl) {

                deleteEl.addEventListener('click', function () {

                    const url = menuEl.dataset.deleteUrl;
                    const message = menuEl.dataset.deleteMessage;

                    closeMenu();

                    if (!url || typeof openDeleteModal !== 'function') {
                        return;
                    }

                    openDeleteModal(url, message);

                });

            }


            [viewEl, editEl].forEach(function (link) {

                if (link) {
                    link.addEventListener('click', closeMenu);
                }

            });


            document.addEventListener('click', function (event) {

                if (menuEl.classList.contains('hidden')) {
                    return;
                }

                if (menuEl.contains(event.target)) {
                    return;
                }

                if (event.target.closest('.device-manage')) {
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
    <x-remote-announce-modal />
    
    <x-error-modal />

</div>


</div>
@endsection
