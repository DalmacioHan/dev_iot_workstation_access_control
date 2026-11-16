@extends('layout.app')

@section('title', 'Overview')

@section('content')

@php
    $isDefaultRange = $dateFrom->isToday() && $dateTo->isToday();
    $rangeLabel = $isDefaultRange
        ? 'Today'
        : $dateFrom->format('M j, Y') . ' – ' . $dateTo->format('M j, Y');

    // Carry the Overview range into Reports so the report opens on the
    // same period the card was showing.
    $reportRange = [
        'period' => $isDefaultRange ? 'today' : 'custom',
        'date_from' => $dateFrom->toDateString(),
        'date_to' => $dateTo->toDateString(),
    ];
@endphp

<div class="min-w-0 max-w-full space-y-8 overflow-x-hidden">

    {{-- ======= PAGE HEADER ======= --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                <x-icon name="chart-vertical" class="h-3.5 w-3.5" aria-hidden="true" />
                Insights
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Overview
            </h1>

            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Login patterns across students, courses, applications, and workstations.
                For full searchable records, open Reports.
            </p>
        </div>

        <div class="flex items-center gap-2 self-start sm:self-auto">
            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                {{ $rangeLabel }}
            </span>

            <div class="relative">
                <button
                    id="overview-filter-toggle"
                    type="button"
                    aria-expanded="false"
                    aria-controls="overview-filter-panel"
                    class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <x-icon name="filter" class="h-4 w-4" aria-hidden="true" />
                    Filters
                    <x-icon name="chevron-down" class="h-4 w-4" aria-hidden="true" />
                </button>

                <form
                    id="overview-filter-panel"
                    method="GET"
                    action="{{ route('analytics') }}"
                    class="absolute right-0 z-30 mt-2 hidden w-80 max-w-[calc(100vw-2rem)] rounded-2xl border border-slate-200 bg-white p-5 shadow-lg"
                >
                    <div class="space-y-4">
                        <div>
                            <label for="date_from" class="mb-2 block text-xs font-semibold text-gray-600">
                                Date From
                            </label>
                            <input
                                type="date"
                                id="date_from"
                                name="date_from"
                                value="{{ $dateFrom->toDateString() }}"
                                class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            >
                        </div>

                        <div>
                            <label for="date_to" class="mb-2 block text-xs font-semibold text-gray-600">
                                Date To
                            </label>
                            <input
                                type="date"
                                id="date_to"
                                name="date_to"
                                value="{{ $dateTo->toDateString() }}"
                                class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            >
                        </div>
                    </div>

                    <div class="mt-5 flex items-center justify-between gap-2 border-t border-slate-100 pt-4">
                        @if (! $isDefaultRange)
                            <a href="{{ route('analytics') }}" class="inline-flex h-10 items-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                                Reset
                            </a>
                        @endif

                        <button type="submit" class="ml-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            Apply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ======= SUMMARY CARDS ======= --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-500">Popular Application</p>
                    <p class="mt-3 truncate text-2xl font-bold tracking-tight text-slate-900" title="{{ $popularApplication->first()?->app_name ?? 'N/A' }}">
                        {{ $popularApplication->first()?->app_name ?? 'N/A' }}
                    </p>
                    <p class="mt-2 text-xs font-medium text-slate-400">Most used</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                    <x-icon name="chart" class="h-5 w-5" aria-hidden="true" />
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-500">Popular Workstation</p>
                    <p class="mt-3 truncate text-2xl font-bold tracking-tight text-slate-900" title="{{ $popularWorkstation->first()?->device?->workstation_name ?? 'N/A' }}">
                        {{ $popularWorkstation->first()?->device?->workstation_name ?? 'N/A' }}
                    </p>
                    <p class="mt-2 text-xs font-medium text-slate-400">Most active</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                    <x-icon name="dashboard" class="h-5 w-5" aria-hidden="true" />
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Successful Logins</p>
                    <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($successfulLogins) }}</p>
                    <p class="mt-2 text-xs font-medium text-slate-400">Unique students</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <x-icon name="check" class="h-5 w-5" aria-hidden="true" />
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Failed Logins</p>
                    <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($failedLogins) }}</p>
                    <p class="mt-2 text-xs font-medium text-slate-400">Failed attempts</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                    <x-icon name="exclamation-triangle" class="h-5 w-5" aria-hidden="true" />
                </div>
            </div>
        </div>
    </div>

    {{-- ======= PEAK HOURS ======= --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-6 py-5">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Peak Hours</h2>
                <p class="mt-1 text-sm text-slate-500">Hours with the most logins.</p>
            </div>
        </div>
        <div class="p-6">
            <div id="peak-hours-chart" class="min-h-80"></div>
        </div>
    </div>

    {{-- ======= RANKED ACTIVITY ======= --}}
    <div class="grid grid-cols-1 gap-6">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Students</h2>
                    <p id="student-ranking-description" class="mt-1 text-sm text-slate-500">Students with the most logins.</p>
                </div>
                <div class="relative self-end sm:self-auto">
                    <button id="student-ranking-toggle" type="button" aria-expanded="false" aria-controls="student-ranking-dropdown" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        <span id="student-ranking-toggle-label">Logins</span>
                        <x-icon name="chevron-down" class="h-4 w-4" aria-hidden="true" />
                    </button>
                    <div id="student-ranking-dropdown" class="absolute right-0 z-20 mt-2 hidden w-44 overflow-hidden rounded-xl border border-gray-200 bg-white p-1 shadow-lg">
                        <button type="button" data-ranking-mode="access" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-gray-600 transition hover:bg-blue-50 hover:text-blue-700">
                            Logins
                        </button>
                        <button type="button" data-ranking-mode="usage" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-gray-600 transition hover:bg-blue-50 hover:text-blue-700">
                            Time Usage
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div id="top-students-chart" class="min-h-80"></div>
                <div class="mt-4 flex justify-end border-t border-slate-100 pt-4">
                    <a href="{{ route('reports.index', array_merge($reportRange, ['tab' => 'students', 'step' => 4])) }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        View Report
                        <x-icon name="arrow-right" class="w-4 h-4" aria-hidden="true" />
                    </a>
                </div>
            </div>

            <div id="top-students-usage" class="hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[520px] text-left text-sm text-slate-600">
                        <thead class="border-b border-slate-100 bg-slate-50/70 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">#</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Student Name</th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold">Overall Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($topUsageStudents as $index => $student)
                                <tr class="transition-colors hover:bg-blue-50/30">
                                    <td class="px-6 py-4 font-semibold text-slate-400">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $student->student_name }}</td>
                                    <td class="px-6 py-4 text-center font-mono text-xs text-slate-700">{{ $student->total_time ?? '0h 0m 0s' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-12 text-center text-sm text-slate-400">No student activity found for this period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end border-t border-slate-100 px-6 py-4">
                    <a href="{{ route('reports.index', array_merge($reportRange, ['tab' => 'students', 'step' => 4])) }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        View Report
                        <x-icon name="arrow-right" class="w-4 h-4" aria-hidden="true" />
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Courses</h2>
                    <p class="mt-1 text-sm text-slate-500">Courses with the most logins.</p>
                </div>
            </div>
            <div class="p-6">
                <div id="top-courses-chart" class="min-h-80"></div>
                <div class="mt-4 flex justify-end border-t border-slate-100 pt-4">
                    <a href="{{ route('reports.index', array_merge($reportRange, ['tab' => 'access', 'step' => 4, 'event' => 'time_in', 'result' => 'allowed'])) }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        View Report
                        <x-icon name="arrow-right" class="w-4 h-4" aria-hidden="true" />
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Workstations</h2>
                    <p class="mt-1 text-sm text-slate-500">Workstations with the most successful logins.</p>
                </div>
            </div>
            <div class="p-6">
                <div id="top-workstations-chart" class="min-h-80"></div>
                <div class="mt-4 flex justify-end border-t border-slate-100 pt-4">
                    <a href="{{ route('reports.index', array_merge($reportRange, ['tab' => 'access', 'step' => 4, 'event' => 'time_in', 'result' => 'allowed'])) }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        View Report
                        <x-icon name="arrow-right" class="w-4 h-4" aria-hidden="true" />
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Application</h2>
                    <p class="mt-1 text-sm text-slate-500">Applications with the most usage.</p>
                </div>
            </div>
            <div class="p-6">
                <div id="top-app-chart" class="min-h-80"></div>
                <div class="mt-4 flex justify-end border-t border-slate-100 pt-4">
                    <a href="{{ route('monitoring', ['tab' => 'apps']) }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        View Logs
                        <x-icon name="arrow-right" class="w-4 h-4" aria-hidden="true" />
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@vite('resources/js/charts.js')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const getBrandColor = () => {
        const computedStyle = getComputedStyle(document.documentElement);

        return computedStyle.getPropertyValue('--color-fg-brand').trim() || '#1447E6';
    };
    const brandColor = getBrandColor();
    const dateRange = @json($rangeLabel);

    // ===== Dropdown helper =====
    const setupDropdown = (toggle, panel) => {
        if (!toggle || !panel) {
            return;
        }

        toggle.addEventListener('click', function () {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';

            toggle.setAttribute('aria-expanded', String(!isOpen));
            panel.classList.toggle('hidden', isOpen);
        });

        document.addEventListener('click', function (event) {
            if (!toggle.contains(event.target) && !panel.contains(event.target)) {
                panel.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    };

    // ===== Overview filters =====
    const filterToggle = document.querySelector('#overview-filter-toggle');
    const filterPanel = document.querySelector('#overview-filter-panel');
    const dateFromInput = document.querySelector('#date_from');
    const dateToInput = document.querySelector('#date_to');

    setupDropdown(filterToggle, filterPanel);

    dateFromInput?.addEventListener('change', function () {
        if (dateToInput && dateToInput.value && this.value > dateToInput.value) {
            dateToInput.value = this.value;
        }
    });

    dateToInput?.addEventListener('change', function () {
        if (dateFromInput && dateFromInput.value && this.value < dateFromInput.value) {
            dateFromInput.value = this.value;
        }
    });

    // ===== Student ranking toggle =====
    const rankingToggle = document.querySelector('#student-ranking-toggle');
    const rankingToggleLabel = document.querySelector('#student-ranking-toggle-label');
    const rankingDropdown = document.querySelector('#student-ranking-dropdown');
    const rankingDescription = document.querySelector('#student-ranking-description');
    const accessChart = document.querySelector('#top-students-chart')?.parentElement;
    const usageTable = document.querySelector('#top-students-usage');

    setupDropdown(rankingToggle, rankingDropdown);

    if (rankingToggleLabel && rankingDropdown && rankingDescription && accessChart && usageTable) {
        rankingDropdown.querySelectorAll('[data-ranking-mode]').forEach((option) => {
            option.addEventListener('click', function () {
                const isUsageMode = option.dataset.rankingMode === 'usage';

                rankingToggleLabel.textContent = isUsageMode ? 'Time Usage' : 'Logins';
                rankingDescription.textContent = `Students with the most ${isUsageMode ? 'time usage' : 'logins'}.`;
                accessChart.classList.toggle('hidden', isUsageMode);
                usageTable.classList.toggle('hidden', !isUsageMode);
                rankingDropdown.classList.add('hidden');
                rankingToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // ===== Peak hours chart =====
    const chartElement = document.querySelector('#peak-hours-chart');
    const peakHours = @json($peakHours);

    if (!chartElement || typeof ApexCharts === 'undefined') {
        return;
    }
    // Generate clean hourly labels: "00:00", "01:00", ... "23:00"
    const hourLabels = Array.from({ length: 24 }, (_, hour) => `${String(hour).padStart(2, '0')}:00`);

    const chart = new ApexCharts(chartElement, {
        chart: {
            type: 'area',
            height: "100%",
            width: "100%",
            fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif',
            toolbar: { show: true },
            zoom: { enabled: false }
        },
        series: [{
            name: 'Logins',
            data: peakHours // Clean single data mapping array
        }],
        colors: [brandColor],
        stroke: {
            curve: 'smooth',
            width: 6
        },
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.55,
                opacityTo: 0,
                shade: brandColor,
                gradientToColors: [brandColor],
            },
        },
        dataLabels: { enabled: false },
        grid: {
            borderColor: '#e2e8f0',
            strokeDashArray: 4,
            padding: { left: 8, right: 8 }
        },
        xaxis: {
            categories: hourLabels, // Links categories directly to index matching peakHours
            axisBorder: { show: true },
            axisTicks: { show: true }
        },
        yaxis: {
            min: 0,
            forceNiceScale: true,
            labels: {
                formatter: function (value) {
                    return Math.round(value);
                }
            }
        },
        tooltip: {
            x: {
                formatter: function(val, { dataPointIndex }) {
                    // Displays the exact hour range (e.g., "14:00") when hovered
                    return hourLabels[dataPointIndex] || val;
                }
            },
            y: {
                formatter: function (value) {
                    return `${value} login${value === 1 ? '' : 's'}`;
                }
            }
        }
    });

    chart.render();

    // ===== Ranked bar charts =====
    const renderRankedBarChart = (elementId, entries, emptyMessage, color, unit) => {
        const element = document.querySelector(`#${elementId}`);

        if (!element) {
            return;
        }

        const labels = entries.map((entry) => entry.label);
        const values = entries.map((entry) => Number(entry.total));

        if (!values.length) {
            element.innerHTML = `<p class="py-12 text-center text-sm text-slate-400">${emptyMessage}</p>`;
            return;
        }

        new ApexCharts(element, {
            series: [{
                name: unit === 'sessions' ? 'Sessions' : 'Logins',
                data: values
            }],
            chart: {
                type: 'bar',
                height: Math.max(260, values.length * 42),
                width: '100%',
                fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif',
                toolbar: { show: true }
            },
            colors: [color],
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '58%',
                    borderRadius: 6,
                    borderRadiusApplication: 'end'
                }
            },
            dataLabels: { enabled: true },
            grid: {
                borderColor: '#F3F4F6',
                strokeDashArray: 4,
                padding: { left: 8, right: 20 }
            },
            xaxis: {
                categories: labels,
                min: 0,
                labels: {
                    style: { colors: '#9CA3AF', fontSize: '12px' },
                    formatter: (value) => Math.round(value).toLocaleString()
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#6B7280', fontSize: '12px'},
                    minWidth: 160,
                    maxWidth: 160,
                    offsetX: 0
                }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: (value) => `${Number(value).toLocaleString()} ${unit}`
                }
            },
            legend: { show: true }
        }).render();
    };

    renderRankedBarChart(
        'top-students-chart',
        @json($topAccessStudents->map(fn ($student) => ['label' => $student->student_name, 'total' => $student->total])->values()),
        'No student activity found for this period.',
        '#2563EB',
        'logins'
    );

    renderRankedBarChart(
        'top-courses-chart',
        @json($topCourses->map(fn ($course) => ['label' => $course->course, 'total' => $course->total])->values()),
        'No course activity found for this period.',
        '#1D4ED8',
        'logins'
    );

    renderRankedBarChart(
        'top-workstations-chart',
        @json($topWorkstations->map(fn ($workstation) => ['label' => $workstation->device?->workstation_name ?? 'Unknown Workstation', 'total' => $workstation->total])->values()),
        'No workstation activity found for this period.',
        '#D97706',
        'logins'
    );

    renderRankedBarChart(
        'top-app-chart',
        @json($topApplication->map(fn ($app) => ['label' => $app->app_name, 'total' => $app->total_sessions])->values()),
        'No application activity found for this period.',
        '#1D4ED8',
        'sessions'
    );
});
</script>
@endsection
