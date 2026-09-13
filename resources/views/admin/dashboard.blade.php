@extends('layout.app')

@section('title','dashboard')

@section('content')


<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    {{-- Card 1 --}}
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path d="M12 7a5 5 0 0 1 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 3a9 9 0 0 1 9 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 11a1 1 0 1 1 0 2a1 1 0 0 1 0-2Z" fill="currentColor"/>
                    <path d="M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="text-right ms-3">
                <div class="text-3xl font-semibold text-heading leading-none" id="total-devices">{{ $totalDevices }}</div>
                <div class="mt-1 text-sm text-body">Total Devices</div>
            </div>
        </div>
        <div class="mt-2 text-xs text-body" id="total-devices-sub">{{ $activeDevices }} active</div>
    </div>

    {{-- Card 2 --}}
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path d="M4 12h4l2-5 4 10 2-5h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="text-right ms-3">
                <div class="text-3xl font-semibold text-heading leading-none" id="online-devices">{{ $onlineDevices }}</div>
                <div class="mt-1 text-sm text-body">Online Devices</div>
            </div>
        </div>
        <div class="mt-2 text-xs text-body" id="online-devices-sub">{{ $totalDevices - $onlineDevices }} offline</div>
    </div>

    {{-- Card 3 --}}
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl bg-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path d="M4 5h16v10H4V5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M9 19h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 15v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="text-right ms-3">
                <div class="text-3xl font-semibold text-heading leading-none" id="total-workstations-top">{{ $totalWorkstations }}</div>
                <div class="mt-1 text-sm text-body">Total WorkStations</div>
            </div>
        </div>
        <div class="mt-2 text-xs text-body" id="total-workstations-sub">{{ $activeWorkstations }} active</div>
    </div>

    {{-- Card 4 --}}
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-xl bg-orange-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path d="M12 9v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 17h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M10 3h4l7 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V10l7-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="text-right ms-3">
                <div class="text-3xl font-semibold text-heading leading-none" id="slot-utilization">{{ $slotUtilization }}%</div>
                <div class="mt-1 text-sm text-body">Slot Utilization</div>
            </div>
        </div>
        <div class="mt-2 text-xs text-body">Overall capacity</div>
    </div>
</div>

