@extends('layout.app')

@section('title', 'Summary Report')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div
        class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between"
    >

        <div>

            <div class="mb-2 flex items-center gap-2">

                <span
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600"
                >

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M4 19V5M4 19h16M8 16v-4M12 16V8M16 16v-7M20 16V6"
                        />
                    </svg>

                </span>


                <span
                    class="text-xs font-semibold uppercase tracking-wider text-blue-600"
                >
                    Reports
                </span>

            </div>


            <h1
                class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"
            >
                Student Summary Report
            </h1>


            <p
                class="mt-1 max-w-2xl text-sm text-gray-500"
            >
                Generate a summarized report of student access activity
                without displaying every individual access-log record.
            </p>

        </div>


        {{-- =====================================================
            PDF ACTIONS
        ====================================================== --}}
        <div
            class="flex flex-wrap items-center gap-2"
        >

            {{-- Preview PDF --}}
            <a
                href="{{
                    route(
                        'reports.summary.preview',
                        request()->query()
                    )
                }}"
                target="_blank"
                rel="noopener"
                class="inline-flex h-10 items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 text-sm font-semibold text-blue-700 transition hover:border-blue-300 hover:bg-blue-100 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >

                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="2.5"
                    />

                </svg>

                Preview PDF

            </a>


            {{-- Download PDF --}}
            <a
                href="{{
                    route(
                        'reports.summary.pdf',
                        request()->query()
                    )
                }}"
                class="inline-flex h-10 items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700 focus:outline-none focus:ring-4 focus:ring-gray-100"
            >

                <svg
                    class="h-4 w-4 text-rose-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M7 3h7l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M14 3v5h5M8 15h8M8 18h6"
                    />
                </svg>

                Export PDF

            </a>

        </div>

    </div>


    {{-- =========================================================
        FILTERS
    ========================================================== --}}
    <form
        method="GET"
        action="{{ route('reports.summary') }}"
        class="border-y border-gray-200 bg-white py-5"
    >

        <div
            class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4"
        >

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
                    value="{{ request('date_from', $dateFrom) }}"
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
                    value="{{ request('date_to', $dateTo) }}"
                    class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                >

            </div>


            {{-- Course --}}
            <div>

                <label
                    for="course"
                    class="mb-1.5 block text-xs font-semibold text-gray-600"
                >
                    Course
                </label>


                <select
                    id="course"
                    name="course"
                    class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                >

                    <option value="">
                        All Courses
                    </option>


                    @foreach($courses as $course)

                        <option
                            value="{{ $course }}"
                            {{ request('course') == $course ? 'selected' : '' }}
                        >
                            {{ $course }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Workstation --}}
            <div>

                <label
                    for="device"
                    class="mb-1.5 block text-xs font-semibold text-gray-600"
                >
                    Workstation
                </label>


                <select
                    id="device"
                    name="device"
                    class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                >

                    <option value="">
                        All Workstations
                    </option>


                    @foreach($devices as $device)

                        <option
                            value="{{ $device }}"
                            {{ request('device') == $device ? 'selected' : '' }}
                        >
                            {{ $device }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        {{-- Filter Actions --}}
        <div
            class="mt-4 flex flex-col gap-2 sm:flex-row sm:justify-end"
        >

            <a
                href="{{ route('reports.summary') }}"
                class="inline-flex h-10 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
            >
                Reset
            </a>


            <button
                type="submit"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >

                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M3 5h18M6 12h12M10 19h4"
                    />
                </svg>

                Apply Filters

            </button>

        </div>

    </form>


    {{-- =========================================================
        SUMMARY INFORMATION
    ========================================================== --}}
    <div
        class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"
    >

        <div>

            <h2
                class="text-lg font-bold text-gray-900"
            >
                Student Summary
            </h2>


            <p
                class="mt-0.5 text-sm text-gray-500"
            >
                {{ $periodLabel }}
            </p>

        </div>


        <p
            class="text-sm text-gray-500"
        >
            <span
                class="font-semibold text-gray-900"
            >
                {{ number_format($students->total()) }}
            </span>

            summarized students
        </p>

    </div>


    {{-- =========================================================
        STUDENT SUMMARY TABLE
    ========================================================== --}}
    <div
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white"
    >

        <div
            class="relative overflow-x-auto"
        >

            <table
                class="w-full text-left text-sm text-gray-600"
            >

                <thead
                    class="border-b border-gray-200 bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500"
                >

                    <tr>

                        <th class="whitespace-nowrap px-5 py-4">
                            Student
                        </th>

                        <th class="whitespace-nowrap px-5 py-4">
                            Student ID
                        </th>

                        <th class="whitespace-nowrap px-5 py-4">
                            Course
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 text-center">
                            Allowed
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 text-center">
                            Denied
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 text-center">
                            Sessions
                        </th>

                        <th class="whitespace-nowrap px-5 py-4 text-center">
                            Workstations
                        </th>

                        <th class="whitespace-nowrap px-5 py-4">
                            First Access
                        </th>

                        <th class="whitespace-nowrap px-5 py-4">
                            Last Access
                        </th>

                    </tr>

                </thead>


                <tbody
                    class="divide-y divide-gray-100"
                >

                    @forelse($students as $student)

                        <tr
                            class="transition hover:bg-blue-50/30"
                        >

                            {{-- Student --}}
                            <td class="px-5 py-4">

                                <span
                                    class="font-semibold text-gray-900"
                                >
                                    {{ $student->student_name ?: 'Unknown Student' }}
                                </span>

                            </td>


                            {{-- Student ID --}}
                            <td
                                class="whitespace-nowrap px-5 py-4 font-mono text-xs text-gray-600"
                            >
                                {{ $student->student_external_id }}
                            </td>


                            {{-- Course --}}
                            <td class="px-5 py-4">
                                {{ $student->course ?: '—' }}
                            </td>


                            {{-- Allowed --}}
                            <td
                                class="px-5 py-4 text-center font-semibold text-gray-900"
                            >
                                {{ number_format($student->allowed_accesses) }}
                            </td>


                            {{-- Denied --}}
                            <td
                                class="px-5 py-4 text-center font-semibold text-gray-900"
                            >
                                {{ number_format($student->denied_accesses) }}
                            </td>


                            {{-- Sessions --}}
                            <td
                                class="px-5 py-4 text-center"
                            >
                                {{ number_format($student->total_sessions) }}
                            </td>


                            {{-- Workstations --}}
                            <td
                                class="px-5 py-4 text-center"
                            >
                                {{ number_format($student->workstations_used) }}
                            </td>


                            {{-- First Access --}}
                            <td
                                class="whitespace-nowrap px-5 py-4 text-xs"
                            >

                                @if($student->first_access)

                                    {{
                                        \Carbon\Carbon::parse(
                                            $student->first_access
                                        )->format(
                                            'M d, Y h:i A'
                                        )
                                    }}

                                @else

                                    —

                                @endif

                            </td>


                            {{-- Last Access --}}
                            <td
                                class="whitespace-nowrap px-5 py-4 text-xs"
                            >

                                @if($student->last_access)

                                    {{
                                        \Carbon\Carbon::parse(
                                            $student->last_access
                                        )->format(
                                            'M d, Y h:i A'
                                        )
                                    }}

                                @else

                                    —

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="px-6 py-16 text-center"
                            >

                                <p
                                    class="text-sm font-semibold text-gray-800"
                                >
                                    No student summary available
                                </p>


                                <p
                                    class="mt-1 text-sm text-gray-500"
                                >
                                    No student access activity matches the
                                    selected filters.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
        PAGINATION
    ========================================================== --}}
    @if($students->hasPages())

        <div
            class="flex justify-center sm:justify-end"
        >

            {{
                $students
                    ->onEachSide(1)
                    ->links(
                        'vendor.pagination.flowbite'
                    )
            }}

        </div>

    @endif

</div>

@endsection
