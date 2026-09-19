@extends('layout.app')

@section('title', 'Analytics')

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
                Review access patterns across students, courses, applications, and workstations.
            </p>
        </div>
    </div>

    {{-- Summary Metrics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-500">Top Application</p>
                    <p class="mt-2 truncate text-xl font-bold text-slate-900" title="{{ $topApplication->first()->app_name ?? 'N/A' }}">
                        {{ $topApplication->first()->app_name ?? 'N/A' }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400">Most used today</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M7 16v-4m4 4V8m4 8v-7m4 7V5" />
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
                    <p class="mt-1 text-xs text-slate-400">Highest access today</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6l1 3h3a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h3l1-3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M8 16h5" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Successful Access</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($successfulEvents) }}</p>
                    <p class="mt-1 text-xs text-slate-400">Successful events today</p>
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
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($failedEvents) }}</p>
                    <p class="mt-1 text-xs text-slate-400">Failed events today</p>
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 4h.01M10.3 3.9l-7.1 12.3A1.5 1.5 0 004.5 18.5h15a1.5 1.5 0 001.3-2.3L13.7 3.9a1.9 1.9 0 00-3.4 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Ranked Activity --}}
    <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Students</h2>
                    <p class="mt-1 text-sm text-slate-500">Students with the most access events.</p>
                </div>

                <div class="relative self-start sm:self-auto">
                    <button id="topStudentsDropdownButton" data-dropdown-toggle="topStudentsDropdown" data-dropdown-placement="bottom-end" type="button" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        {{ $studentRangeLabel }}
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6" /></svg>
                    </button>
                    <div id="topStudentsDropdown" class="absolute right-0 z-20 mt-2 hidden w-44 overflow-hidden rounded-xl border border-slate-200 bg-white p-1 shadow-lg">
                        @foreach($rangeLabels as $range => $label)
                            <a href="{{ route('analytics', ['students_range' => $range, 'courses_range' => $courseRange]) }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-700">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[420px] text-left text-sm text-slate-600">
                    <thead class="border-b border-slate-100 bg-slate-50/70 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">#</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Student Name</th>
                            <th scope="col" class="px-6 py-4 text-center font-semibold">Access</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($topStudents as $index => $student)
                            <tr class="transition-colors hover:bg-blue-50/30">
                                <td class="px-6 py-4 font-semibold text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $student->student_name }}</td>
                                <td class="px-6 py-4 text-center font-semibold text-blue-700">{{ number_format($student->total) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-12 text-center text-sm text-slate-400">No student activity found for this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Top 10 Courses</h2>
                    <p class="mt-1 text-sm text-slate-500">Courses with the most access events.</p>
                </div>

                <div class="relative self-start sm:self-auto">
                    <button id="topCoursesDropdownButton" data-dropdown-toggle="topCoursesDropdown" data-dropdown-placement="bottom-end" type="button" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        {{ $courseRangeLabel }}
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 9 6 6 6-6" /></svg>
                    </button>
                    <div id="topCoursesDropdown" class="absolute right-0 z-20 mt-2 hidden w-44 overflow-hidden rounded-xl border border-slate-200 bg-white p-1 shadow-lg">
                        @foreach($rangeLabels as $range => $label)
                            <a href="{{ route('analytics', ['students_range' => $studentRange, 'courses_range' => $range]) }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-700">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[420px] text-left text-sm text-slate-600">
                    <thead class="border-b border-slate-100 bg-slate-50/70 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">#</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Course Name</th>
                            <th scope="col" class="px-6 py-4 text-center font-semibold">Access</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($topCourses as $index => $course)
                            <tr class="transition-colors hover:bg-blue-50/30">
                                <td class="px-6 py-4 font-semibold text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $course->course }}</td>
                                <td class="px-6 py-4 text-center font-semibold text-blue-700">{{ number_format($course->total) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-12 text-center text-sm text-slate-400">No course activity found for this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
