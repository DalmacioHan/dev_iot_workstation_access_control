@extends('layout.app')

@section('title','Reports')

@section('content')

@php
    $controlHeight = 'h-[52px]';
@endphp

<div class="min-h-[calc(100vh-5rem)] rounded-4xl bg-linear-to-br from-slate-100 via-sky-50 to-cyan-100/80 p-4 sm:p-6 lg:p-8">
{{-- HEADER SECTION --}}
<div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="mb-1 text-xs font-semibold uppercase tracking-[0.24em] text-sky-700/80">Access control</p>
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Reports</h1>
        <p class="mt-1 text-sm text-slate-600">Review workstation access activity and filter the audit trail.</p>
    </div>

    <div class="flex flex-wrap gap-2">
        <a href="{{ route('reports.csv', request()->query()) }}" title="Download detailed CSV report" class="group inline-flex items-center gap-2 rounded-xl border border-white/80 bg-white/55 px-4 py-2.5 text-sm font-medium text-slate-700 shadow-[0_8px_30px_rgb(15_23_42/0.06)] backdrop-blur-md transition duration-200 hover:-translate-y-0.5 hover:border-emerald-300 hover:bg-emerald-50/80 hover:text-emerald-900 hover:shadow-lg hover:shadow-emerald-900/10 focus:outline-none focus:ring-4 focus:ring-emerald-200">
            <svg class="h-4 w-4 text-emerald-600 transition-transform duration-200 group-hover:translate-y-0.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2" />
            </svg>
            Export CSV
        </a>
        <a href="{{ route('reports.pdf', request()->query()) }}" title="Download formal PDF report" class="group inline-flex items-center gap-2 rounded-xl border border-white/80 bg-white/55 px-4 py-2.5 text-sm font-medium text-slate-700 shadow-[0_8px_30px_rgb(15_23_42/0.06)] backdrop-blur-md transition duration-200 hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-50/80 hover:text-blue-900 hover:shadow-lg hover:shadow-blue-900/10 focus:outline-none focus:ring-4 focus:ring-blue-200">
            <svg class="h-4 w-4 text-rose-500 transition-transform duration-200 group-hover:translate-y-0.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5M8 15h8M8 18h6" />
            </svg>
            Export PDF
        </a>
    </div>
</div>

