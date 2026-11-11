@extends('layout.app')

@section('title', 'Usage Analytics')

@section('content')

<div class="min-w-0 max-w-full space-y-6 overflow-x-hidden">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M7 16v-4m4 4V8m4 8v-7m4 7V5" />
                </svg>
                Analytics
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Usage Analytics
            </h1>

            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Access patterns across students, courses, applications, and workstations.
                For full searchable records, open Access Log or Student Summary.
            </p>
        </div>
    </div>

    {{-- Summary Metrics --}}
    <form method="GET" action="{{ route('analytics') }}" class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
        <div class="mb-4 flex items-center gap-2">
            <span
                class="flex h-6 w-6 items-center justify-center rounded-lg bg-blue-50 text-xs font-bold text-blue-600"
            >

                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="1.8" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                </svg>

            </span>
            <h3 class="text-sm font-bold text-gray-900">
                Filter Analytics
            </h3>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-2">
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
                    value="{{ $dateFrom->toDateString() }}"
                    onchange="this.form.submit()"
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
                    value="{{ $dateTo->toDateString() }}"
                    onchange="this.form.submit()"
                    class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                >
            </form>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-500">Popular Application</p>
                    <p class="mt-2 truncate text-xl font-bold text-slate-900" title="{{ $popularApplication->first()->app_name ?? 'N/A' }}">
                        {{ $popularApplication->first()->app_name ?? 'N/A' }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400">Most used · {{ $dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y') }}</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">

                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" >
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207"/>
                    </svg>

                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-500">Popular Workstation</p>
                    <p class="mt-2 truncate text-xl font-bold text-slate-900" title="{{ $popularWorkstation->first()->device->workstation_name ?? 'N/A' }}">
                        {{ $popularWorkstation->first()->device->workstation_name ?? 'N/A' }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400">Highest access · {{ $dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y') }}</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 16H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v1M9 12H4m8 8V9h8v11h-8Zm0 0H9m8-4a1 1 0 1 0-2 0 1 1 0 0 0 2 0Z"/>
                    </svg>

                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Successful Access</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($successfulEvents) ?? 'N/A' }}</p>
                    <p class="mt-1 text-xs text-slate-400">Successful sessions · {{ $dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y') }}</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l4 4L19 6" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Failed Access</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($failedEvents) ?? 'N/A' }}</p>
                    <p class="mt-1 text-xs text-slate-400">Failed events · {{ $dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y') }}</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 4h.01M10.3 3.9l-7.1 12.3A1.5 1.5 0 004.5 18.5h15a1.5 1.5 0 001.3-2.3L13.7 3.9a1.9 1.9 0 00-3.4 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Peak Hours --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-5 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Peak Hours</h2>
                <p class="mt-1 text-sm text-slate-500">Hours with the most access events · {{ $dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y') }}.</p>
            </div>
        </div>
        <div class="p-6">
            <div id="peak-hours-chart" class="min-h-70"></div>
        </div>
    </div>

    {{-- Ranked Activity --}}
    <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Students</h2>
                    <p id="student-ranking-description" class="mt-1 text-sm text-slate-500">Students with the most access events · {{ $dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y') }}.</p>
                </div>
                <div class="relative self-end sm:self-auto">
                    <button id="student-ranking-toggle" type="button" aria-expanded="false" aria-controls="student-ranking-dropdown" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        <span id="student-ranking-toggle-label">Access Events</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div id="student-ranking-dropdown" class="absolute right-0 z-20 mt-2 hidden w-44 overflow-hidden rounded-xl border border-gray-200 bg-white p-1 shadow-lg">
                        <button type="button" data-ranking-mode="access" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-gray-600 transition hover:bg-blue-50 hover:text-blue-700">
                            Access Events
                        </button>
                        <button type="button" data-ranking-mode="usage" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-gray-600 transition hover:bg-blue-50 hover:text-blue-700">
                            Time Usage
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100">
                <div id="top-students-chart" class="min-h-70"></div>
                <div>
                    <div class="flex justify-end px-6">
                        <a href="{{ route('reports.summary') }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            View Report
                            <svg class="w-4 h-4 ms-1.5 -me-0.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div id="top-students-usage" class="hidden overflow-x-auto">
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
                <div>
                    <div class="flex justify-end px-6 pb-5 pt-5">
                        <a href="{{ route('reports.summary') }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            View Report
                            <svg class="w-4 h-4 ms-1.5 -me-0.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Courses</h2>
                    <p class="mt-1 text-sm text-slate-500">Courses with the most access events · {{ $dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y') }}.</p>
                </div>
            </div>
            <div class="p-6">
                <div id="top-courses-chart" class="min-h-70"></div>
            </div>
            <div>
                <div class="flex justify-end px-6 pb-5">
                    <a href="{{ route('reports.accesslog') }}" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        View Report
                        <svg class="w-4 h-4 ms-1.5 -me-0.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Application</h2>
                    <p class="mt-1 text-sm text-slate-500">Applications with the most access events · {{ $dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y') }}.</p>
                </div>
            </div>
            <div class="p-6">
                <div id="top-app-chart" class="min-h-70"></div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartElement = document.querySelector('#peak-hours-chart');
    const getBrandColor = () => {
        const computedStyle = getComputedStyle(document.documentElement);

        return computedStyle.getPropertyValue('--color-fg-brand').trim() || '#1447E6';
    };
    const brandColor = getBrandColor();

    if (!chartElement || typeof ApexCharts === 'undefined') {
        return;
    }

    const peakHours = @json($peakHours);
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
            name: 'Access events',
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
                    return `${value} event${value === 1 ? '' : 's'}`;
                }
            }
        }
    });

    chart.render();

    const rankingToggle = document.querySelector('#student-ranking-toggle');
    const rankingToggleLabel = document.querySelector('#student-ranking-toggle-label');
    const rankingDropdown = document.querySelector('#student-ranking-dropdown');
    const rankingDescription = document.querySelector('#student-ranking-description');
    const accessChart = document.querySelector('#top-students-chart')?.parentElement;
    const usageTable = document.querySelector('#top-students-usage');
    const dateRange = @json($dateFrom->isToday() && $dateTo->isToday() ? 'Today' : $dateFrom->format('M j, Y') . ' to ' . $dateTo->format('M j, Y'));

    if (rankingToggle && rankingToggleLabel && rankingDropdown && rankingDescription && accessChart && usageTable) {
        rankingToggle.addEventListener('click', function () {
            const isOpen = rankingToggle.getAttribute('aria-expanded') === 'true';

            rankingToggle.setAttribute('aria-expanded', String(!isOpen));
            rankingDropdown.classList.toggle('hidden', isOpen);
        });

        rankingDropdown.querySelectorAll('[data-ranking-mode]').forEach((option) => {
            option.addEventListener('click', function () {
                const isUsageMode = option.dataset.rankingMode === 'usage';

                rankingToggleLabel.textContent = isUsageMode ? 'Time Usage' : 'Access Events';
                rankingDescription.textContent = `Students with the most ${isUsageMode ? 'time usage' : 'access events'} · ${dateRange}.`;
                accessChart.classList.toggle('hidden', isUsageMode);
                usageTable.classList.toggle('hidden', !isUsageMode);
                rankingDropdown.classList.add('hidden');
                rankingToggle.setAttribute('aria-expanded', 'false');
            });
        });

        document.addEventListener('click', function (event) {
            if (!rankingToggle.contains(event.target) && !rankingDropdown.contains(event.target)) {
                rankingDropdown.classList.add('hidden');
                rankingToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    const renderRankedBarChart = (elementId, entries, emptyMessage, color) => {
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
                name: 'Access',
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
                    formatter: (value) => `${Number(value).toLocaleString()} accesses`
                }
            },
            legend: { show: true }
        }).render();
    };

    renderRankedBarChart(
        'top-students-chart',
        @json($topAccessStudents->map(fn ($student) => ['label' => $student->student_name, 'total' => $student->total])->values()),
        'No student activity found for this period.',
        '#2563EB'
    );

    renderRankedBarChart(
        'top-courses-chart',
        @json($topCourses->map(fn ($course) => ['label' => $course->course, 'total' => $course->total])->values()),
        'No course activity found for this period.',
        '#1D4ED8'
    );

    renderRankedBarChart(
        'top-app-chart',
        @json($topApplication->map(fn ($app) => ['label' => $app->app_name, 'total' => $app->total_sessions])->values()),
        'No application activity found for this period.',
        '#1D4ED8'
    );
});
</script>
@endsection
