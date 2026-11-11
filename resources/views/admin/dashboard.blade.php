@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-w-0 max-w-full space-y-6 overflow-x-hidden">


    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <p class="text-sm font-medium text-blue-600">
                Overview
            </p>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Library Dashboard
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Monitor your devices, usage and student activity.
            </p>

        </div>


        {{-- Date Range --}}
        <div class="relative self-start sm:self-auto">

            <button
                id="dashboardRangeDropdownButton"
                data-dropdown-toggle="dashboardRangeDropdown"
                data-dropdown-placement="bottom-end"
                type="button"
                class="inline-flex h-10 items-center gap-2 rounded-xl border border-gray-200 bg-white px-3.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                {{ $rangeLabel }}

                <svg
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="m6 9 6 6 6-6"
                    />
                </svg>
            </button>


            <div
                id="dashboardRangeDropdown"
                class="absolute right-0 z-20 mt-2 hidden w-44 overflow-hidden rounded-xl border border-gray-200 bg-white p-1 shadow-lg"
            >

                @foreach($rangeLabels as $rangeKey => $rangeOptionLabel)

                    <a
                        href="{{ route('dashboard', ['range' => $rangeKey]) }}"
                        class="block rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-blue-50 hover:text-blue-700"
                    >
                        {{ $rangeOptionLabel }}
                    </a>

                @endforeach

            </div>

        </div>

    </div>



{{-- =========================================================
    SUMMARY CARDS
========================================================== --}}
<div
    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:auto-rows-[170px]"
>

    {{-- =====================================================
        TOTAL DEVICES
    ====================================================== --}}
    <div
        class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 p-6 text-white shadow-sm lg:row-span-2"
    >

        {{-- Decorative circles --}}
        <div
            class="pointer-events-none absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10"
        ></div>

        <div
            class="pointer-events-none absolute -bottom-16 -left-10 h-40 w-40 rounded-full bg-white/5"
        ></div>


        <div class="relative flex h-full flex-col justify-between">

            <div>

                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">

                        <p class="text-sm font-medium text-blue-100">
                            Total Devices
                        </p>

                        <p class="mt-2 text-5xl font-bold tracking-tight">
                            {{ number_format($totalDevices ?? 0) }}
                        </p>

                    </div>


                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm"
                    >

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9.75 17L8 20h8l-1.75-3M5 4h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"
                            />
                        </svg>

                    </div>

                </div>

            </div>


            <div>

                <div class="mb-2 flex items-center justify-between text-xs">

                    <span class="text-blue-100">
                        Paired devices
                    </span>

                    <span class="font-semibold text-white">
                        {{ number_format($pairedDevices ?? 0) }}
                    </span>

                </div>


                <div class="h-2 overflow-hidden rounded-full bg-white/20">

                    <div
                        class="h-full rounded-full bg-white transition-all"
                        style="width: {{ ($totalDevices ?? 0) > 0 ? (($pairedDevices ?? 0) / $totalDevices) * 100 : 0 }}%"
                    ></div>

                </div>


                <div
                    class="mt-3 flex items-center justify-between text-xs text-blue-100"
                >d

                    {{-- <span>
                        {{ number_format($activeDevices ?? 0) }} active
                    </span>

                    <span>
                        {{ ($totalDevices ?? 0) > 0
                            ? round((($activeDevices ?? 0) / $totalDevices) * 100)
                            : 0 }}%
                    </span> --}}

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        TOTAL LOGINS
    ====================================================== --}}
    <div
        class="flex h-full flex-col rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:shadow-md"
    >

        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0">

                <p class="text-sm font-medium text-gray-500">
                    Total Logins
                </p>

                <p
                    class="mt-2 text-3xl font-bold tracking-tight text-gray-900"
                >
                    {{ number_format($totalLogins ?? 0) }}
                </p>

            </div>


            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"
                    />
                </svg>

            </div>

        </div>


        <p
            class="mt-auto pt-4 text-xs leading-5 text-gray-500"
        >
            Successful RFID access · {{ $rangeLabel }}
        </p>

    </div>


    {{-- =====================================================
        UNIQUE STUDENTS
    ====================================================== --}}
    <div
        class="flex h-full flex-col rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:shadow-md"
    >

        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0">

                <p class="text-sm font-medium text-gray-500">
                    Unique Students
                </p>

                <p
                    class="mt-2 text-3xl font-bold tracking-tight text-gray-900"
                >
                    {{ number_format($uniqueStudents ?? 0) }}
                </p>

            </div>


            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-violet-50 text-violet-600"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                    />
                </svg>

            </div>

        </div>


        <p
            class="mt-auto pt-4 text-xs leading-5 text-gray-500"
        >
            Students accessing the library · {{ $rangeLabel }}
        </p>

    </div>


    {{-- =====================================================
        AVG. SESSION DURATION
    ====================================================== --}}
    <div
        class="flex h-full min-w-0 flex-col rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:shadow-md"
    >

        <div class="flex items-start justify-between gap-3">

            {{-- Content --}}
            <div class="min-w-0 flex-1">

                <p class="text-sm font-medium leading-5 text-gray-500">
                    Avg. Session Duration
                </p>


                <p
                    class="mt-2 whitespace-nowrap text-2xl font-bold leading-none tracking-tight text-gray-900 xl:text-[28px] 2xl:text-3xl"
                    title="{{ $avgSessionDuration ?? '0h 0m 0s' }}"
                >
                    {{ $avgSessionDuration ?? '0h 0m 0s' }}
                </p>

            </div>


            {{-- Icon --}}
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-orange-50 text-orange-600"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 7v5l3 2"
                    />
                </svg>

            </div>

        </div>


       
        <p
            class="mt-auto pt-4 text-xs leading-5 text-gray-500"
        >
            Average usage session · {{ $rangeLabel }}
        </p>

    </div>