{{-- FILTERS CARD --}}
<form method="GET" action="{{ route('reports') }}" class="mb-7 rounded-2xl border border-white/80 bg-white/55 p-5 shadow-[0_18px_50px_rgb(15_23_42/0.08)] backdrop-blur-xl sm:p-6">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-12">
        <div class="xl:col-span-1">
            <label for="date_from" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Date from</label>
            <input
                type="date"
                id="date_from"
                name="date_from"
                value="{{ request('date_from') }}"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-white/90 bg-white/70 px-4 text-sm text-slate-900 shadow-inner shadow-slate-900/3 backdrop-blur-sm focus:border-sky-500 focus:ring-sky-500"
            />
        </div>

        <div class="xl:col-span-1">
            <label for="date_to" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Date to</label>
            <input
                type="date"
                id="date_to"
                name="date_to"
                value="{{ request('date_to') }}"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-white/90 bg-white/70 px-4 text-sm text-slate-900 shadow-inner shadow-slate-900/3 backdrop-blur-sm focus:border-sky-500 focus:ring-sky-500"
            />
        </div>

        <div class="xl:col-span-1">
            <label for="course" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Course</label>
            <select
                id="course"
                name="course"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-white/90 bg-white/70 px-4 pr-10 text-sm text-slate-900 shadow-inner shadow-slate-900/3 backdrop-blur-sm focus:border-sky-500 focus:ring-sky-500"
            >
                <option value="">All Courses</option>
                @foreach ($courses as $course)
                    <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
                @endforeach
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="workstation" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Workstation</label>
            <select
                id="workstation"
                name="workstation"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-white/90 bg-white/70 px-4 pr-10 text-sm text-slate-900 shadow-inner shadow-slate-900/3 backdrop-blur-sm focus:border-sky-500 focus:ring-sky-500"
            >
                <option value="">All Workstations</option>
                @foreach ($workstations as $workstation)
                    <option value="{{ $workstation }}" {{ request('workstation') == $workstation ? 'selected' : '' }}>{{ $workstation }}</option>
                @endforeach
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="event" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Event</label>
            <select
                id="event"
                name="event"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-white/90 bg-white/70 px-4 pr-10 text-sm text-slate-900 shadow-inner shadow-slate-900/3 backdrop-blur-sm focus:border-sky-500 focus:ring-sky-500"
            >
                <option value="">All Events</option>
                @foreach ($events as $event)
                    <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>{{ $event }}</option>
                @endforeach
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="result" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Result</label>
            <select
                id="result"
                name="result"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-white/90 bg-white/70 px-4 pr-10 text-sm text-slate-900 shadow-inner shadow-slate-900/3 backdrop-blur-sm focus:border-sky-500 focus:ring-sky-500"
            >
                <option value="">All Results</option>
                @foreach ($results as $result)
                    <option value="{{ $result }}" {{ request('result') == $result ? 'selected' : '' }}>{{ $result }}</option>
                @endforeach
            </select>
        </div>

        <div class="xl:col-span-1">
            <label for="reason" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Reason</label>
            <select
                id="reason"
                name="reason"
                class="mt-1 block w-full {{ $controlHeight }} rounded-xl border border-white/90 bg-white/70 px-4 pr-10 text-sm text-slate-900 shadow-inner shadow-slate-900/3 backdrop-blur-sm focus:border-sky-500 focus:ring-sky-500"
            >
                <option value="">All Reasons</option>
                @foreach ($reasons as $reason)
                    <option value="{{ $reason }}" {{ request('reason') == $reason ? 'selected' : '' }}>{{ $reason }}</option>
                @endforeach
            </select>
        </div>

    </div>

    {{-- Action Buttons Wrapper --}}
    <div class="relative z-10 mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
        <button type="submit" class="inline-flex min-h-13 w-full items-center justify-center gap-2 rounded-xl border border-sky-800 bg-sky-700! px-5 text-sm font-semibold text-white! shadow-lg shadow-sky-900/20 transition hover:bg-sky-800! focus:outline-none focus:ring-4 focus:ring-sky-300">
            <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10M10 18h4" />
            </svg>
            Apply Filters
        </button>
        <a href="{{ route('reports') }}" class="inline-flex min-h-13 w-full items-center justify-center gap-2 rounded-xl border border-slate-300/80 bg-white/80 px-5 text-sm font-semibold text-slate-700 shadow-sm backdrop-blur-sm transition hover:bg-white focus:outline-none focus:ring-4 focus:ring-slate-200">
            <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5M20 20v-5h-5M5.5 9A7 7 0 0 1 17 6.5L20 9M18.5 15A7 7 0 0 1 7 17.5L4 15" />
            </svg>
            Reset Filters
        </a>
    </div>
</form>

{{-- DATA TABLE CONTAINER --}}
<div class="overflow-hidden rounded-2xl border border-white/80 bg-white/60 shadow-[0_18px_50px_rgb(15_23_42/0.08)] backdrop-blur-xl">
    <div class="relative overflow-x-auto">
        <table class="w-full whitespace-nowrap text-left text-sm text-slate-700">
            <thead class="bg-slate-900/4 text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">
                <tr class="border-b border-slate-200/80">
                    <th scope="col" class="px-5 py-4">ID</th>
                    <th scope="col" class="px-5 py-4">Date & Time</th>
                    <th scope="col" class="px-5 py-4">Course</th>
                    <th scope="col" class="px-5 py-4">Workstation</th>
                    <th scope="col" class="px-5 py-4">Event</th>
                    <th scope="col" class="px-5 py-4">Result</th>
                    <th scope="col" class="px-5 py-4">Reason</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr class="border-b border-slate-200/70 even:bg-slate-50/45 transition-colors last:border-b-0 hover:bg-sky-100/55">
                        <td class="px-5 py-4 font-semibold text-slate-900">{{ $log->id }}</td>
                        <td class="px-5 py-4">{{ $log->occurred_at }}</td>
                        <td class="px-5 py-4">{{ $log->course }}</td>
                        <td class="px-5 py-4">{{ $log->workstation }}</td>
                        <td class="px-5 py-4">{{ $log->event_type }}</td>
                        <td class="px-5 py-4 font-medium text-slate-900">{{ $log->result }}</td>
                        <td class="px-5 py-4">{{ $log->reason }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-slate-500">No access logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">
    {{ $logs->onEachSide(1)->links('vendor.pagination.flowbite') }}
</div>
</div>
@endsection
