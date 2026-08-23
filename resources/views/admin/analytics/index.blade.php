@extends('layout.app')

@section('title','Analytics')

@php
    $controlHeight = 'h-[52px]';
@endphp

@section('content')
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-12 mb-4">
        <div class="xl:col-span-1">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path d="M4 5h16v10H4V5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M9 19h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 15v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="text-right ms-3">
                        <div class="text-3xl font-semibold text-heading leading-none" id="total-workstations-top">10</div>
                        <div class="mt-1 text-sm text-body">Active Devices</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:col-span-1">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-yellow-300 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                    </div>
                    <div class="text-right ms-3">
                        <div class="text-3xl font-semibold text-heading leading-none" id="total-workstations-top">siya</div>
                        <div class="mt-1 text-sm text-body">Popular Device</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:col-span-1">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-4">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5" />
                        </svg>
                    </div>
                    <div class="text-right ms-3">
                        <div class="text-3xl font-semibold text-heading leading-none" id="total-access-events">10</div>
                        <div class="mt-1 text-sm text-body">Access Events</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:col-span-1">
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
                        <div class="text-3xl font-semibold text-heading leading-none" id="total-failed-attempts">10</div>
                        <div class="mt-1 text-sm text-body">Failed Access Events</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-12 ">
        <div class="xl:col-span-1">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-6">
                <div class="flex justify-between items-start pb-4 mb-4 border-b border-light">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-neutral-primary-medium border border-default-medium flex items-center justify-center rounded-full me-3">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20v-9l-4 1.125V20h4Zm0 0h8m-8 0V6.66667M16 20v-9l4 1.125V20h-4Zm0 0V6.66667M18 8l-6-4-6 4m5 1h2m-2 3h2"/>
                                </svg>
                            </div>

                            <h5 class="text-2xl font-bold text-heading me-2">Course Distribution</h5>

                            <svg data-popover-target="traffic-info" data-popover-placement="bottom" class="w-5 h-5 text-body hover:text-heading cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            <div data-popover id="traffic-info" role="tooltip" class="absolute z-10 p-3 invisible inline-block text-sm text-body transition-opacity duration-300 bg-neutral-primary-soft border border-default rounded-base shadow-xs opacity-0 w-72">
                                <div>
                                    <h3 class="font-semibold text-heading mb-2">Course Distribution</h3>
                                    <p class="mb-4">This chart shows the distribution of courses across different categories in the library system.</p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </div>
                        <p class="text-sm text-body">Top Courses this month</p>
                    </div>
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

                </div>
            </div>
        </div>
        <div class="xl:col-span-1">
            <div class="w-full bg-neutral-primary-soft border border-default rounded-lg shadow-xs p-6">
                <div class="flex justify-between items-start pb-4 mb-4 border-b border-light">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-neutral-primary-medium border border-default-medium flex items-center justify-center rounded-full me-3">
                                <svg class="w-6 h-6 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/></svg>
                            </div>

                            <h5 class="text-2xl font-bold text-heading me-2">Student Distribution</h5>

                            <svg data-popover-target="traffic-info" data-popover-placement="bottom" class="w-5 h-5 text-body hover:text-heading cursor-pointer" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            <div data-popover id="traffic-info" role="tooltip" class="absolute z-10 p-3 invisible inline-block text-sm text-body transition-opacity duration-300 bg-neutral-primary-soft border border-default rounded-base shadow-xs opacity-0 w-72">
                                <div>
                                    <h3 class="font-semibold text-heading mb-2">Student Distribution</h3>
                                    <p class="mb-4">This chart shows the distribution of students across different categories in the library system.</p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </div>
                        <p class="text-sm text-body">Top Students this month</p>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-4">
                <span class="text-body text-sm font-normal">Weekly Total Visitors</span>
                <span class="text-heading text-lg font-semibold">#</span>
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
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

    /* ════════════ PIE Courses ════════════ */
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

    /* ════════════ COLUMN Students ════════════ */
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
    });
</script>
