
@extends('layout.app')

@section('title', 'Reports')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-5 xl:flex-row xl:items-first xl:justify-between">

        <div>
            <div class="mb-2 flex items-center gap-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M6 2h9l5 5v15H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M14 2v6h6M8 13h8M8 17h6"
                        />
                    </svg>
                </span>

                <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">
                    Reports
                </span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Reports Dashboard
            </h1>

            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Review device access activity, monitor usage patterns,
                and filter audit trails.
            </p>
        </div>


        {{-- =====================================================
            EXPORT ACTIONS
        ====================================================== --}}
        <div class="flex flex-wrap items-center gap-2">

            {{-- Preview --}}
            <a
                href="{{ route('reports.preview', request()->query()) }}"
                target="_blank"
                rel="noopener"
                class="inline-flex h-10 items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 text-sm font-semibold text-blue-700 transition hover:border-blue-300 hover:bg-blue-100 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z"
                    />
                    <circle cx="12" cy="12" r="2.5" />
                </svg>

                Preview PDF
            </a>


            {{-- CSV --}}
            <a
                href="{{ route('reports.csv', request()->query()) }}"
                class="inline-flex h-10 items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-gray-100"
            >
                <svg
                    class="h-4 w-4 text-emerald-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2"
                    />
                </svg>

                CSV
            </a>


            {{-- PDF --}}
            <a
                href="{{ route('reports.pdf', request()->query()) }}"
                class="inline-flex h-10 items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700 focus:outline-none focus:ring-4 focus:ring-gray-100"
            >
                <svg
                    class="h-4 w-4 text-rose-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 3h7l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14 3v5h5M8 15h8M8 18h6"
                    />
                </svg>

                PDF
            </a>

        </div>

    </div>


    {{-- =========================================================
        FILTER / CONFIGURATION CARD
    ========================================================== --}}
    <form
        method="GET"
        action="{{ route('reports') }}"
        class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm"
    >

        <input
            type="hidden"
            name="columns_configured"
            value="1"
        >


        {{-- =====================================================
            CARD HEADER
        ====================================================== --}}
        <div class="border-b border-gray-100 bg-gray-50/60 px-5 py-5 sm:px-6">

            <div class="flex items-start gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 5h18M6 12h12M10 19h4"
                        />
                    </svg>
                </div>

                <div>
                    <h2 class="text-base font-bold text-gray-900">
                        Report Configuration
                    </h2>

                    <p class="mt-0.5 text-sm text-gray-500">
                        Filter access records and choose which information
                        appears in your report.
                    </p>
                </div>

            </div>

        </div>


        {{-- =====================================================
            FILTER SECTION
        ====================================================== --}}
        <div class="p-5 sm:p-6">

            <div class="mb-4 flex items-center gap-2">

                <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-blue-50 text-xs font-bold text-blue-600">
                    1
                </span>

                <h3 class="text-sm font-bold text-gray-900">
                    Filter Data
                </h3>

            </div>


            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Date From --}}
                <div>
                    <label
                        for="date_from"
                        class="mb-1.5 block text-xs font-semibold text-gray-600"
                    >
                        Date From
                    </label>

                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >
                </div>


                {{-- Date To --}}
                <div>
                    <label
                        for="date_to"
                        class="mb-1.5 block text-xs font-semibold text-gray-600"
                    >
                        Date To
                    </label>

                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >
                </div>


                {{-- Course --}}
                <div>
                    <label
                        for="course"
                        class="mb-1.5 block text-xs font-semibold text-gray-600"
                    >
                        Course
                    </label>

                    <select
                        id="course"
                        name="course"
                        class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >
                        <option value="">
                            All Courses
                        </option>

                        @foreach ($courses as $course)
                            <option
                                value="{{ $course }}"
                                {{ request('course') == $course ? 'selected' : '' }}
                            >
                                {{ $course }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Device --}}
                <div>
                    <label
                        for="device"
                        class="mb-1.5 block text-xs font-semibold text-gray-600"
                    >
                        Device
                    </label>

                    <select
                        id="device"
                        name="device"
                        class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >
                        <option value="">
                            All Devices
                        </option>

                        @foreach ($devices as $device)
                            <option
                                value="{{ $device }}"
                                {{ request('device') == $device ? 'selected' : '' }}
                            >
                                {{ $device }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Event --}}
                <div>
                    <label
                        for="event"
                        class="mb-1.5 block text-xs font-semibold text-gray-600"
                    >
                        Event
                    </label>

                    <select
                        id="event"
                        name="event"
                        class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >
                        <option value="">
                            All Events
                        </option>

                        @foreach ($events as $event)
                            <option
                                value="{{ $event }}"
                                {{ request('event') == $event ? 'selected' : '' }}
                            >
                                {{ $event }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>


            {{-- =================================================
                COLUMNS
            ================================================== --}}
            <div class="mt-7 border-t border-gray-100 pt-6">

                <div class="mb-4 flex items-center gap-2">

                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-indigo-50 text-xs font-bold text-indigo-600">
                        2
                    </span>

                    <div>
                        <h3 class="text-sm font-bold text-gray-900">
                            Columns to Display / Print
                        </h3>

                        <p class="text-xs text-gray-500">
                            Select the information you want included.
                        </p>
                    </div>

                </div>


                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">

                    {{-- Student --}}
                    <label
                        class="group flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 bg-gray-50/70 p-3 transition hover:border-blue-200 hover:bg-blue-50"
                    >
                        <input
                            type="checkbox"
                            name="cols[student_name]"
                            value="1"
                            {{ $columns['student_name'] ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">
                            Student Name
                        </span>
                    </label>


                    {{-- Course --}}
                    <label
                        class="group flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 bg-gray-50/70 p-3 transition hover:border-blue-200 hover:bg-blue-50"
                    >
                        <input
                            type="checkbox"
                            name="cols[course]"
                            value="1"
                            {{ $columns['course'] ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">
                            Course
                        </span>
                    </label>


                    {{-- Workstation --}}
                    <label
                        class="group flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 bg-gray-50/70 p-3 transition hover:border-blue-200 hover:bg-blue-50"
                    >
                        <input
                            type="checkbox"
                            name="cols[device]"
                            value="1"
                            {{ $columns['device'] ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">
                            Workstation
                        </span>
                    </label>


                    {{-- Date --}}
                    <label
                        class="group flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 bg-gray-50/70 p-3 transition hover:border-blue-200 hover:bg-blue-50"
                    >
                        <input
                            type="checkbox"
                            name="cols[date_time]"
                            value="1"
                            {{ $columns['date_time'] ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">
                            Date & Time
                        </span>
                    </label>


                    {{-- Event --}}
                    <label
                        class="group flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 bg-gray-50/70 p-3 transition hover:border-blue-200 hover:bg-blue-50"
                    >
                        <input
                            type="checkbox"
                            name="cols[event]"
                            value="1"
                            {{ $columns['event'] ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >

                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">
                            Event
                        </span>
                    </label>

                </div>

            </div>


            {{-- =================================================
                ACTIONS
            ================================================== --}}
            <div class="mt-7 flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-xs text-gray-400">
                    Apply your filters before exporting the report.
                </p>

                <div class="flex flex-col gap-2 sm:flex-row">

                    <a
                        href="{{ route('reports') }}"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-100"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 4v5h5M20 20v-5h-5M5.5 9A7 7 0 0 1 17 6.5L20 9M18.5 15A7 7 0 0 1 7 17.5L4 15"
                            />
                        </svg>

                        Reset All
                    </a>


                    <button
                        type="submit"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 12h14M12 5l7 7-7 7"
                            />
                        </svg>

                        Apply Filters
                    </button>

                </div>

            </div>

        </div>

    </form>


    {{-- =========================================================
        RESULTS HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-lg font-bold text-gray-900">
                Access Logs
            </h2>

            <p class="mt-0.5 text-sm text-gray-500">
                Records matching your current filters.
            </p>

        </div>


        {{-- Result count --}}
        @if(method_exists($logs, 'total'))
            <div class="inline-flex w-fit items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5">

                <span class="h-2 w-2 rounded-full bg-blue-500"></span>

                <span class="text-xs font-semibold text-gray-600">
                    {{ number_format($logs->total()) }} records
                </span>

            </div>
        @endif

    </div>


    {{-- =========================================================
        DATA TABLE
    ========================================================== --}}
    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

        {{-- Table top --}}
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 text-gray-600">
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2Z"
                        />
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-bold text-gray-900">
                        Activity Records
                    </p>

                    <p class="text-xs text-gray-400">
                        Library device access history
                    </p>
                </div>

            </div>

        </div>


        {{-- Responsive table --}}
        <div class="relative overflow-x-auto">

            <table class="w-full text-left text-sm text-gray-600">

                <thead class="border-b border-gray-200 bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">

                    <tr>

                        @if ($columns['student_name'])
                            <th
                                scope="col"
                                class="whitespace-nowrap px-5 py-4 sm:px-6"
                            >
                                Student
                            </th>
                        @endif

                        @if ($columns['course'])
                            <th
                                scope="col"
                                class="whitespace-nowrap px-5 py-4 sm:px-6"
                            >
                                Course
                            </th>
                        @endif

                        @if ($columns['device'])
                            <th
                                scope="col"
                                class="whitespace-nowrap px-5 py-4 sm:px-6"
                            >
                                Workstation
                            </th>
                        @endif

                        @if ($columns['date_time'])
                            <th
                                scope="col"
                                class="whitespace-nowrap px-5 py-4 sm:px-6"
                            >
                                Date & Time
                            </th>
                        @endif

                        @if ($columns['event'])
                            <th
                                scope="col"
                                class="whitespace-nowrap px-5 py-4 sm:px-6"
                            >
                                Event
                            </th>
                        @endif

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($logs as $log)

                        <tr class="group transition hover:bg-blue-50/40">

                            {{-- Student --}}
                            @if ($columns['student_name'])
                                <td class="px-5 py-4 sm:px-6">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xs font-bold text-blue-600">
                                            {{ strtoupper(substr($log->student_name ?? '?', 0, 1)) }}
                                        </div>

                                        <span class="font-semibold text-gray-900">
                                            {{ $log->student_name }}
                                        </span>

                                    </div>

                                </td>
                            @endif


                            {{-- Course --}}
                            @if ($columns['course'])
                                <td class="px-5 py-4 sm:px-6">

                                    <span class="inline-flex items-center rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                                        {{ $log->course }}
                                    </span>

                                </td>
                            @endif


                            {{-- Device --}}
                            @if ($columns['device'])
                                <td class="px-5 py-4 sm:px-6">

                                    <div class="flex items-center gap-2">

                                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-100 text-gray-500">

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <rect
                                                    x="4"
                                                    y="4"
                                                    width="16"
                                                    height="16"
                                                    rx="2"
                                                />

                                                <rect
                                                    x="9"
                                                    y="9"
                                                    width="6"
                                                    height="6"
                                                />
                                            </svg>

                                        </span>

                                        <span class="font-medium text-gray-800">
                                            {{ $log->workstation_name }}
                                        </span>

                                    </div>

                                </td>
                            @endif


                            {{-- Date --}}
                            @if ($columns['date_time'])
                                <td class="px-5 py-4 sm:px-6">

                                    <span class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                                        {{ $log->occurred_at }}
                                    </span>

                                </td>
                            @endif


                            {{-- Event --}}
                            @if ($columns['event'])
                                <td class="px-5 py-4 sm:px-6">

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                        {{ $log->event_type }}

                                    </span>

                                </td>
                            @endif

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">

                                        <svg
                                            class="h-7 w-7"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2Z"
                                            />
                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-sm font-bold text-gray-800">
                                        No access logs found
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        No records match your current filters.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
        PAGINATION
    ========================================================== --}}
    @if ($logs->hasPages())

        <div class="flex justify-center sm:justify-end">

            {{ $logs->onEachSide(1)->links('vendor.pagination.flowbite') }}

        </div>

    @endif

</div>

@endsection

