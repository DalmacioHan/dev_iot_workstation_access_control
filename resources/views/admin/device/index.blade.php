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
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
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
                                @if($device->is_active)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-5 sm:px-8">
                                <div class="flex items-center justify-center gap-1">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('device.show', $device->id) }}"
                                        class="group/action rounded-xl p-2.5 text-slate-400 transition hover:bg-blue-50 hover:text-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-100"
                                        title="View Details"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0Z"/>
                                        </svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('device.edit', $device->id) }}"
                                        class="rounded-xl p-2.5 text-slate-400 transition hover:bg-amber-50 hover:text-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-100"
                                        title="Edit"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('device.destroy', $device->id) }}', 'Are you sure you want to delete {{ $device->workstation_name }} ({{ $device->device_uid }})? This action cannot be undone.')"
                                        class="rounded-xl p-2.5 text-slate-400 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-4 focus:ring-red-100"
                                        title="Delete"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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

</div>


</div>
@endsection
