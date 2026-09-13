@extends('layout.app')

@section('title', 'Reports')

@section('content')

<div class="min-h-[calc(100vh-5rem)] rounded-3xl bg-gradient-to-br from-slate-50 via-sky-50/50 to-blue-100/40 p-4 sm:p-6 lg:p-8">
    

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Reports Dashboard</h1>
            <p class="mt-1 text-sm text-slate-600">Review workstation access activity, monitor usage patterns, and filter audit trails.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('reports.preview', request()->query()) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-800 shadow-sm transition hover:bg-blue-100">
                <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z" />
                    <circle cx="12" cy="12" r="2.5" />
                </svg>
                Preview PDF
            </a>
            <a href="{{ route('reports.csv', request()->query()) }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-emerald-50 hover:text-emerald-800">
                <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2" />
                </svg>
                Export CSV
            </a>
            <a href="{{ route('reports.pdf', request()->query()) }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-rose-50 hover:text-rose-800">
                <svg class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5M8 15h8M8 18h6" />
                </svg>
                Export PDF
            </a>
        </div>
    </div>


    <form method="GET" action="{{ route('reports') }}" class="mb-6 rounded-2xl border border-slate-200/80 bg-white/80 p-5 shadow-sm backdrop-blur-md sm:p-6">
        <input type="hidden" name="columns_configured" value="1">

        <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-700">1. Filter Data</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-6">
            
            <div>
                <label for="date_from" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Date From</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm focus:bg-white focus:ring-2 focus:ring-sky-500/20" />
            </div>

            <div>
                <label for="date_to" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Date To</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm focus:bg-white focus:ring-2 focus:ring-sky-500/20" />
            </div>



            <div>
                <label for="course" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Course</label>
                <select id="course" name="course" class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm focus:bg-white focus:ring-2 focus:ring-sky-500/20">
                    <option value="">All Courses</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="workstation" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Workstation</label>
                <select id="workstation" name="workstation" class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm focus:bg-white focus:ring-2 focus:ring-sky-500/20">
                    <option value="">All Workstations</option>
                    @foreach ($workstations as $workstation)
                        <option value="{{ $workstation }}" {{ request('workstation') == $workstation ? 'selected' : '' }}>{{ $workstation }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="event" class="block mb-1.5 text-xs font-bold uppercase tracking-wider text-slate-500">Event</label>
                <select id="event" name="event" class="block w-full h-11 rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 text-sm text-slate-900 shadow-sm focus:bg-white focus:ring-2 focus:ring-sky-500/20">
                    <option value="">All Events</option>
                    @foreach ($events as $event)
                        <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>{{ $event }}</option>
                    @endforeach
                </select>
            </div>

        </div>


        <div class="pt-5 border-t border-slate-100">
            <h2 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-700">2. Columns to Display / Print</h2>
            <div class="flex flex-wrap gap-4 rounded-xl border border-slate-200/80 bg-slate-50/80 p-4">
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="cols[student_name]" value="1" {{ $columns['student_name'] ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    Student Name
                </label>
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="cols[course]" value="1" {{ $columns['course'] ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    Course
                </label>
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="cols[workstation]" value="1" {{ $columns['workstation'] ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    Workstation
                </label>
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="cols[date_time]" value="1" {{ $columns['date_time'] ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    Date and Time
                </label>
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="cols[event]" value="1" {{ $columns['event'] ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    Event
                </label>
            </div>
        </div>


        <div class="mt-6 flex flex-col sm:flex-row items-center gap-3 pt-4 border-t border-slate-100">
                <div class="grid grid-cols-1  sm:grid-cols-1">
                    <button type="submit" class="inline-flex w-full h-13 items-center justify-center rounded-xl bg-blue-800 px-6 text-base font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-200">Save Filters</button>
                </div>
            <a href="{{ route('reports') }}" class="inline-flex h-13 w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-slate-900 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5M20 20v-5h-5M5.5 9A7 7 0 0 1 17 6.5L20 9M18.5 15A7 7 0 0 1 7 17.5L4 15" />
                </svg>
                Reset All
            </a>
        </div>
    </form>

    {{-- DATA TABLE CONTAINER --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        <div class="relative overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        @if ($columns['student_name'])
                            <th scope="col" class="px-6 py-4">Name</th>
                        @endif
                        @if ($columns['course'])
                            <th scope="col" class="px-6 py-4">Course</th>
                        @endif
                        @if ($columns['workstation'])
                            <th scope="col" class="px-6 py-4">Workstation</th>
                        @endif
                        @if ($columns['date_time'])
                            <th scope="col" class="px-6 py-4">Date and Time</th>
                        @endif
                        @if ($columns['event'])
                            <th scope="col" class="px-6 py-4">Event</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($logs as $log)
                        <tr class="transition-colors hover:bg-sky-50/50">
                            @if ($columns['student_name'])
                                <td class="px-6 py-4 font-mono font-semibold text-slate-900">{{ $log->student_name }}</td>
                            @endif
                            @if ($columns['course'])
                                <td class="px-6 py-4 text-slate-600">{{ $log->course }}</td>
                            @endif
                            @if ($columns['workstation'])
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $log->workstation}}</td>
                            @endif
                            @if ($columns['date_time'])
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                        {{ $log->occurred_at}}
                                    </span>
                                </td>
                            @endif
                            @if ($columns['event'])
                                <td class="px-6 py-4 text-slate-600">{{ $log->event_type }}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm font-medium text-slate-600">No access logs found matching your filters.</p>
                                </div>
                            </td>
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