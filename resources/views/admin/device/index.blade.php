@extends('layout.app')

@section('title', 'Devices')

@section('content')

<div class="min-h-full bg-slate-50/70">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                <x-icon name="laptop" class="h-3.5 w-3.5" />
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
            <x-icon name="plus" class="h-4.5 w-4.5" aria-hidden="true" />
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

                <label for="search" class="sr-only">Search Workstation</label>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <x-icon name="search" class="h-5 w-5 text-slate-400" />
                    </div>

                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-11 pr-11 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="Search by workstation name..."
                    />

                    @if(request('search'))
                        <a
                            href="{{ route('device', request('status') ? ['status' => request('status')] : []) }}"
                            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                            title="Clear search"
                        >
                            <x-icon name="information-circle" class="h-5 w-5" />
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

    {{-- Bulk actions --}}
    <div id="bulk-actions-bar" class="mb-4 hidden rounded-2xl border border-blue-200 bg-blue-50/60 p-3 shadow-sm sm:p-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-blue-600 px-2 text-xs font-bold text-white" id="bulk-selected-count">0</span>
                <span class="text-sm font-semibold text-slate-800">device(s) selected</span>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" id="bulk-lock-btn" class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-200">
                    <x-icon name="lock" class="h-4 w-4" />
                    Remote Lock
                </button>
                <button type="button" id="bulk-unlock-btn" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200">
                    <x-icon name="lock-open" class="h-4 w-4" />
                    Remote Unlock
                </button>
                <button type="button" id="bulk-announce-btn" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200">
                    <x-icon name="megaphone-a" class="h-4 w-4" />
                    Announce
                </button>
                @if(auth()->user()->isSuperAdmin())
                <button type="button" id="bulk-delete-btn" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-200">
                    <x-icon name="trash" class="h-4 w-4" />
                    Delete
                </button>
                @endif
                <button type="button" id="bulk-clear-btn" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200">
                    Clear
                </button>
            </div>
        </div>
    </div>

    {{-- Devices Table --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex flex-col gap-2 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <x-icon name="laptop" class="h-5 w-5" />
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
                        <th scope="col" class="px-4 py-4 sm:px-6">
                            <input id="select-all-devices" type="checkbox" class="h-4 w-4 cursor-pointer rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500" title="Select all on this page">
                        </th>
                        <th scope="col" class="px-4 py-4 font-semibold sm:px-6">
                            Workstation Name
                        </th>
                        <th scope="col" class="px-4 py-4 text-center font-semibold">
                            Pairing
                        </th>
                        <th scope="col" class="px-4 py-4 text-center font-semibold">
                            Activity
                        </th>
                        <th scope="col" class="px-4 py-4 text-center font-semibold sm:px-6">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($devices as $device)
                        @php
                            $inUse = isset($inUseDeviceIds) && $inUseDeviceIds->contains($device->id);
                        @endphp
                        <tr class="group bg-white transition-colors hover:bg-blue-50/30">
                            <td class="px-4 py-5 sm:px-6">
                                <input type="checkbox" class="device-select h-4 w-4 cursor-pointer rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500" value="{{ $device->id }}" data-name="{{ $device->workstation_name }}">
                            </td>

                            {{-- Workstation --}}
                            <td class="px-4 py-5 sm:px-6">
                                <p class="font-semibold text-slate-800">
                                    {{ $device->workstation_name }}
                                </p>

                                <p class="mt-0.5 text-xs text-slate-400">
                                    Workstation
                                    @if($device->last_seen_at)
                                        · Last seen {{ $device->last_seen_at->diffForHumans() }}
                                    @endif
                                </p>
                            </td>

                            {{-- Pairing Status --}}
                            <td class="px-4 py-5 text-center">
                                @if($device->is_paired)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Paired
                                    </span>
                                @else
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Not Paired
                                        </span>
                                        @if(!empty($device->pairing_code))
                                            <span class="font-mono text-[11px] font-semibold tracking-wider text-slate-500" title="Pairing code">
                                                {{ $device->pairing_code }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>

                            {{-- Activity Status --}}
                            <td class="px-4 py-5 text-center">
                                @if($inUse)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700" title="A session is currently logged in on this device">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                        In Use
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600" title="No active session logged in">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Offline
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-5 sm:px-6">
                                <div class="flex items-center justify-center">

                                    <button
                                        type="button"
                                        class="device-manage inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                                        data-device-name="{{ $device->workstation_name }}"
                                        data-view-url="{{ route('device.show', $device->id) }}"
                                        data-lock-url="{{ route('device.lock', $device->id) }}"
                                        data-unlock-url="{{ route('device.unlock', $device->id) }}"
                                        data-announce-url="{{ route('device.announce', $device->id) }}"
                                        @if(auth()->user()->isSuperAdmin())
                                            data-edit-url="{{ route('device.edit', $device->id) }}"
                                            data-delete-url="{{ route('device.destroy', $device->id) }}"
                                            data-delete-message="Are you sure you want to delete {{ $device->workstation_name }}? This action cannot be undone."
                                        @endif
                                        aria-haspopup="menu"
                                        aria-expanded="false"
                                        title="Manage this device"
                                    >
                                        <x-icon name="dots-horizontal" class="h-3.5 w-3.5" aria-hidden="true" />

                                        Manage

                                        <x-icon name="chevron-down" class="device-manage-chevron h-3 w-3" aria-hidden="true" />
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <x-icon name="wifi" class="h-8 w-8" />
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
            <x-icon name="eye" class="h-4 w-4" aria-hidden="true" />

            View Device
        </a>


        <button
            type="button"
            class="device-menu-lock flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-amber-50 hover:text-amber-700"
            role="menuitem"
        >
            <x-icon name="lock" class="h-4 w-4" aria-hidden="true" />

            Remote Lock
        </button>


        <button
            type="button"
            class="device-menu-unlock flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700"
            role="menuitem"
        >
            <x-icon name="lock-open" class="h-4 w-4" aria-hidden="true" />

            Remote Unlock
        </button>


        <button
            type="button"
            class="device-menu-announce flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-sky-50 hover:text-sky-700"
            role="menuitem"
        >
            <x-icon name="megaphone-a" class="h-4 w-4" aria-hidden="true" />

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
                <x-icon name="edit" class="h-4 w-4" aria-hidden="true" />

                Edit Device
            </a>


            <button
                type="button"
                class="device-menu-delete flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700"
                role="menuitem"
            >
                <x-icon name="trash" class="h-4 w-4" aria-hidden="true" />

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

            const menuEl = document.getElementById('device-actions-menu');
            const titleEl = document.getElementById('device-actions-menu-title');
            const viewEl = document.getElementById('device-menu-view');
            const editEl = document.getElementById('device-menu-edit');
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

                titleEl.textContent = button.getAttribute('data-device-name') || 'Device';

                if (viewEl) {
                    viewEl.href = button.getAttribute('data-view-url') || '#';
                }

                if (editEl) {
                    editEl.href = button.getAttribute('data-edit-url') || '#';
                }

                menuEl.dataset.lockUrl = button.getAttribute('data-lock-url') || '';
                menuEl.dataset.unlockUrl = button.getAttribute('data-unlock-url') || '';
                menuEl.dataset.announceUrl = button.getAttribute('data-announce-url') || '';
                menuEl.dataset.deleteUrl = button.getAttribute('data-delete-url') || '';
                menuEl.dataset.deleteMessage = button.getAttribute('data-delete-message') || '';
                menuEl.dataset.deviceName = button.getAttribute('data-device-name') || 'this PC';

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

            menuEl.querySelector('.device-menu-lock')?.addEventListener('click', function () {
                const url = menuEl.dataset.lockUrl;
                const deviceName = menuEl.dataset.deviceName;
                closeMenu();
                if (!url || typeof openRemoteLockModal !== 'function') {
                    return;
                }
                openRemoteLockModal(url, deviceName);
            });

            menuEl.querySelector('.device-menu-unlock')?.addEventListener('click', function () {
                const url = menuEl.dataset.unlockUrl;
                const deviceName = menuEl.dataset.deviceName;
                closeMenu();
                if (!url || typeof openRemoteUnlockModal !== 'function') {
                    return;
                }
                openRemoteUnlockModal(url, deviceName);
            });

            menuEl.querySelector('.device-menu-announce')?.addEventListener('click', function () {
                const url = menuEl.dataset.announceUrl;
                const deviceName = menuEl.dataset.deviceName;
                closeMenu();
                if (!url || typeof openRemoteAnnounceModal !== 'function') {
                    return;
                }
                openRemoteAnnounceModal(url, deviceName);
            });

            const deleteEl = menuEl.querySelector('.device-menu-delete');
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

            // ---- Bulk selection & actions ----
            const selectAll = document.getElementById('select-all-devices');
            const rowChecks = Array.from(document.querySelectorAll('.device-select'));
            const bar = document.getElementById('bulk-actions-bar');
            const countEl = document.getElementById('bulk-selected-count');
            const bulkLockBtn = document.getElementById('bulk-lock-btn');
            const bulkUnlockBtn = document.getElementById('bulk-unlock-btn');
            const bulkAnnounceBtn = document.getElementById('bulk-announce-btn');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const clearBtn = document.getElementById('bulk-clear-btn');

            function getSelected() {
                return rowChecks.filter(cb => cb.checked).map(cb => ({
                    id: cb.value,
                    name: cb.getAttribute('data-name') || 'Device'
                }));
            }

            function updateBulkUi() {
                const selected = getSelected();
                const count = selected.length;

                if (countEl) countEl.textContent = String(count);
                if (bar) bar.classList.toggle('hidden', count === 0);

                if (selectAll) {
                    if (count === 0) {
                        selectAll.checked = false;
                        selectAll.indeterminate = false;
                    } else if (count === rowChecks.length && rowChecks.length > 0) {
                        selectAll.checked = true;
                        selectAll.indeterminate = false;
                    } else {
                        selectAll.checked = false;
                        selectAll.indeterminate = true;
                    }
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    rowChecks.forEach(cb => { cb.checked = selectAll.checked; });
                    updateBulkUi();
                });
            }

            rowChecks.forEach(cb => cb.addEventListener('change', updateBulkUi));

            if (clearBtn) {
                clearBtn.addEventListener('click', function () {
                    rowChecks.forEach(cb => { cb.checked = false; });
                    if (selectAll) { selectAll.checked = false; selectAll.indeterminate = false; }
                    updateBulkUi();
                });
            }

            function selectedIds(selected) {
                return selected.map(s => s.id);
            }

            function selectedLabel(selected) {
                if (selected.length === 1) return selected[0].name;
                return selected.length + ' selected devices';
            }

            if (bulkLockBtn) {
                bulkLockBtn.addEventListener('click', function () {
                    const selected = getSelected();
                    if (selected.length === 0 || typeof openRemoteLockModal !== 'function') return;
                    openRemoteLockModal(@json(route('device.bulk-lock')), selectedLabel(selected), selectedIds(selected));
                });
            }

            if (bulkUnlockBtn) {
                bulkUnlockBtn.addEventListener('click', function () {
                    const selected = getSelected();
                    if (selected.length === 0 || typeof openRemoteUnlockModal !== 'function') return;
                    openRemoteUnlockModal(@json(route('device.bulk-unlock')), selectedLabel(selected), selectedIds(selected));
                });
            }

            if (bulkAnnounceBtn) {
                bulkAnnounceBtn.addEventListener('click', function () {
                    const selected = getSelected();
                    if (selected.length === 0 || typeof openRemoteAnnounceModal !== 'function') return;
                    openRemoteAnnounceModal(@json(route('device.bulk-announce')), selectedLabel(selected), selectedIds(selected));
                });
            }

            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function () {
                    const selected = getSelected();
                    if (selected.length === 0 || typeof openDeleteModal !== 'function') return;
                    openDeleteModal(
                        @json(route('device.bulk-delete')),
                        'Are you sure you want to delete ' + selected.length + ' selected device(s)? This action cannot be undone.',
                        selectedIds(selected)
                    );
                });
            }

            updateBulkUi();
        })();
    </script>


    <x-remote-lock-modal />
    <x-remote-unlock-modal />
    <x-remote-announce-modal />
    
    <x-error-modal />

</div>


</div>
@endsection
