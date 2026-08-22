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
            <h5 class="text-3xl font-bold text-heading">{{ $weeklyVisitors }}</h5>
            <p class="text-sm text-body">Library Workstation Usage</p>
            </div>
        </div>
        </div>

        <div class="flex justify-between items-center mb-4">
        <span class="text-body text-sm font-normal">Weekly Total Visitors</span>
        <span class="text-heading text-lg font-semibold">{{ $weeklyVisitors }}</span>
        </div>
        
        <div id="column-chart" class="mb-4"></div>
        
        <div class="flex justify-between items-center pt-4 border-t border-light">
        <button id="dropdownLastDaysButton" data-dropdown-toggle="LastDaysdropdown" data-dropdown-placement="bottom" class="text-sm font-medium text-body hover:text-heading inline-flex items-center" type="button">
            Last 7 days
            <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
        </button>
        <div id="LastDaysdropdown" class="z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44">
            <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownLastDaysButton">
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Yesterday</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Today</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Last 7 days</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Last 30 days</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Last 90 days</a></li>
            </ul>
        </div>
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
            <h5 class="text-2xl font-bold text-heading me-2">Course Distribution</h5>
            <svg data-popover-target="traffic-info" data-popover-placement="bottom" class="w-5 h-5 text-body hover:text-heading cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            <div data-popover id="traffic-info" role="tooltip" class="absolute z-10 p-3 invisible inline-block text-sm text-body transition-opacity duration-300 bg-neutral-primary-soft border border-default rounded-base shadow-xs opacity-0 w-72">
            
                <div data-popper-arrow></div>
            </div>
            </div>
            <p class="text-sm text-body">Top courses this month</p>
        </div>
        <button id="widgetDropdownButton" data-dropdown-toggle="widgetDropdown" data-dropdown-placement="bottom" type="button" class="inline-flex items-center justify-center text-body bg-neutral-primary-soft hover:bg-neutral-tertiary hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium rounded-base text-sm w-9 h-9 focus:outline-none">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M6 12h.01m6 0h.01m5.99 0h.01"/></svg>
            <span class="sr-only">Open dropdown</span>
        </button>
        <div id="widgetDropdown" class="z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44">
            <ul class="p-2 text-sm text-body font-medium" aria-labelledby="widgetDropdownButton">
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded"><svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z"/></svg>Edit widget</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded"><svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/></svg>Download data</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded"><svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/></svg>Delete widget</a></li>
            </ul>
        </div>
        </div>

        <div class="flex justify-between items-center mb-4">
        <span class="text-body text-sm font-normal">Total Students</span>
        <span class="text-heading text-lg font-semibold">{{ $totalStudents }}</span>
        </div>

        <div id="pie-chart" class="mb-4"></div>

        <div class="flex justify-between items-center pt-4 border-t border-light">
        <button id="dropdownLastDays4Button" data-dropdown-toggle="LastDays4dropdown" data-dropdown-placement="bottom" class="text-sm font-medium text-body hover:text-heading inline-flex items-center" type="button">
            Last 7 days
            <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
        </button>
        <div id="LastDays4dropdown" class="z-10 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44">
            <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownLastDays4Button">
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Yesterday</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Today</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Last 7 days</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Last 30 days</a></li>
            <li><a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Last 90 days</a></li>
            </ul>
        </div>
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
        chart: { height: 280, width: "100%", type: "pie" },
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