</div>



    {{-- =========================================================
        LIVE PC USAGE
    ========================================================== --}}
    <div
        class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm"
    >

        <div
            class="flex flex-col gap-2 px-6 pb-4 pt-6 sm:flex-row sm:items-center sm:justify-between"
        >

            <div>

                <div class="flex items-center gap-2">

                    <h2 class="text-lg font-bold text-gray-900">
                        Live PC Usage
                    </h2>


                    <span class="relative flex h-2 w-2">

                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"
                        ></span>

                        <span
                            class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"
                        ></span>

                    </span>


                    <span
                        id="live-active-count"
                        class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700"
                    >
                        {{ count($activeSessions ?? []) }} Active
                    </span>

                </div>


                <p class="mt-1 text-sm text-gray-500">
                    Currently active sessions on workstations
                </p>

            </div>

        </div>


        <div class="px-6 pb-6">

            <div
                id="live-monitor-list"
                class="space-y-2"
            >

                @forelse(($activeSessions ?? []) as $session)

                    <div
                        class="live-card flex flex-col gap-3 rounded-2xl border border-gray-100 bg-gradient-to-r from-white to-gray-50/60 p-4 sm:flex-row sm:items-center sm:justify-between"
                        data-session-id="{{ $session['session_id'] }}"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700"
                            >

                                <span class="text-sm font-semibold">
                                    {{ strtoupper(mb_substr($session['student_name'] ?? 'U', 0, 1)) }}
                                </span>

                            </div>


                            <div>

                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $session['student_name'] }}
                                </p>

                                <p class="text-xs text-gray-500">

                                    {{ $session['course'] ?? 'N/A' }}

                                    @if(!empty($session['student_external_id']))
                                        • {{ $session['student_external_id'] }}
                                    @endif

                                </p>

                            </div>

                        </div>


                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600">

                            <div class="flex items-center gap-1.5">

                                <svg
                                    class="h-4 w-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9.75 17L8 20h8l-1.75-3M5 4h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"
                                    />
                                </svg>


                                <span class="font-medium text-gray-900">
                                    {{ $session['workstation_name']  ?? 'PC' }}
                                </span>

                            </div>


                            <div class="flex items-center gap-1.5">

                                <svg
                                    class="h-4 w-4 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 7v5l3 2"
                                    />
                                </svg>


                                <span>
                                    Started {{ $session['started_at_display'] }}
                                </span>

                            </div>


                            <div
                                class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700"
                            >

                                <span
                                    class="live-elapsed"
                                    data-start-ts="{{ $session['started_at_ts'] ?? '' }}"
                                    data-started="{{ $session['started_at'] ?? '' }}"
                                >
                                    {{ $session['elapsed_display'] ?? '00:00' }}
                                </span>

                            </div>


                            <span
                                class="live-stale-badge {{ !empty($session['is_stale']) ? '' : 'hidden' }} inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700"
                                title="No heartbeat for over {{ $session['stale_warning_minutes'] ?? 2 }} minutes. Auto-closes after {{ $session['stale_minutes'] ?? 5 }} minutes without a heartbeat."
                            >
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                No heartbeat
                            </span>


                            <button
                                type="button"
                                class="manage-session inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                                data-session-id="{{ $session['session_id'] }}"
                                data-student-name="{{ $session['student_name'] }}"
                                data-device-name="{{ $session['device_name'] }}"
                                data-lock-url="{{ $session['lock_url'] }}"
                                data-announce-url="{{ $session['announce_url'] }}"
                                data-device-url="{{ $session['device_url'] }}"
                                aria-haspopup="menu"
                                aria-expanded="false"
                                title="Manage this session"
                            >
                                <svg
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" d="M4 7h16M4 17h16"/>
                                    <circle cx="9" cy="7" r="2"/>
                                    <circle cx="15" cy="17" r="2"/>
                                </svg>

                                Manage

                                <svg
                                    class="manage-chevron h-3 w-3"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>

                        </div>

                    </div>

                @empty
                @endforelse

            </div>


            {{-- Empty live sessions --}}
            <div
                id="live-monitor-empty"
                class="flex flex-col items-center justify-center py-6 text-center {{ count($activeSessions ?? []) > 0 ? 'hidden' : '' }}"
            >

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-50 text-gray-400"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.6"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9.75 17L8 20h8l-1.75-3M5 4h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"
                        />
                    </svg>

                </div>


                <p class="mt-2 text-sm font-medium text-gray-900">
                    No active sessions right now
                </p>


                <p class="mt-1 text-xs text-gray-500">
                    Students will appear here the moment they log in to a PC
                </p>

            </div>

        </div>

    </div>


    {{-- Shared Manage menu for live sessions. One node for every card so it
         can float above the card's overflow-hidden slide animation. --}}
    <div
        id="live-session-menu"
        class="fixed z-50 hidden w-56 overflow-hidden rounded-2xl border border-gray-200 bg-white p-1.5 shadow-xl"
        role="menu"
        aria-label="Manage live session"
    >

        <div class="px-3 pb-1.5 pt-2">

            <p
                id="live-session-menu-title"
                class="truncate text-xs font-semibold text-gray-900"
            ></p>

            <p
                id="live-session-menu-subtitle"
                class="truncate text-xs text-gray-500"
            ></p>

        </div>


        <a
            id="live-menu-view-device"
            href="#"
            class="live-menu-view-device flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-blue-50 hover:text-blue-700"
            role="menuitem"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0Z"/>
            </svg>

            View Device
        </a>


        <button
            type="button"
            class="live-menu-lock flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-amber-50 hover:text-amber-700"
            role="menuitem"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"
                />
            </svg>

            Remote Lock
        </button>


        <button
            type="button"
            class="live-menu-announce flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-sky-50 hover:text-sky-700"
            role="menuitem"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"
                />
            </svg>

            Send Announcement
        </button>


        <div class="my-1 h-px bg-gray-100"></div>


        <button
            type="button"
            class="live-menu-force-end flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700"
            role="menuitem"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"
                />
            </svg>

            Force End
        </button>

    </div>


    {{-- =========================================================
        MAIN BENTO CONTENT
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- =====================================================
            STUDENT ACCESS
        ====================================================== --}}
        <div
            class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2"
        >

            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"
            >

                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Student Access
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Unique students with successful access per
                        {{ $chartGroupingLabel }} · {{ $rangeLabel }}.
                    </p>

                </div>


                <div class="flex items-center gap-4">

                    <div class="flex items-center gap-2 text-xs text-gray-500">

                        <span class="h-2.5 w-2.5 rounded-full bg-blue-600"></span>

                        Male

                    </div>


                    <div class="flex items-center gap-2 text-xs text-gray-500">

                        <span class="h-2.5 w-2.5 rounded-full bg-blue-300"></span>

                        Female

                    </div>

                </div>

            </div>


            <div class="mt-6">

                <div id="column-chart"></div>

            </div>

        </div>


        {{-- =====================================================
            COURSE DISTRIBUTION
        ====================================================== --}}
        <div
            class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm"
        >

            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Course Distribution
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Student distribution by course · {{ $rangeLabel }}.
                </p>

            </div>


            <div class="mt-2 flex items-end gap-2">
            </div>


            <div class="mt-4">

                <div
                    id="pie-chart"
                    class="min-h-[300px]"
                ></div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    APEXCHARTS
========================================================== --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
        STUDENT ACCESS - COLUMN CHART
    ========================================================== */

    const maleData = @json($male ?? []);

    const femaleData = @json($female ?? []);

    const columnChartDays = @json($columnChartDays ?? []);

    const columnChartElement =
        document.querySelector('#column-chart');


    if (columnChartElement) {

        const columnChartOptions = {

            series: [
                {
                    name: 'Male',
                    color: '#2563EB',
                    data: maleData
                },
                {
                    name: 'Female',
                    color: '#93C5FD',
                    data: femaleData
                }
            ],

            chart: {
                type: 'bar',
                height: 280,
                fontFamily:
                    'Inter, ui-sans-serif, system-ui, sans-serif',

                toolbar: {
                    show: false
                }
            },

            plotOptions: {

                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                    borderRadius: 6,
                    borderRadiusApplication: 'end'
                }

            },

            dataLabels: {
                enabled: false
            },

            stroke: {
                show: false
            },

            xaxis: {

                categories: columnChartDays,

                labels: {

                    style: {
                        colors: '#6B7280',
                        fontSize: '12px'
                    }

                },

                axisBorder: {
                    show: false
                },

                axisTicks: {
                    show: false
                }

            },

            yaxis: {

                labels: {

                    style: {
                        colors: '#9CA3AF',
                        fontSize: '12px'
                    }

                }

            },

            grid: {

                borderColor: '#F3F4F6',

                strokeDashArray: 4,

                xaxis: {

                    lines: {
                        show: false
                    }

                }

            },

            legend: {
                show: false
            },

            tooltip: {
                theme: 'light',
                shared: true,
                intersect: false
            },

            states: {

                hover: {

                    filter: {
                        type: 'lighten',
                        value: 0.05
                    }

                }

            }

        };


        const columnChart = new ApexCharts(
            columnChartElement,
            columnChartOptions
        );


        columnChart.render();

    }


    /* =========================================================
        COURSE DISTRIBUTION - PIE CHART
    ========================================================== */

    @php

        /*
        |--------------------------------------------------------------------------
        | Prepare Course Distribution
        |--------------------------------------------------------------------------
        |
        | Remove zero values first so an empty dataset does not create an
        | unusable ApexCharts donut.
        |
        */

        $sortedCourses = collect($courseDistribution ?? [])
            ->filter(function ($value) {
                return (int) $value > 0;
            })
            ->sortDesc();


        /*
        |--------------------------------------------------------------------------
        | Show top three courses
        |--------------------------------------------------------------------------
        */

        $pieChartCourses = $sortedCourses->take(3);


        /*
        |--------------------------------------------------------------------------
        | Combine remaining courses
        |--------------------------------------------------------------------------
        */

        $othersCount = $sortedCourses
            ->skip(3)
            ->sum();


        if ($othersCount > 0) {

            $pieChartCourses->put(
                'Other courses',
                $othersCount
            );

        }

    @endphp


    const courseLabels =
        @json($pieChartCourses->keys()->all());


    const courseCounts =
        @json(
            $pieChartCourses
                ->values()
                ->map(fn ($value) => (int) $value)
                ->all()
        );


    const pieChartElement =
        document.querySelector('#pie-chart');


    if (pieChartElement) {

        /*
        |--------------------------------------------------------------------------
        | Determine whether chart contains actual data
        |--------------------------------------------------------------------------
        */

        const totalCourseStudents =
            courseCounts.reduce(
                function (sum, value) {
                    return sum + Number(value || 0);
                },
                0
            );


        const hasCourseData =
            courseLabels.length > 0 &&
            courseCounts.length > 0 &&
            totalCourseStudents > 0;


        /*
        |--------------------------------------------------------------------------
        | EMPTY STATE
        |--------------------------------------------------------------------------
        */

        if (!hasCourseData) {

            pieChartElement.innerHTML = `
                <div
                    class="flex min-h-[300px] flex-col items-center justify-center px-4 text-center"
                >

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-500"
                    >

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M12 3a9 9 0 1 0 9 9h-9V3Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M15 3.6A9 9 0 0 1 20.4 9H15V3.6Z"
                            />

                        </svg>

                    </div>


                    <h3
                        class="mt-4 text-sm font-semibold text-gray-900"
                    >
                        No course data available
                    </h3>


                    <p
                        class="mt-1 max-w-[240px] text-xs leading-5 text-gray-500"
                    >
                        No students with successful access were recorded
                        for the selected period.
                    </p>


                    <div
                        class="mt-4 inline-flex items-center gap-2 rounded-full bg-gray-50 px-3 py-1.5 text-[11px] font-medium text-gray-500"
                    >

                        <span
                            class="h-1.5 w-1.5 rounded-full bg-gray-300"
                        ></span>

                        {{ $rangeLabel }}

                    </div>

                </div>
            `;

        } else {

            /*
            |--------------------------------------------------------------------------
            | PIE / DONUT CHART
            |--------------------------------------------------------------------------
            */

            const pieChartOptions = {

                series: courseCounts,

                labels: courseLabels,

                chart: {

                    type: 'donut',

                    height: 300,

                    fontFamily:
                        'Inter, ui-sans-serif, system-ui, sans-serif'

                },

                colors: [
                    '#1D4ED8',
                    '#2563EB',
                    '#3B82F6',
                    '#60A5FA',
                    '#93C5FD'
                ],

                stroke: {

                    width: 3,

                    colors: ['#ffffff']

                },

                dataLabels: {
                    enabled: false
                },

                legend: {

                    position: 'bottom',

                    horizontalAlign: 'center',

                    fontSize: '12px',

                    labels: {
                        colors: '#6B7280'
                    },

                    markers: {

                        width: 8,

                        height: 8,

                        radius: 4

                    },

                    itemMargin: {

                        horizontal: 8,

                        vertical: 4

                    }

                },

                plotOptions: {

                    pie: {

                        donut: {

                            size: '80%',

                            labels: {

                                show: true,

                                name: {

                                    show: true,

                                    fontSize: '12px',

                                    color: '#6B7280'

                                },

                                value: {

                                    show: true,

                                    fontSize: '24px',

                                    fontWeight: 700,

                                    color: '#111827'

                                },

                                total: {

                                    show: true,

                                    label: 'Students',

                                    color: '#6B7280',

                                    fontSize: '12px',

                                    formatter: function () {

                                        return courseCounts.reduce(
                                            function (sum, value) {

                                                return sum + Number(value);

                                            },
                                            0
                                        );

                                    }

                                }

                            }

                        }

                    }

                },

                tooltip: {

                    theme: 'light',

                    y: {

                        formatter: function (value) {

                            return Number(value).toLocaleString()
                                + ' students';

                        }

                    }

                }

            };


            const pieChart = new ApexCharts(
                pieChartElement,
                pieChartOptions
            );


            pieChart.render();

        }

    }

});