{{-- =============================== --}}
{{-- LIBRARY USAGE & COURSE WIDGETS  --}}
{{-- =============================== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    
    <!-- First Widget - Library Workstation Usage -->
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-6">
        <div class="flex justify-between items-start pb-4 mb-4 border-b border-light">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-neutral-primary-medium border border-default-medium flex items-center justify-center rounded-full me-3">
            <svg class="w-6 h-6 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/></svg>
            </div>
            <div>
            <h5 class="text-3xl font-bold text-heading">Library Workstation Usage</h5>
            <p class="text-sm text-body">{{ $weeklyVisitors }} visitors this week</p>
            </div>
        </div>
        </div>

        <div class="flex justify-between items-center mb-4">
        <span class="text-body text-sm font-normal">Weekly Total Visitors</span>
        <span class="text-heading text-lg font-semibold">{{ $weeklyVisitors }}</span>
        </div>
        
        <div id="column-chart" class="mb-4"></div>
        
        <div class="flex justify-between items-center pt-4 border-t border-light">
        <a href="#" class="inline-flex items-center text-fg-brand bg-transparent border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium rounded-base text-sm px-3 py-2 focus:outline-none">
            View Report
            <svg class="w-4 h-4 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
        </a>
        </div>
    </div>

    <!-- Second Widget - Courses -->
    <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-6">
        <div class="flex justify-between items-start pb-4 mb-4 border-b border-light">
        <div>
            <div class="flex items-center mb-2">
            <h5 class="text-3xl font-bold text-heading">Course Distribution</h5>
            </div>
            <p class="text-sm text-body">Top courses this month</p>
        </div>

        </div>

        <div class="flex justify-between items-center mb-4">
        <span class="text-body text-sm font-normal">Total Students</span>
        <span class="text-heading text-lg font-semibold">{{ $totalStudents }}</span>
        </div>

        <div id="pie-chart" class="mb-4"></div>

        <div class="flex justify-between items-center pt-4 border-t border-light">
        <a href="#" class="inline-flex items-center text-fg-brand bg-transparent border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium rounded-base text-sm px-3 py-2 focus:outline-none">
            Course Report
            <svg class="w-4 h-4 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
        </a>
        </div>
    </div>
    </div>
@php
    $sortedCourses = collect($courseDistribution)->sortDesc();
    $pieChartCourses = $sortedCourses->take(max(3, min($sortedCourses->count(), 5)));
@endphp
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Laravel data: dynamic and from the database, including when only one visitor is available
    const maleData = @json($male);
    const femaleData = @json($female);
    const columnChartDays = @json($columnChartDays);
    const courseLabels = @json($pieChartCourses->keys()->all());
    const courseCounts = @json($pieChartCourses->values()->all());

    // COLUMN CHART
    const getBrandColor = () => getComputedStyle(document.documentElement).getPropertyValue('--color-fg-brand').trim() || "#1447E6";
    const getBrandSecondaryColor = () => getComputedStyle(document.documentElement).getPropertyValue('--color-fg-brand-subtle').trim() || "#93C5FD";
    const brandColor = getBrandColor();
    const brandSecondaryColor = getBrandSecondaryColor();

    const columnChartOptions = {
        colors: [brandColor, brandSecondaryColor],
        series: [
        {
            name: "Male",
            color: brandColor,
            data: maleData.map((y, i) => ({ x: columnChartDays[i], y }))
        },
        {
            name: "Female",
            color: brandSecondaryColor,
            data: femaleData.map((y, i) => ({ x: columnChartDays[i], y }))
        }
        ],
        chart: {
        type: "bar",
        height: "280px",
        fontFamily: "Inter, sans-serif",
        toolbar: { show: false },
        },
        plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadiusApplication: "end", borderRadius: 8 } },
        tooltip: { shared: true, intersect: false, style: { fontFamily: "Inter, sans-serif" } },
        states: { hover: { filter: { type: "darken", value: 1 } } },
        stroke: { show: true, width: 0, colors: ["transparent"] },
        grid: { show: false, strokeDashArray: 4, padding: { left: 2, right: 2, top: -14 } },
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: {
        categories: columnChartDays,
        floating: false,
        labels: { show: true, style: { fontFamily: "Inter, sans-serif", cssClass: 'text-xs font-normal fill-body' } },
        axisBorder: { show: false }, axisTicks: { show: false },
        },
        yaxis: { show: false },
        fill: { opacity: 1 }
    };

    if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
        const columnChart = new ApexCharts(document.getElementById("column-chart"), columnChartOptions);
        columnChart.render();
    }

    // PIE CHART
    const getBrandTertiaryColor = () => getComputedStyle(document.documentElement).getPropertyValue('--color-fg-brand-strong').trim() || "#1E40AF";
    const getNeutralPrimaryColor = () => getComputedStyle(document.documentElement).getPropertyValue('--color-neutral-primary').trim() || "#FFFFFF";
    const brandTertiaryColor = getBrandTertiaryColor();
    const neutralPrimaryColor = getNeutralPrimaryColor();
    const bluePalette = [
        "#1447E6",
        "#2563EB",
        "#3B82F6",
        "#60A5FA",
        "#93C5FD",
    ];

    const pieChartOptions = {
        series: courseCounts,
        colors: bluePalette,
        chart: { height: 315, width: "100%", type: "pie" },
        stroke: { colors: [neutralPrimaryColor], lineCap: "" },
        plotOptions: { pie: { labels: { show: true }, size: "100%", dataLabels: { offset: -25 } } },
        labels: courseLabels,
        dataLabels: { enabled: true, style: { fontFamily: "Inter, sans-serif" } },
        legend: { show: false },
        yaxis: { labels: { formatter: function (value) { return value + "%" } } },
        xaxis: { labels: { formatter: function (value) { return value  + "%" } }, axisTicks: { show: false }, axisBorder: { show: false } }
    };

    if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
        const pieChart = new ApexCharts(document.getElementById("pie-chart"), pieChartOptions);
        pieChart.render();
    }

    });
    </script>

@endsection