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
<form method="GET" action="{{ route('reports') }}" class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-12">
        <div class="xl:col-span-1">
            <label for="date_from" class="text-xs font-medium text-gray-500">Date from</label>
            <input
                type="date"
                id="date_from"
                name="date_from"
                value="{{ request('date_from') }}"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            />
        </div>

        <div class="xl:col-span-1">
            <label for="date_to" class="text-xs font-medium text-gray-500">Date to</label>
            <input
                type="date"
                id="date_to"
                name="date_to"
                value="{{ request('date_to') }}"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            />
        </div>

        <div class="xl:col-span-1">
            <label for="course" class="text-xs font-medium text-gray-500">Course</label>
            <select
                id="course"
                name="course"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option value="">All Courses</option>
                @foreach ($courses as $course)
                    <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
                @endforeach
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="workstation" class="text-xs font-medium text-gray-500">Workstation</label>
            <select
                id="workstation"
                name="workstation"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option value="">All Workstations</option>
                @foreach ($workstations as $workstation)
                    <option value="{{ $workstation }}" {{ request('workstation') == $workstation ? 'selected' : '' }}>{{ $workstation }}</option>
                @endforeach
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="event" class="text-xs font-medium text-gray-500">Event</label>
            <select
                id="event"
                name="event"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option value="">All Events</option>
                @foreach ($events as $event)
                    <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>{{ $event }}</option>
                @endforeach
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="result" class="text-xs font-medium text-gray-500">Result</label>
            <select
                id="result"
                name="result"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option value="">All Results</option>
                @foreach ($results as $result)
                    <option value="{{ $result }}" {{ request('result') == $result ? 'selected' : '' }}>{{ $result }}</option>
                @endforeach
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="reason" class="text-xs font-medium text-gray-500">Reason</label>
            <select
                id="reason"
                name="reason"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option value="">All Reasons</option>
                @foreach ($reasons as $reason)
                    <option value="{{ $reason }}" {{ request('reason') == $reason ? 'selected' : '' }}>{{ $reason }}</option>
                @endforeach
            </select>
        </div>

    </div>

    {{-- Action Buttons Wrapper --}}
    <div class="mt-4 grid grid-cols-2 gap-2">
        <button type="submit" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl bg-blue-700 px-5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-800">
            Apply
        </button>
        <a href="{{ route('reports') }}" class="inline-flex {{ $controlHeight }} items-center justify-center rounded-xl border border-gray-200 bg-white px-5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
            Reset
        </a>
    </div>
</form>

{{-- DATA TABLE CONTAINER --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="relative overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700 whitespace-nowrap">
            <thead class="bg-white text-xs font-semibold uppercase tracking-wide text-gray-500 ">
                <tr class="border-b border-gray-200">
                    <th scope="col" class="px-5 py-5">ID</th>
                    <th scope="col" class="px-5 py-5">Date & Time</th>
                    <th scope="col" class="px-5 py-5">Course</th>
                    <th scope="col" class="px-5 py-5">Workstation</th>
                    <th scope="col" class="px-5 py-5">Event</th>
                    <th scope="col" class="px-5 py-5">Result</th>
                    <th scope="col" class="px-5 py-5">Reason</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr class="border-b border-gray-200 last:border-b-0">
                        <td class="px-5 py-5">{{ $log->id }}</td>
                        <td class="px-5 py-5">{{ $log->occurred_at }}</td>
                        <td class="px-5 py-5">{{ $log->course }}</td>
                        <td class="px-5 py-5">{{ $log->workstation }}</td>
                        <td class="px-5 py-5">{{ $log->event_type }}</td>
                        <td class="px-5 py-5">{{ $log->result }}</td>
                        <td class="px-5 py-5">{{ $log->reason }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-gray-500">No access logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">
    {{ $logs->onEachSide(1)->links('vendor.pagination.flowbite') }}
</div>
@endsection
