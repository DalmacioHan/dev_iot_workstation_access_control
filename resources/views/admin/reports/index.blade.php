@extends('layout.app')

@section('title','Reports')

@section('content')

@php
    $controlHeight = 'h-[52px]';
@endphp

{{-- HEADER SECTION --}}
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div class="flex flex-wrap gap-2">
        <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
            Export CSV
        </button>
        <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
            Export PDF
        </button>
    </div>
</div>

{{-- FILTERS CARD --}}
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-12">
        <div class="xl:col-span-1">
            <label for="date-from" class="text-xs font-medium text-gray-500">Date from</label>
            <input
                type="date"
                id="date-from"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            />
        </div>

        <div class="xl:col-span-1">
            <label for="date-to" class="text-xs font-medium text-gray-500">Date to</label>
            <input
                type="date"
                id="date-to"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            />
        </div>

        <div class="xl:col-span-1">
            <label for="course" class="text-xs font-medium text-gray-500">Course</label>
            <select
                id="course"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option>All Courses</option>
                </select>
                <!-- data option will get from the database-->
        </div>

        <div class="xl:col-span-1">
            <label for="workstation" class="text-xs font-medium text-gray-500">Workstation</label>
            <select
                id="workstation"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                <option>All Workstations</option>
                </select>
                <!-- data option will get from the database-->
        </div>

        <div class="xl:col-span-1">
            <label for="event" class="text-xs font-medium text-gray-500">Event</label>
            <select
                id="event"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                <option>All Events</option>
                </select>
                <!-- data option will get from the database-->
        </div>

        <div class="xl:col-span-1">
            <label for="result" class="text-xs font-medium text-gray-500">Result</label>
            <select
                id="result"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option>All Results</option>
                <option>Success</option>
                <option>Fail</option>
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="reason" class="text-xs font-medium text-gray-500">Reason</label>
            <select
                id="reason"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600">
                <option>All Reasons</option>
                <option>Authorized</option>
                <option>Not Authorized</option>
            </select>
        </div>

    </div>

    {{-- Action Buttons Wrapper --}}
    <div class="mt-4 grid grid-cols-2 gap-2">
        <button type="button" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl bg-blue-700 px-5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-800">
            Apply
        </button>
        <button type="button" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl border border-gray-200 bg-white px-5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
            Reset
        </button>
    </div>
</div>

{{-- DATA TABLE CONTAINER --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="relative overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700 whitespace-nowrap">
            <thead class="bg-white text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr class="border-b border-gray-200">
                    <th class="px-6 py-4">Date & Time</th>
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Course</th>
                    <th class="px-6 py-4">Workstation</th>
                    <th class="px-6 py-4">Event</th>
                    <th class="px-6 py-4">Result</th>
                    <th class="px-6 py-4">Reason</th>
                    <th class="px-6 py-4">Session ID</th>
                </tr>
            </thead>
            <!-- data rows will be populated from the database -->
        </table>
    </div>
</div>

@endsection