</script>


{{-- =========================================================
    LIVE SESSION ANIMATION
========================================================== --}}
<style>

    .live-card {
        transition:
            transform 400ms ease,
            opacity 400ms ease,
            max-height 400ms ease,
            margin-top 400ms ease,
            padding-top 400ms ease,
            padding-bottom 400ms ease;

        transform: translateX(0);

        opacity: 1;

        max-height: 160px;

        overflow: hidden;
    }


    .live-card-enter {
        transform: translateX(110%);

        opacity: 0;

        max-height: 0;

        margin-top: 0 !important;

        padding-top: 0 !important;

        padding-bottom: 0 !important;

        border-width: 0 !important;
    }


    .live-card-leave {
        transform: translateX(110%);

        opacity: 0;

        max-height: 0;

        margin-top: 0 !important;

        padding-top: 0 !important;

        padding-bottom: 0 !important;

        border-width: 0 !important;
    }


    .manage-chevron {
        transition: transform 160ms ease;
    }

    .manage-session[aria-expanded="true"] .manage-chevron {
        transform: rotate(180deg);
    }

</style>


{{-- =========================================================
    LIVE PC MONITORING
========================================================== --}}
<script>

(function () {

    const listEl =
        document.getElementById('live-monitor-list');

    const emptyEl =
        document.getElementById('live-monitor-empty');

    const countEl =
        document.getElementById('live-active-count');

    const endpoint =
        '{{ route('dashboard.active-sessions') }}';

    const forceEndBase =
        '{{ url('/dashboard/sessions') }}';

    const csrfToken =
        document.querySelector('meta[name="csrf-token"]')?.content || '';

    const menuEl =
        document.getElementById('live-session-menu');

    const menuTitleEl =
        document.getElementById('live-session-menu-title');

    const menuSubtitleEl =
        document.getElementById('live-session-menu-subtitle');

    let activeManageButton = null;


    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    */

    if (!listEl) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Force-end a session (server closes it immediately)
    |--------------------------------------------------------------------------
    */

    function forceEndSession(sessionId) {

        if (!sessionId) {
            return;
        }

        if (!window.confirm('End this session now? The student will be signed out.')) {
            return;
        }

        fetch(
            forceEndBase + '/' + encodeURIComponent(sessionId) + '/force-end',
            {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            }
        )

            .then(function (response) {

                if (!response.ok) {
                    throw new Error('force-end failed');
                }

                sync();

            })

            .catch(function () {

                window.alert('Could not end the session. Please try again.');

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Manage menu (one floating menu shared by every live card)
    |--------------------------------------------------------------------------
    */

    function closeManageMenu() {

        if (!menuEl || menuEl.classList.contains('hidden')) {
            return;
        }

        menuEl.classList.add('hidden');

        if (activeManageButton) {

            activeManageButton.setAttribute('aria-expanded', 'false');
            activeManageButton = null;

        }

    }


    function positionManageMenu(button) {

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


    function openManageMenu(button) {

        if (!menuEl) {
            return;
        }

        if (activeManageButton === button) {

            closeManageMenu();
            return;

        }

        closeManageMenu();

        menuTitleEl.textContent =
            button.getAttribute('data-student-name') || 'Live session';

        menuSubtitleEl.textContent =
            button.getAttribute('data-device-name') || 'Workstation';

        menuEl.dataset.sessionId =
            button.getAttribute('data-session-id') || '';

        menuEl.dataset.lockUrl =
            button.getAttribute('data-lock-url') || '';

        menuEl.dataset.announceUrl =
            button.getAttribute('data-announce-url') || '';

        menuEl.dataset.deviceName =
            button.getAttribute('data-device-name') || 'this PC';

        const viewDeviceEl =
            menuEl.querySelector('.live-menu-view-device');

        if (viewDeviceEl) {

            const deviceUrl =
                button.getAttribute('data-device-url') || '';

            viewDeviceEl.href = deviceUrl || '#';
            viewDeviceEl.classList.toggle('hidden', !deviceUrl);

        }

        activeManageButton = button;

        button.setAttribute('aria-expanded', 'true');

        positionManageMenu(button);

    }


    if (menuEl) {

        menuEl.querySelector('.live-menu-lock')
            .addEventListener('click', function () {

                const url = menuEl.dataset.lockUrl;
                const deviceName = menuEl.dataset.deviceName;

                closeManageMenu();

                if (!url || typeof openRemoteLockModal !== 'function') {
                    return;
                }

                openRemoteLockModal(url, deviceName);

            });


        menuEl.querySelector('.live-menu-announce')
            .addEventListener('click', function () {

                const url = menuEl.dataset.announceUrl;
                const deviceName = menuEl.dataset.deviceName;

                closeManageMenu();

                if (!url || typeof openRemoteAnnounceModal !== 'function') {
                    return;
                }

                openRemoteAnnounceModal(url, deviceName);

            });


        menuEl.querySelector('.live-menu-force-end')
            .addEventListener('click', function () {

                const sessionId = menuEl.dataset.sessionId;

                closeManageMenu();

                forceEndSession(sessionId);

            });


        document.addEventListener('click', function (event) {

            if (menuEl.classList.contains('hidden')) {
                return;
            }

            if (menuEl.contains(event.target)) {
                return;
            }

            if (event.target.closest('.manage-session')) {
                return;
            }

            closeManageMenu();

        });


        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {
                closeManageMenu();
            }

        });


        window.addEventListener('scroll', closeManageMenu, true);
        window.addEventListener('resize', closeManageMenu);

    }


    listEl.addEventListener('click', function (event) {

        const button =
            event.target.closest('.manage-session');

        if (!button) {
            return;
        }

        event.stopPropagation();

        openManageMenu(button);

    });


    /*
    |--------------------------------------------------------------------------
    | Format elapsed time
    |--------------------------------------------------------------------------
    */

    function formatElapsed(seconds) {

        const s =
            Math.max(0, Number(seconds) || 0);

        const h =
            Math.floor(s / 3600);

        const m =
            Math.floor((s % 3600) / 60);

        const sec =
            s % 60;


        if (h > 0) {

            return String(h).padStart(2, '0')
                + ':'
                + String(m).padStart(2, '0')
                + ':'
                + String(sec).padStart(2, '0');

        }


        return String(m).padStart(2, '0')
            + ':'
            + String(sec).padStart(2, '0');

    }


    /*
    |--------------------------------------------------------------------------
    | Escape values injected into HTML attributes
    |--------------------------------------------------------------------------
    */

    function escapeAttr(value) {

        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

    }


    /*
    |--------------------------------------------------------------------------
    | Create live session card
    |--------------------------------------------------------------------------
    */

    function createCard(session) {

        const card =
            document.createElement('div');


        card.className =
            'live-card live-card-enter flex flex-col gap-3 rounded-2xl border border-gray-100 bg-gradient-to-r from-white to-gray-50/60 p-4 sm:flex-row sm:items-center sm:justify-between';


        card.setAttribute(
            'data-session-id',
            session.session_id
        );


        const initial =
            (session.student_name || 'U')
                .trim()
                .charAt(0)
                .toUpperCase();


        card.innerHTML = `
            <div class="flex items-center gap-3">

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700"
                >
                    <span class="text-sm font-semibold">
                        ${initial}
                    </span>
                </div>


                <div>

                    <p class="text-sm font-semibold text-gray-900">
                        ${session.student_name || ''}
                    </p>

                    <p class="text-xs text-gray-500">
                        ${session.course || 'N/A'}
                        ${
                            session.student_external_id
                                ? ' • ' + session.student_external_id
                                : ''
                        }
                    </p>

                </div>

            </div>


            <div
                class="flex flex-wrap items-center gap-4 text-xs text-gray-600"
            >

                <div class="flex items-center gap-1.5">

                    <svg
                        class="h-4 w-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.6"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9.75 17L8 20h8l-1.75-3M5 4h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"
                        />
                    </svg>

                    <span class="font-medium text-gray-900">
                        ${
                            session.workstation_name ||
                            'PC'
                        }
                    </span>

                </div>


                <div class="flex items-center gap-1.5">

                    <svg
                        class="h-4 w-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.6"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 7v5l3 2"
                        />
                    </svg>

                    <span>
                        Started ${session.started_at_display || ''}
                    </span>

                </div>


                <div
                    class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700"
                >

                    <span
                        class="live-elapsed"
                        data-start-ts="${session.started_at_ts || ''}"
                    >
                        ${
                            session.elapsed_display ||
                            formatElapsed(session.elapsed_seconds)
                        }
                    </span>

                </div>


                <span
                    class="live-stale-badge ${session.is_stale ? '' : 'hidden'} inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700"
                    title="No heartbeat for over ${session.stale_warning_minutes || 2} minutes. Auto-closes after ${session.stale_minutes || 5} minutes without a heartbeat."
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                    No heartbeat
                </span>


                <button
                    type="button"
                    class="manage-session inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-600 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                    data-session-id="${escapeAttr(session.session_id)}"
                    data-student-name="${escapeAttr(session.student_name || 'Live session')}"
                    data-device-name="${escapeAttr(session.device_name || session.workstation_name || 'Workstation')}"
                    data-lock-url="${escapeAttr(session.lock_url || '')}"
                    data-announce-url="${escapeAttr(session.announce_url || '')}"
                    data-device-url="${escapeAttr(session.device_url || '')}"
                    aria-haspopup="menu"
                    aria-expanded="false"
                    title="Manage this session"
                >
                    <svg
                        class="h-3.5 w-3.5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path stroke-linecap="round" d="M4 7h16M4 17h16"/>
                        <circle cx="9" cy="7" r="2"/>
                        <circle cx="15" cy="17" r="2"/>
                    </svg>

                    Manage

                    <svg
                        class="manage-chevron h-3 w-3"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                    </svg>
                </button>

            </div>
        `;


        return card;

    }


    /*
    |--------------------------------------------------------------------------
    | Update elapsed counters
    |--------------------------------------------------------------------------
    */

    function updateElapsed() {

        document
            .querySelectorAll('.live-elapsed')
            .forEach(function (el) {

                const ts =
                    el.getAttribute('data-start-ts');


                if (!ts) {

                    const started =
                        el.getAttribute('data-started');


                    if (!started) {
                        return;
                    }


                    const start =
                        new Date(started).getTime();


                    if (isNaN(start)) {
                        return;
                    }


                    let diff =
                        Math.floor(
                            (Date.now() - start) / 1000
                        );


                    if (diff < 0) {
                        diff = 0;
                    }


                    el.textContent =
                        formatElapsed(diff);


                    return;

                }


                let diff =
                    Math.floor(
                        Date.now() / 1000 -
                        Number(ts)
                    );


                if (diff < 0) {
                    diff = 0;
                }


                el.textContent =
                    formatElapsed(diff);

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Sync active sessions
    |--------------------------------------------------------------------------
    */

    function sync() {

        fetch(
            endpoint,
            {
                headers: {
                    'Accept': 'application/json'
                }
            }
        )

            .then(function (res) {

                return res.json();

            })

            .then(function (data) {

                const sessions =
                    Array.isArray(data)
                        ? data
                        : [];


                const currentIds =
                    new Set(
                        sessions.map(
                            function (session) {

                                return session.session_id;

                            }
                        )
                    );


                if (
                    menuEl &&
                    !menuEl.classList.contains('hidden') &&
                    !currentIds.has(menuEl.dataset.sessionId)
                ) {
                    closeManageMenu();
                }


                const existing =
                    listEl.querySelectorAll(
                        '.live-card'
                    );


                /*
                |--------------------------------------------------------------------------
                | Remove ended sessions
                |--------------------------------------------------------------------------
                */

                existing.forEach(function (card) {

                    const id =
                        card.getAttribute(
                            'data-session-id'
                        );


                    if (!currentIds.has(id)) {

                        card.classList.add(
                            'live-card-leave'
                        );


                        setTimeout(
                            function () {

                                if (card.parentNode) {

                                    card.parentNode
                                        .removeChild(card);

                                }


                                updateCount();

                            },
                            420
                        );

                    }

                });


                /*
                |--------------------------------------------------------------------------
                | Add or update sessions
                |--------------------------------------------------------------------------
                */

                sessions.forEach(
                    function (session) {

                        let card =
                            listEl.querySelector(
                                '.live-card[data-session-id="' +
                                CSS.escape(session.session_id) +
                                '"]'
                            );


                        if (!card) {

                            card =
                                createCard(session);


                            listEl.prepend(card);


                            requestAnimationFrame(
                                function () {

                                    card.classList.remove(
                                        'live-card-enter'
                                    );

                                }
                            );


                            updateElapsed();

                        } else {

                            const elapsedEl =
                                card.querySelector(
                                    '.live-elapsed'
                                );


                            if (elapsedEl) {

                                if (session.started_at_ts) {

                                    elapsedEl.setAttribute(
                                        'data-start-ts',
                                        session.started_at_ts
                                    );


                                    elapsedEl.removeAttribute(
                                        'data-started'
                                    );

                                } else if (
                                    session.started_at
                                ) {

                                    elapsedEl.setAttribute(
                                        'data-started',
                                        session.started_at
                                    );

                                }

                            }


                            const staleBadge =
                                card.querySelector(
                                    '.live-stale-badge'
                                );


                            if (staleBadge) {

                                staleBadge.classList.toggle(
                                    'hidden',
                                    !session.is_stale
                                );


                                if (session.is_stale) {

                                    staleBadge.title =
                                        'No heartbeat for over '
                                        + (session.stale_warning_minutes || 2)
                                        + ' minutes. Auto-closes after '
                                        + (session.stale_minutes || 5)
                                        + ' minutes without a heartbeat.';

                                }

                            }

                        }

                    }
                );


                updateCount();

            })

            .catch(function () {

                /*
                |--------------------------------------------------------------------------
                | Keep the current UI unchanged if the polling request fails.
                |--------------------------------------------------------------------------
                */

            });

    }


    /*
    |--------------------------------------------------------------------------
    | Update active count + empty state
    |--------------------------------------------------------------------------
    */

    function updateCount() {

        const count =
            listEl.querySelectorAll(
                '.live-card'
            ).length;


        if (countEl) {

            countEl.textContent =
                count + ' Active';

        }


        if (emptyEl) {

            if (count === 0) {

                emptyEl.classList.remove(
                    'hidden'
                );

            } else {

                emptyEl.classList.add(
                    'hidden'
                );

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Initialize live monitoring
    |--------------------------------------------------------------------------
    */

    updateCount();

    updateElapsed();


    setInterval(
        updateElapsed,
        1000
    );


    setInterval(
        sync,
        5000
    );

})();

</script>


{{-- Shared device actions, same modals as the Devices page --}}
<x-remote-lock-modal />
<x-remote-announce-modal />

@endsection
