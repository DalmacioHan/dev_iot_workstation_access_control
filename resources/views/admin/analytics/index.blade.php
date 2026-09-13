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
                        <div class="text-3xl font-semibold text-heading leading-none" id="total-workstations-top">{{ $activeDevices }}</div>
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
                        <div class="text-3xl font-semibold text-heading leading-none" id="total-workstations-top">{{ $popularDevice?->name ?? $onlineDevices }}</div>
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
                        <div class="text-3xl font-semibold text-heading leading-none" id="total-access-events">{{ $totalEvents }}</div>
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
                        <div class="text-3xl font-semibold text-heading leading-none" id="total-failed-attempts">{{ $failedEvents }}</div>
                        <div class="mt-1 text-sm text-body">Failed Access Events</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--table-->
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-12 mb-4">
        <!-- Card 1: Top 10 Students -->
        <div class="rounded-lg border border-gray-200 bg-white">
            <div>
                <div class="w-full bg-neutral-primary-soft p-5 border-b border-light flex items-center justify-between">
                    <h3 class="text-lg font-bold text-black uppercase">Top 10 Students</h3>
                    <div class="relative">
                        <button id="topStudentsDropdownButton" data-dropdown-toggle="topStudentsDropdown" data-dropdown-placement="bottom" class="text-sm font-medium text-body hover:text-heading inline-flex items-center" type="button">
                            {{ $studentRangeLabel }}
                            <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                        </button>
                        <!-- Absolute placement and high z-index added -->
                        <div id="topStudentsDropdown" class="z-50 hidden absolute right-0 top-full mt-2 bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44">
                            <ul class="p-2 text-sm text-body font-medium" aria-labelledby="topStudentsDropdownButton">
                                @foreach($rangeLabels as $range => $label)
                                    <li><a href="{{ route('analytics', ['students_range' => $range, 'courses_range' => $courseRange]) }}" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">{{ $label }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-700">
                        <thead class="bg-white uppercase text-black border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-5 py-5">#</th>
                                <th scope="col" class="px-5 py-5">Student Name</th>
                                <th scope="col" class="px-5 py-5 text-center">Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topStudents as $index => $student)
                                <tr class="border-b border-gray-200">
                                    <td class="px-5 py-5">{{ $index + 1 }}</td>
                                    <td class="px-5 py-5">{{ $student->student_name }}</td>
                                    <td class="px-5 py-5 text-center">{{ $student->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card 2: Top 10 Courses -->
        <div class="rounded-lg border border-gray-200 bg-white">
            <div>
                <div class="w-full bg-neutral-primary-soft p-5 border-b border-light flex items-center justify-between">
                    <h3 class="text-lg font-bold text-black text-left uppercase">Top 10 Courses</h3>
                    <div class="relative">
                        <button id="topCoursesDropdownButton" data-dropdown-toggle="topCoursesDropdown" data-dropdown-placement="bottom" class="text-sm font-medium text-body hover:text-heading inline-flex items-center" type="button">
                            {{ $courseRangeLabel }}
                            <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                        </button>
                        <!-- Absolute placement and high z-index added -->
                        <div id="topCoursesDropdown" class="z-50 hidden absolute right-0 top-full mt-2 bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44">
                            <ul class="p-2 text-sm text-body font-medium" aria-labelledby="topCoursesDropdownButton">
                                @foreach($rangeLabels as $range => $label)
                                    <li><a href="{{ route('analytics', ['students_range' => $studentRange, 'courses_range' => $range]) }}" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">{{ $label }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-700">
                        <thead class="bg-white uppercase text-black border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-5 py-5">#</th>
                                <th scope="col" class="px-5 py-2">Course Name</th>
                                <th scope="col" class="px-5 py-5 text-center">Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topCourses as $index => $course)
                                <tr class="border-b border-gray-200">
                                    <td class="px-5 py-5">{{ $index + 1 }}</td>
                                    <td class="px-5 py-2">{{ $course->course }}</td>
                                    <td class="px-5 py-5 text-center">{{ $course->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
