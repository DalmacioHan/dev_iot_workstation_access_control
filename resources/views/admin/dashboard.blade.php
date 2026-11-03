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

    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:auto-rows-[150px]">

        <div

            class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 p-6 text-white shadow-sm lg:row-span-2"

        >

            {{-- Decorative circles --}}

            <div class="pointer-events-none absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10"></div>

            <div class="pointer-events-none absolute -bottom-16 -left-10 h-40 w-40 rounded-full bg-white/5"></div>

            <div class="relative flex h-full flex-col justify-between">

                <div>

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-sm font-medium text-blue-100">

                                Total Devices

                            </p>

                            <p class="mt-2 text-5xl font-bold tracking-tight">

                                {{ number_format($totalDevices ?? 0) }}

                            </p>

                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">

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

                    <div class="mt-3 flex items-center justify-between text-xs text-blue-100">

                        <span>

                            {{ number_format($activeDevices ?? 0) }} active

                        </span>

                        <span>

                            {{ ($totalDevices ?? 0) > 0 ? round((($activeDevices ?? 0) / $totalDevices) * 100) : 0 }}%

                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">

                        Total Logins Today

                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">

                        {{ number_format($totalLoginsToday ?? 0) }}

                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">

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

            <p class="mt-5 text-xs text-gray-500">

                Successful RFID access today

            </p>

        </div>

        <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">

                        Unique Students

                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">

                        {{ number_format($uniqueStudentsToday ?? 0) }}

                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-50 text-violet-600">

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

            <p class="mt-5 text-xs text-gray-500">

                Students accessing the library today

            </p>

        </div>

        <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm transition hover:shadow-md">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">

                        Avg. Session Duration

                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">

                        {{ $avgSessionDuration ?? '0m' }}

                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-50 text-orange-600">

                    <svg

                        class="h-5 w-5"

                        fill="none"

                        stroke="currentColor"

                        stroke-width="1.8"

                        viewBox="0 0 24 24"

                    >

                        <circle cx="12" cy="12" r="9"></circle>

                        <path

                            stroke-linecap="round"

                            stroke-linejoin="round"

                            d="M12 7v5l3 2"

                        />

                    </svg>

                </div>

            </div>

            <p class="mt-5 text-xs text-gray-500">

                Average usage session

            </p>

        </div>

    </div>

    {{-- =========================================================

        LIVE PC USAGE

    ========================================================== --}}

    <div class="rounded-3xl border border-gray-100 bg-white shadow-sm overflow-hidden">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between px-6 pt-6 pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-bold text-gray-900">Live PC Usage</h2>
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>
                    <span id="live-active-count" class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">
                        {{ count($activeSessions ?? []) }} Active
                    </span>
                </div>
                <p class="mt-1 text-sm text-gray-500">Currently active sessions on workstations</p>
            </div>
        </div>
        <div class="px-6 pb-6">
            <div id="live-monitor-list" class="space-y-2">
                @forelse(($activeSessions ?? []) as $session)
                    <div class="live-card flex flex-col gap-3 rounded-2xl border border-gray-100 bg-gradient-to-r from-white to-gray-50/60 p-4 sm:flex-row sm:items-center sm:justify-between" data-session-id="{{ $session['session_id'] }}">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                                <span class="text-sm font-semibold">
                                    {{ strtoupper(mb_substr($session['student_name'] ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $session['student_name'] }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $session['course'] ?? 'N/A' }} @if(!empty($session['student_external_id'])) • {{ $session['student_external_id'] }} @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600">
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L8 20h8l-1.75-3M5 4h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                                </svg>
                                <span class="font-medium text-gray-900">{{ $session['workstation_name'] ?? ($session['device_uid'] ?? 'PC') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                                </svg>
                                <span>Started {{ $session['started_at_display'] }}</span>
                            </div>
                            <div class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                <span class="live-elapsed" data-start-ts="{{ $session['started_at_ts'] ?? '' }}">00:00</span>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <div id="live-monitor-empty" class="flex flex-col items-center justify-center py-6 text-center {{ count($activeSessions ?? []) > 0 ? 'hidden' : '' }}">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-50 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L8 20h8l-1.75-3M5 4h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                    </svg>
                </div>
                <p class="mt-2 text-sm font-medium text-gray-900">No active sessions right now</p>
                <p class="mt-1 text-xs text-gray-500">Students will appear here the moment they log in to a PC</p>
            </div>
        </div>
    </div>

    {{-- =========================================================

        MAIN BENTO CONTENT

    ========================================================== --}}

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- =====================================================

            LIBRARY DEVICE USAGE

        ====================================================== --}}

        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                <div>

                    <h2 class="text-lg font-bold text-gray-900">

                        Weekly Student Access

                    </h2>

                    <p class="mt-1 text-sm text-gray-500">

                        Daily unique students with successful access.

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

        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">

            <div>

                <h2 class="text-lg font-bold text-gray-900">

                    Course Distribution

                </h2>

                <p class="mt-1 text-sm text-gray-500">

                    Student distribution by course.

                </p>

            </div>

            <div class="mt-2 flex items-end gap-2">

                <span class="text-3xl font-bold text-gray-900">

                    {{ number_format($totalStudents ?? 0) }}

                </span>

                <span class="mb-1 text-sm text-gray-500">

                    students

                </span>

            </div>

            <div class="mt-4">

                <div id="pie-chart"></div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================

                LIBRARY DEVICE USAGE - COLUMN CHART

    ========================================================== */

    const maleData = @json($male ?? []);

    const femaleData = @json($female ?? []);

    const columnChartDays = @json($columnChartDays ?? []);

    const columnChartElement = document.querySelector('#column-chart');

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

                fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif',

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
        $sortedCourses = collect($courseDistribution ?? [])->sortDesc();
        $pieChartCourses = $sortedCourses->take(3);
        $othersCount = $sortedCourses->skip(3)->sum();
        if ($othersCount > 0) {
            $pieChartCourses->put('Other courses', $othersCount);
        }
    @endphp

    const courseLabels = @json($pieChartCourses->keys()->all());

    const courseCounts = @json($pieChartCourses->values()->all());

    const pieChartElement = document.querySelector('#pie-chart');

    if (pieChartElement) {

        const pieChartOptions = {

            series: courseCounts,

            labels: courseLabels,

            chart: {

                type: 'donut',

                height: 300,

                fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif'

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

                                    return courseCounts

                                        .reduce((sum, value) => sum + Number(value), 0);

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

                        return Number(value).toLocaleString() + ' students';

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

});

</script>

<style>
    .live-card {
        transition: transform 400ms ease, opacity 400ms ease, max-height 400ms ease, margin-top 400ms ease, padding-top 400ms ease, padding-bottom 400ms ease;
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
</style>

<script>
    (function() {
        const listEl = document.getElementById('live-monitor-list');
        const emptyEl = document.getElementById('live-monitor-empty');
        const countEl = document.getElementById('live-active-count');
        const endpoint = '{{ route('dashboard.active-sessions') }}';

        function formatElapsed(seconds) {
            const s = Math.max(0, Number(seconds) || 0);
            const h = Math.floor(s / 3600);
            const m = Math.floor((s % 3600) / 60);
            const sec = s % 60;
            if (h > 0) {
                return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
            }
            return String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
        }

        function createCard(session) {
            const card = document.createElement('div');
            card.className = 'live-card live-card-enter flex flex-col gap-3 rounded-2xl border border-gray-100 bg-gradient-to-r from-white to-gray-50/60 p-4 sm:flex-row sm:items-center sm:justify-between';
            card.setAttribute('data-session-id', session.session_id);

            const initial = (session.student_name || 'U').trim().charAt(0).toUpperCase();

            card.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <span class="text-sm font-semibold">${initial}</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">${session.student_name || ''}</p>
                        <p class="text-xs text-gray-500">${session.course || 'N/A'}${session.student_external_id ? ' • ' + session.student_external_id : ''}</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600">
                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L8 20h8l-1.75-3M5 4h14a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                        </svg>
                        <span class="font-medium text-gray-900">${session.workstation_name || session.device_uid || 'PC'}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                        </svg>
                        <span>Started ${session.started_at_display || ''}</span>
                    </div>
                    <div class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                        <span class="live-elapsed" data-start-ts="${session.started_at_ts || ''}">${formatElapsed(session.elapsed_seconds)}</span>
                    </div>
                </div>
            `;

            return card;
        }

        function updateElapsed() {
            document.querySelectorAll('.live-elapsed').forEach(function(el) {
                const ts = el.getAttribute('data-start-ts');
                if (!ts) {
                    const started = el.getAttribute('data-started');
                    if (!started) return;
                    const start = new Date(started).getTime();
                    if (isNaN(start)) return;
                    let diff = Math.floor((Date.now() - start) / 1000);
                    if (diff < 0) diff = 0;
                    el.textContent = formatElapsed(diff);
                    return;
                }
                let diff = Math.floor(Date.now() / 1000 - Number(ts));
                if (diff < 0) diff = 0;
                el.textContent = formatElapsed(diff);
            });
        }

        function sync() {
            fetch(endpoint, { headers: { 'Accept': 'application/json' } })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    const sessions = Array.isArray(data) ? data : [];
                    const currentIds = new Set(sessions.map(function(s) { return s.session_id; }));
                    const existing = listEl.querySelectorAll('.live-card');

                    existing.forEach(function(card) {
                        const id = card.getAttribute('data-session-id');
                        if (!currentIds.has(id)) {
                            card.classList.add('live-card-leave');
                            setTimeout(function() {
                                if (card.parentNode) {
                                    card.parentNode.removeChild(card);
                                }
                                updateCount();
                            }, 420);
                        }
                    });

                    sessions.forEach(function(session) {
                        let card = listEl.querySelector('.live-card[data-session-id="' + session.session_id.replace(/"/g, '\\"') + '"]');
                        if (!card) {
                            card = createCard(session);
                            listEl.prepend(card);
                            requestAnimationFrame(function() {
                                card.classList.remove('live-card-enter');
                            });
                            updateElapsed();
                        } else {
                            const elapsedEl = card.querySelector('.live-elapsed');
                            if (elapsedEl) {
                                if (session.started_at_ts) {
                                    elapsedEl.setAttribute('data-start-ts', session.started_at_ts);
                                    elapsedEl.removeAttribute('data-started');
                                } else if (session.started_at) {
                                    elapsedEl.setAttribute('data-started', session.started_at);
                                }
                            }
                        }
                    });

                    updateCount();
                })
                .catch(function() {});
        }

        function updateCount() {
            const count = listEl.querySelectorAll('.live-card').length;
            if (countEl) {
                countEl.textContent = count + (count === 1 ? ' Active' : ' Active');
            }
            if (emptyEl) {
                if (count === 0) {
                    emptyEl.classList.remove('hidden');
                } else {
                    emptyEl.classList.add('hidden');
                }
            }
        }

        updateCount();
        updateElapsed();
        setInterval(updateElapsed, 1000);
        setInterval(sync, 5000);
    })();
</script>

@endsection

