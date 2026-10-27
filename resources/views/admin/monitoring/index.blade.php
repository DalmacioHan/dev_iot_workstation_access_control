@extends('layout.app')

@section('title', 'Monitoring')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Workstation Monitoring
            </h1>


            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
                Monitor registered workstation devices, access events,
                device commands, and application usage.
            </p>

        </div>


        <div class="flex flex-wrap items-center gap-3">


            <button type="button" id="refresh-monitoring" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">

                <svg id="refresh-icon" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 11a8 8 0 1 0-2.34 5.66M20 4v7h-7" />
                </svg>

                Refresh

            </button>

        </div>

    </div>


    {{-- =========================================================
        SUMMARY CARDS
    ========================================================== --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Active devices --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="4" y="4" width="16" height="16" rx="2" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-width="1.8" d="M15 2v2M9 2v2M15 20v2M9 20v2M20 15h2M20 9h2M2 15h2M2 9h2" />
                    </svg>

                </div>


                <span class="rounded-lg bg-emerald-50 px-2 py-1 text-[11px] font-semibold text-emerald-700">
                    Enabled
                </span>

            </div>


            <p class="mt-5 text-3xl font-bold text-gray-900">
                {{ $activeDevices }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Active devices
            </p>

        </div>


        {{-- Inactive --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-500">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="13" rx="2" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-width="1.8" d="M9 21h6M12 17v4" />
                    </svg>

                </div>

            </div>


            <p class="mt-5 text-3xl font-bold text-gray-900">
                {{ $inactiveDevices }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Inactive devices
            </p>

        </div>


        {{-- Granted --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m8 12 2.5 2.5L16 9" />
                    </svg>

                </div>

            </div>


            <p class="mt-5 text-3xl font-bold text-gray-900">
                {{ $grantedAccess }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Granted access events this week
            </p>

        </div>


        {{-- Pending commands --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-width="1.8" d="M12 7v5l3 2" />
                    </svg>

                </div>

            </div>


            <p class="mt-5 text-3xl font-bold text-gray-900">
                {{ $pendingCommands }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Pending commands
            </p>

        </div>

    </div>


    {{-- =========================================================
        DEVICE MONITORING
    ========================================================== --}}
    <div class="mb-6 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="13" rx="2" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-width="1.8" d="M9 21h6M12 17v4" />
                    </svg>

                </div>


                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Workstation Devices
                    </h2>

                    <p class="text-sm text-gray-500">
                        Registered devices and recent communication.
                    </p>

                </div>

            </div>


            <div class="relative">

                <input type="text" id="device-search" placeholder="Search workstation..." class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-9 pr-4 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50 sm:w-64">

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="border-b border-gray-100 bg-gray-50/80 text-[11px] font-semibold uppercase tracking-wider text-gray-400">

                    <tr>

                        <th class="px-6 py-3.5">
                            Workstation
                        </th>

                        <th class="px-6 py-3.5">
                            Device UID
                        </th>

                        <th class="px-6 py-3.5">
                            Pairing Code
                        </th>

                        <th class="px-6 py-3.5">
                            Last Seen
                        </th>



                        <th class="px-6 py-3.5">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach ($devices as $device)

                        <tr class="device-row transition hover:bg-gray-50/80" data-search="{{ strtolower($device['workstation_name'] . ' ' . $device['device_uid'] . ' ' . $device['pairing_code']) }}">

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $device['is_active'] ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-400' }}">

                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="13" rx="2" stroke-width="1.8" />
                                            <path stroke-linecap="round" stroke-width="1.8" d="M9 21h6M12 17v4" />
                                        </svg>

                                    </div>


                                    <div>

                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $device['workstation_name'] }}
                                        </p>

                                        <p class="mt-0.5 text-[11px] text-gray-400">
                                            Device #{{ $device['id'] }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <td class="px-6 py-4">

                                <span class="font-mono text-xs font-medium text-gray-600">
                                    {{ $device['device_uid'] }}
                                </span>

                            </td>


                            <td class="px-6 py-4">

                                <span class="rounded-lg bg-gray-100 px-2.5 py-1 font-mono text-xs font-semibold text-gray-600">
                                    {{ $device['pairing_code'] }}
                                </span>

                            </td>


                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex items-center gap-2">

                                    <span class="h-2 w-2 rounded-full {{ $device['is_active'] ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>

                                    <span class="text-xs text-gray-500">
                                        {{ $device['last_seen_at'] }}
                                    </span>

                                </div>

                            </td>


                            


                            <td class="px-6 py-4">

                                @if ($device['is_active'])

                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-500">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                        Inactive
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
        ACCESS EVENTS
    ========================================================== --}}
    <div class="mb-6 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 2h9l5 5v15H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z" />
                        <path stroke-linecap="round" stroke-width="1.8" d="M14 2v6h6M8 13h8M8 17h6" />
                    </svg>

                </div>


                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Recent Access Events
                    </h2>

                    <p class="text-sm text-gray-500">
                        RFID and workstation activity from pc_access_logs.
                    </p>

                </div>

            </div>


            <select id="access-filter" class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-50">
                <option value="all">All results</option>
                <option value="ALLOWED">Allowed</option>
                <option value="DENIED">Denied</option>
            </select>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-gray-100 bg-gray-50/80 text-[11px] font-semibold uppercase tracking-wider text-gray-400">

                    <tr>

                        <th class="px-6 py-3.5">
                            Student
                        </th>

                        <th class="px-6 py-3.5">
                            Workstation
                        </th>

                        <th class="px-6 py-3.5">
                            Event
                        </th>

                        <th class="px-6 py-3.5">
                            Result
                        </th>



                        <th class="px-6 py-3.5">
                            Session
                        </th>

                        <th class="px-6 py-3.5">
                            Time
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach ($accessLogs as $log)

                        <tr class="access-row transition hover:bg-gray-50/80" data-result="{{ strtoupper($log['result']) }}">

                            <td class="px-6 py-4">

                                <div>

                                    <p class="font-semibold text-gray-800">
                                        {{ $log['student_name'] ?? 'Unknown' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $log['student_external_id'] ?? 'No ID' }}
                                    </p>

                                    @if ($log['course'])
                                        <p class="mt-0.5 text-[11px] text-gray-400">
                                            {{ $log['course'] }}
                                        </p>
                                    @endif

                                </div>

                            </td>


                            <td class="px-6 py-4">

                                <span class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-600">
                                    {{ $log['device_name'] }}
                                </span>

                            </td>


                            <td class="px-6 py-4">

                                <p class="text-xs font-semibold text-gray-700">
                                    {{ $log['event_type'] }}
                                </p>

                                <p class="mt-1 font-mono text-[10px] text-gray-400">
                                    {{ $log['rfid_uid'] }}
                                </p>

                            </td>


                            <td class="px-6 py-4">

                                @if (in_array(strtoupper($log['result']), ['ALLOWED', 'GRANTED', 'SUCCESS'], true))

                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $log['result'] }}
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        {{ $log['result'] }}
                                    </span>

                                @endif

                            </td>




                            <td class="px-6 py-4">

                                <span class="font-mono text-[10px] text-gray-400">
                                    {{ $log['session_id'] ?? '—' }}
                                </span>

                            </td>


                            <td class="whitespace-nowrap px-6 py-4">

                                <p class="text-xs font-medium text-gray-600">
                                    {{ $log['occurred_at'] }}
                                </p>

                                <p class="mt-1 text-[10px] text-gray-400">
                                    Received {{ $log['received_at'] }}
                                </p>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
        DEVICE COMMANDS + APP USAGE
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-5">

        {{-- =====================================================
            DEVICE COMMANDS
        ====================================================== --}}
        <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm xl:col-span-3">

            <div class="border-b border-gray-100 px-5 py-5 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h10" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m17 15 3 2-3 2" />
                        </svg>

                    </div>


                    <div>

                        <h2 class="text-lg font-bold text-gray-900">
                            Device Commands
                        </h2>

                        <p class="text-sm text-gray-500">
                            Command delivery and acknowledgement status.
                        </p>

                    </div>

                </div>

            </div>


            <div class="divide-y divide-gray-100">

                @foreach ($deviceCommands as $command)

                    <div class="flex flex-col gap-4 px-5 py-4 transition hover:bg-gray-50/70 sm:flex-row sm:items-center sm:px-6">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="13" rx="2" stroke-width="1.8" />
                                <path stroke-linecap="round" stroke-width="1.8" d="M9 21h6M12 17v4" />
                            </svg>

                        </div>


                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                <div>

                                    <div class="flex flex-wrap items-center gap-2">

                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $command['command'] }}
                                        </p>

                                        <span class="text-xs text-gray-400">
                                            {{ $command['device_name'] }}
                                        </span>

                                    </div>


                                    <p class="mt-1 text-xs leading-5 text-gray-500">
                                        {{ $command['message'] }}
                                    </p>

                                </div>


                                @if ($command['status'] === 'ACKNOWLEDGED')

                                    <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Acknowledged
                                    </span>

                                @elseif ($command['status'] === 'PENDING')

                                    <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Pending
                                    </span>

                                @else

                                    <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1 text-[11px] font-semibold text-red-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Failed
                                    </span>

                                @endif

                            </div>


                            <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1 text-[10px] text-gray-400">

                                <span>
                                    Created {{ $command['created_at'] }}
                                </span>

                                <span>
                                    Acknowledged: {{ $command['acknowledged_at'] ?? 'Not yet' }}
                                </span>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>


        {{-- =====================================================
            APPLICATION USAGE
        ====================================================== --}}
        <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm xl:col-span-2">

            <div class="border-b border-gray-100 px-5 py-5">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="1.8" />
                            <path stroke-linecap="round" stroke-width="1.8" d="M3 9h18" />
                        </svg>

                    </div>


                    <div>

                        <h2 class="text-lg font-bold text-gray-900">
                            Application Usage
                        </h2>

                        <p class="text-sm text-gray-500">
                            Recent tracked applications.
                        </p>

                    </div>

                </div>

            </div>


            <div class="divide-y divide-gray-100">

                @foreach ($appUsage as $usage)

                    @php
                        $minutes = floor($usage['seconds'] / 60);
                        $remainingSeconds = $usage['seconds'] % 60;
                    @endphp

                    <div class="px-5 py-4">

                        <div class="flex items-center justify-between gap-3">

                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-gray-800">
                                    {{ $usage['app_name'] }}
                                </p>

                                <p class="mt-1 font-mono text-[10px] text-gray-400">
                                    {{ $usage['rfid_uid'] }}
                                </p>

                            </div>


                            <span class="rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-600">
                                {{ $minutes }}m {{ $remainingSeconds }}s
                            </span>

                        </div>


                        <div class="mt-3 flex items-center justify-between gap-3 border-t border-gray-100 pt-3">

                            <span class="max-w-[160px] truncate font-mono text-[10px] text-gray-400">
                                {{ $usage['session_id'] }}
                            </span>


                            <span class="text-[10px] text-gray-400">
                                {{ $usage['occurred_at'] }}
                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    INTERACTIONS
========================================================== --}}
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Device Search
    |--------------------------------------------------------------------------
    */
    const deviceSearch = document.getElementById('device-search');
    const deviceRows = document.querySelectorAll('.device-row');

    if (deviceSearch) {
        deviceSearch.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();

            deviceRows.forEach(function (row) {
                const searchable = row.dataset.search;

                if (searchable.includes(query)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Access Filter
    |--------------------------------------------------------------------------
    */
    const accessFilter = document.getElementById('access-filter');
    const accessRows = document.querySelectorAll('.access-row');

    if (accessFilter) {
        accessFilter.addEventListener('change', function () {
            const selectedResult = this.value;

            accessRows.forEach(function (row) {
                if (selectedResult === 'all' || row.dataset.result === selectedResult) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Refresh Button (Visual feedback)
    |--------------------------------------------------------------------------
    */
    const refreshButton = document.getElementById('refresh-monitoring');
    const refreshIcon = document.getElementById('refresh-icon');

    if (refreshButton) {
        refreshButton.addEventListener('click', function () {
            refreshButton.disabled = true;
            refreshButton.classList.add('cursor-not-allowed', 'opacity-70');
            refreshIcon.classList.add('animate-spin');

            // In a real app, you would make an AJAX call or full reload here
            window.location.reload();
        });
    }

});
</script>

@endpush

@endsection