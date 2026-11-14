{{-- =========================================================
    STUDENT SUMMARY ANALYTICS & HIGHLIGHTS
========================================================== --}}
<div class="mb-8 space-y-6">

    {{-- Section Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-100 pb-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <x-icon name="chart-pie" class="h-4 w-4" />
                </span>
                <h3 class="text-base font-bold text-gray-900">
                    Report Analytics & Highlights
                </h3>
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Overall course distribution and top performers based on the selected report filters.
            </p>
        </div>

        @if (($totalCourseStudents ?? 0) > 0)
            <div class="inline-flex items-center gap-2 self-start rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                <span>{{ number_format($totalCourseStudents) }} Total Students Recorded</span>
            </div>
        @endif
    </div>

    {{-- Analytics Grid: Left = Pie Chart, Right = Top 4 Ranking Cards --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        {{-- =========================================================
            CARD 1: OVERALL COURSE DISTRIBUTION (PIE GRAPH)
        ========================================================== --}}
        <div class="flex flex-col rounded-3xl border border-gray-200 bg-white p-5 shadow-sm lg:col-span-5">

            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <x-icon name="chart-pie" class="h-4 w-4" />
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">
                            Course Distribution
                        </h4>
                        <p class="text-[11px] text-gray-400">
                            Student share by academic program
                        </p>
                    </div>
                </div>

                <span class="rounded-lg bg-gray-50 px-2 py-1 text-[11px] font-semibold text-gray-600">
                    {{ count($chartCourseLabels ?? []) }} {{ count($chartCourseLabels ?? []) === 1 ? 'course' : 'courses' }}
                </span>
            </div>

            {{-- Pie Chart Container --}}
            <div class="relative my-auto flex min-h-[260px] items-center justify-center pt-2">
                <div id="student-summary-pie-chart" class="w-full"></div>
            </div>

            {{-- Course Breakdown Legend List --}}
            @if (!empty($chartCourseLabels) && count($chartCourseLabels) > 0)
                <div class="mt-4 space-y-2 border-t border-gray-100 pt-4">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">
                        Program Breakdown
                    </p>
                    <div class="max-h-48 space-y-1.5 overflow-y-auto pr-1 text-xs">
                        @foreach ($chartCourseLabels as $idx => $label)
                            @php
                                $color = $chartCourseColors[$idx % count($chartCourseColors)] ?? '#3B82F6';
                                $count = $chartCourseCounts[$idx] ?? 0;
                                $pct = $chartCoursePercentages[$idx] ?? 0;
                            @endphp
                            <div class="flex items-center justify-between rounded-xl px-2 py-1.5 transition hover:bg-gray-50">
                                <div class="flex min-w-0 items-center gap-2">
                                    <span class="h-2.5 w-2.5 shrink-0 rounded-full" style="background-color: {{ $color }};"></span>
                                    <span class="truncate font-medium text-gray-700" title="{{ $label }}">
                                        {{ $label }}
                                    </span>
                                </div>
                                <div class="ml-2 flex shrink-0 items-center gap-2 font-mono text-[11px]">
                                    <span class="font-bold text-gray-900">{{ number_format($count) }}</span>
                                    <span class="text-gray-400">({{ $pct }}%)</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>


        {{-- =========================================================
            LEADERBOARDS: TOP 3 STUDENTS & TOP 3 COURSES
        ========================================================== --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-7">

            {{-- CARD 2: TOP 3 STUDENTS BY LOGINS --}}
            <div class="flex flex-col rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-2.5 border-b border-gray-100 pb-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <x-icon name="users" class="h-4 w-4" />
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">
                            Top 3 Students
                        </h4>
                        <p class="text-[11px] font-medium text-amber-600">
                            By Logins (Check-ins)
                        </p>
                    </div>
                </div>

                <div class="mt-4 flex-1 space-y-3">
                    @forelse ($topStudentsByLogins ?? [] as $index => $student)
                        @php
                            $rankBadge = match ($index) {
                                0 => 'bg-amber-100 text-amber-800 ring-amber-300',
                                1 => 'bg-slate-100 text-slate-700 ring-slate-300',
                                2 => 'bg-orange-100 text-orange-800 ring-orange-300',
                                default => 'bg-gray-100 text-gray-600 ring-gray-200',
                            };
                        @endphp
                        <div class="flex items-start justify-between gap-3 rounded-2xl border border-gray-100 bg-gray-50/50 p-3 transition hover:bg-gray-50">
                            <div class="flex min-w-0 items-start gap-2.5">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-xs font-black ring-1 {{ $rankBadge }}">
                                    #{{ $index + 1 }}
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-bold text-gray-900" title="{{ $student->student_name }}">
                                        {{ $student->student_name ?: 'Unknown Student' }}
                                    </p>
                                    <p class="font-mono text-[10px] text-gray-500">
                                        {{ $student->student_external_id }}
                                    </p>
                                    <p class="truncate text-[10px] text-gray-400" title="{{ $student->course }}">
                                        {{ $student->course ?: 'No course recorded' }}
                                    </p>
                                </div>
                            </div>
                            <span class="inline-flex shrink-0 items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 ring-1 ring-inset ring-amber-200">
                                {{ number_format($student->login_count) }} {{ $student->login_count === 1 ? 'login' : 'logins' }}
                            </span>
                        </div>
                    @empty
                        <div class="flex h-36 flex-col items-center justify-center text-center text-xs text-gray-400">
                            <p>No student check-in data found.</p>
                        </div>
                    @endforelse
                </div>
            </div>


            {{-- CARD 3: TOP 3 STUDENTS BY ACCUMULATED USAGE TIME --}}
            <div class="flex flex-col rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-2.5 border-b border-gray-100 pb-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <x-icon name="clock" class="h-4 w-4" />
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">
                            Top 3 Students
                        </h4>
                        <p class="text-[11px] font-medium text-emerald-600">
                            By Usage Time
                        </p>
                    </div>
                </div>

                <div class="mt-4 flex-1 space-y-3">
                    @forelse ($topStudentsByTime ?? [] as $index => $student)
                        @php
                            $rankBadge = match ($index) {
                                0 => 'bg-emerald-100 text-emerald-800 ring-emerald-300',
                                1 => 'bg-slate-100 text-slate-700 ring-slate-300',
                                2 => 'bg-orange-100 text-orange-800 ring-orange-300',
                                default => 'bg-gray-100 text-gray-600 ring-gray-200',
                            };
                        @endphp
                        <div class="flex items-start justify-between gap-3 rounded-2xl border border-gray-100 bg-gray-50/50 p-3 transition hover:bg-gray-50">
                            <div class="flex min-w-0 items-start gap-2.5">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-xs font-black ring-1 {{ $rankBadge }}">
                                    #{{ $index + 1 }}
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-bold text-gray-900" title="{{ $student->student_name }}">
                                        {{ $student->student_name ?: 'Unknown Student' }}
                                    </p>
                                    <p class="font-mono text-[10px] text-gray-500">
                                        {{ $student->student_external_id }}
                                    </p>
                                    <p class="truncate text-[10px] text-gray-400" title="{{ $student->course }}">
                                        {{ $student->course ?: 'No course recorded' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex shrink-0 flex-col items-end gap-0.5">
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                    {{ $student->formatted_time }}
                                </span>
                                <span class="text-[10px] text-gray-400">
                                    {{ number_format($student->session_count) }} {{ $student->session_count === 1 ? 'session' : 'sessions' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="flex h-36 flex-col items-center justify-center text-center text-xs text-gray-400">
                            <p>No completed session durations found.</p>
                        </div>
                    @endforelse
                </div>
            </div>


            {{-- CARD 4: TOP 3 COURSES BY LOGINS --}}
            <div class="flex flex-col rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-2.5 border-b border-gray-100 pb-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <x-icon name="verified-check" class="h-4 w-4" />
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">
                            Top 3 Courses
                        </h4>
                        <p class="text-[11px] font-medium text-blue-600">
                            By Logins (Check-ins)
                        </p>
                    </div>
                </div>

                <div class="mt-4 flex-1 space-y-3">
                    @forelse ($topCoursesByLogins ?? [] as $index => $course)
                        @php
                            $rankBadge = match ($index) {
                                0 => 'bg-blue-100 text-blue-800 ring-blue-300',
                                1 => 'bg-slate-100 text-slate-700 ring-slate-300',
                                2 => 'bg-orange-100 text-orange-800 ring-orange-300',
                                default => 'bg-gray-100 text-gray-600 ring-gray-200',
                            };
                        @endphp
                        <div class="flex items-start justify-between gap-3 rounded-2xl border border-gray-100 bg-gray-50/50 p-3 transition hover:bg-gray-50">
                            <div class="flex min-w-0 items-start gap-2.5">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-xs font-black ring-1 {{ $rankBadge }}">
                                    #{{ $index + 1 }}
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-bold text-gray-900" title="{{ $course->course }}">
                                        {{ $course->course }}
                                    </p>
                                    <p class="text-[10px] text-gray-400">
                                        {{ number_format($course->student_count) }} {{ $course->student_count === 1 ? 'student' : 'students' }}
                                    </p>
                                </div>
                            </div>
                            <span class="inline-flex shrink-0 items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-200">
                                {{ number_format($course->login_count) }} {{ $course->login_count === 1 ? 'login' : 'logins' }}
                            </span>
                        </div>
                    @empty
                        <div class="flex h-36 flex-col items-center justify-center text-center text-xs text-gray-400">
                            <p>No course login activity found.</p>
                        </div>
                    @endforelse
                </div>
            </div>


            {{-- CARD 5: TOP 3 COURSES BY ACCUMULATED USAGE TIME --}}
            <div class="flex flex-col rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-2.5 border-b border-gray-100 pb-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                        <x-icon name="clock" class="h-4 w-4" />
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">
                            Top 3 Courses
                        </h4>
                        <p class="text-[11px] font-medium text-purple-600">
                            By Usage Time
                        </p>
                    </div>
                </div>

                <div class="mt-4 flex-1 space-y-3">
                    @forelse ($topCoursesByTime ?? [] as $index => $course)
                        @php
                            $rankBadge = match ($index) {
                                0 => 'bg-purple-100 text-purple-800 ring-purple-300',
                                1 => 'bg-slate-100 text-slate-700 ring-slate-300',
                                2 => 'bg-orange-100 text-orange-800 ring-orange-300',
                                default => 'bg-gray-100 text-gray-600 ring-gray-200',
                            };
                        @endphp
                        <div class="flex items-start justify-between gap-3 rounded-2xl border border-gray-100 bg-gray-50/50 p-3 transition hover:bg-gray-50">
                            <div class="flex min-w-0 items-start gap-2.5">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-xs font-black ring-1 {{ $rankBadge }}">
                                    #{{ $index + 1 }}
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-bold text-gray-900" title="{{ $course->course }}">
                                        {{ $course->course }}
                                    </p>
                                    <p class="text-[10px] text-gray-400">
                                        {{ number_format($course->session_count) }} {{ $course->session_count === 1 ? 'session' : 'sessions' }}
                                    </p>
                                </div>
                            </div>
                            <span class="inline-flex shrink-0 items-center rounded-full bg-purple-50 px-2.5 py-1 text-xs font-bold text-purple-700 ring-1 ring-inset ring-purple-200">
                                {{ $course->formatted_time }}
                            </span>
                        </div>
                    @empty
                        <div class="flex h-36 flex-col items-center justify-center text-center text-xs text-gray-400">
                            <p>No course usage duration data found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    DATA TABLE HEADER & TABLE
========================================================== --}}
<div class="mb-3 flex items-center justify-between">
    <div class="flex items-center gap-2">
        <span class="flex h-6 w-6 items-center justify-center rounded-md bg-gray-100 text-gray-600">
            <x-icon name="dash-menu" class="h-3.5 w-3.5" />
        </span>
        <h3 class="text-sm font-bold text-gray-900">
            Student Summary Details
        </h3>
    </div>
    <span class="text-xs text-gray-400">
        Showing all student check-in summaries
    </span>
</div>

<div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

    <div class="relative overflow-x-auto">

        <table class="w-full text-left text-sm text-gray-600">

            <thead class="border-b border-gray-200 bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">

                <tr>

                    <th class="whitespace-nowrap px-5 py-4">Student</th>
                    <th class="whitespace-nowrap px-5 py-4">Student ID</th>
                    <th class="whitespace-nowrap px-5 py-4">Course</th>
                    <th class="whitespace-nowrap px-5 py-4 text-center">Logins</th>
                    <th class="whitespace-nowrap px-5 py-4 text-center">Sessions</th>
                    <th class="whitespace-nowrap px-5 py-4 text-center">Computers</th>
                    <th class="whitespace-nowrap px-5 py-4">First Access</th>
                    <th class="whitespace-nowrap px-5 py-4">Last Access</th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @forelse ($students as $student)

                    <tr class="transition hover:bg-blue-50/30">

                        <td class="px-5 py-4">
                            <span class="font-semibold text-gray-900">
                                {{ $student->student_name ?: 'Unknown Student' }}
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 font-mono text-xs text-gray-600">
                            {{ $student->student_external_id }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $student->course ?: '—' }}
                        </td>

                        <td class="px-5 py-4 text-center font-semibold text-gray-900">
                            {{ number_format($student->allowed_accesses) }}
                        </td>


                        <td class="px-5 py-4 text-center">
                            {{ number_format($student->total_sessions) }}
                        </td>

                        <td class="px-5 py-4 text-center">
                            {{ number_format($student->workstations_used) }}
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 text-xs">
                            @if ($student->first_access)
                                {{ \Carbon\Carbon::parse($student->first_access)->format('M d, Y h:i A') }}
                            @else
                                —
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-5 py-4 text-xs">
                            @if ($student->last_access)
                                {{ \Carbon\Carbon::parse($student->last_access)->format('M d, Y h:i A') }}
                            @else
                                —
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9" class="px-6 py-16 text-center">

                            <div class="mx-auto flex max-w-sm flex-col items-center">

                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">

                                    <x-icon name="chart-vertical" class="h-7 w-7" />

                                </div>

                                <h3 class="mt-4 text-sm font-bold text-gray-800">
                                    No student activity found
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    No check-ins match these filters. Try a wider date range or reset the filters.
                                </p>

                                <a
                                    href="{{ route('reports.index', ['tab' => 'students', 'step' => 3]) }}"
                                    class="mt-4 inline-flex items-center rounded-xl bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600 transition hover:bg-blue-100"
                                >
                                    Reset filters
                                </a>

                            </div>

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
@if ($students->hasPages())

    <div class="mt-4 flex justify-center sm:justify-end">

        {{ $students->onEachSide(1)->links('vendor.pagination.flowbite') }}

    </div>

@endif


{{-- =========================================================
    APEXCHARTS SCRIPT FOR COURSE DISTRIBUTION PIE GRAPH
========================================================== --}}
@push('scripts')
@vite('resources/js/charts.js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pieEl = document.querySelector('#student-summary-pie-chart');
    if (!pieEl) return;

    const courseLabels = @json($chartCourseLabels ?? []);
    const courseCounts = @json($chartCourseCounts ?? []);
    const courseColors = @json($chartCourseColors);

    const totalStudents = courseCounts.reduce(function (sum, val) {
        return sum + Number(val || 0);
    }, 0);

    if (!courseLabels.length || !courseCounts.length || totalStudents === 0) {
        pieEl.innerHTML = `
            <div class="flex min-h-[220px] flex-col items-center justify-center text-center p-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-400">
                    <x-icon name="chart-pie" class="h-6 w-6" />
                </div>
                <h5 class="mt-2 text-xs font-bold text-gray-800">No course data recorded</h5>
                <p class="mt-0.5 text-[11px] text-gray-400">No student activity was found for the selected report filters.</p>
            </div>
        `;
        return;
    }

    const options = {
        series: courseCounts,
        labels: courseLabels,
        chart: {
            type: 'donut',
            height: 270,
            fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif'
        },
        colors: courseColors,
        stroke: {
            width: 2,
            colors: ['#ffffff']
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '76%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '11px',
                            fontWeight: 600,
                            color: '#64748B'
                        },
                        value: {
                            show: true,
                            fontSize: '22px',
                            fontWeight: 700,
                            color: '#0F172A',
                            formatter: function (val) {
                                return Number(val).toLocaleString();
                            }
                        },
                        total: {
                            show: true,
                            label: 'Students',
                            fontSize: '11px',
                            fontWeight: 600,
                            color: '#64748B',
                            formatter: function () {
                                return totalStudents.toLocaleString();
                            }
                        }
                    }
                }
            }
        },
        tooltip: {
            theme: 'light',
            y: {
                formatter: function (val) {
                    const pct = totalStudents > 0 ? ((val / totalStudents) * 100).toFixed(1) : 0;
                    return Number(val).toLocaleString() + ' students (' + pct + '%)';
                }
            }
        }
    };

    const chart = new ApexCharts(pieEl, options);
    chart.render();
});
</script>
@endpush
