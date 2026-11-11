@php
    $count = $tab === 'access'
        ? $logs->total()
        : $students->total();

    $countLabel = $tab === 'access'
        ? ($count === 1 ? 'record' : 'records')
        : ($count === 1 ? 'student' : 'students');

    $previewPage = $tab === 'access' ? $logs : $students;

    $editUrl = fn (int $target): string => route(
        'reports.index',
        array_merge(request()->except(['step', 'page']), ['step' => $target])
    );

    $allTimeQuery = request()->except([
        'step',
        'page',
        'period',
        'date_from',
        'date_to',
        'range',
        'course',
        'device',
        'search',
        'event',
        'result',
        'reason',
        'cols',
        'columns_configured',
    ]);

    $allTimeUrl = route(
        'reports.index',
        array_merge($allTimeQuery, ['step' => 4, 'period' => 'all'])
    );
@endphp

<div class="space-y-6">

    <div>

        <p class="text-xs font-bold uppercase tracking-wider text-blue-600">
            Step 4
        </p>

        <h2 class="mt-1 text-xl font-bold text-gray-900 sm:text-2xl">
            Review your report
        </h2>

        <p class="mt-1 text-sm leading-6 text-gray-500">
            Check the details below, then preview or download the PDF.
        </p>

    </div>


    {{-- Summary --}}
    <div class="rounded-2xl border border-blue-100 bg-blue-50/50 p-5">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

            <div class="min-w-0 space-y-4">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                        Report
                    </p>

                    <p class="mt-0.5 text-base font-bold text-gray-900">
                        {{ $reportTitle }}
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-3">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                            Period
                        </p>

                        <p class="mt-0.5 font-semibold text-gray-800">
                            {{ $periodLabel }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                            Course
                        </p>

                        <p class="mt-0.5 font-semibold text-gray-800">
                            {{ $courseLabel }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                            Computer
                        </p>

                        <p class="mt-0.5 font-semibold text-gray-800">
                            {{ $computerLabel }}
                        </p>

                    </div>

                </div>


                <div class="flex flex-wrap items-center gap-2">

                    <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200">

                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>

                        {{ number_format($count) }} {{ $countLabel }}

                    </span>

                    @if ($tab === 'students')
                        <span class="text-xs text-gray-400">
                            Counts check-ins only, not check-outs.
                        </span>
                    @endif

                </div>

            </div>


            @if ($count > 0)

                <div class="flex flex-col gap-2 sm:flex-row lg:flex-col">

                    <a
                        href="{{ $tab === 'access'
                            ? route('reports.accesslog.preview', $pdfQuery)
                            : route('reports.summary.preview', $pdfQuery) }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-5 text-sm font-semibold text-blue-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12 18.25 18.75 12 18.75 2.25 12 2.25 12Z" />
                            <circle cx="12" cy="12" r="2.5" />
                        </svg>
                        Preview PDF
                    </a>

                    <a
                        href="{{ $tab === 'access'
                            ? route('reports.accesslog.pdf', $pdfQuery)
                            : route('reports.summary.pdf', $pdfQuery) }}"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v5h5M8 15h8M8 18h6" />
                        </svg>
                        Download PDF
                    </a>

                </div>

            @endif

        </div>


        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-blue-100 pt-4 text-xs">

            <span class="font-semibold text-gray-400">
                Change:
            </span>

            <a href="{{ $editUrl(1) }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Report type
            </a>

            <a href="{{ $editUrl(2) }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Period
            </a>

            <a href="{{ $editUrl(3) }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Filters
            </a>

        </div>

    </div>


    @if ($count === 0)

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">

            <div class="flex items-start gap-3">

                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v5m0 3.5v.5M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                    </svg>

                </span>

                <div>

                    <h3 class="text-sm font-bold text-amber-900">
                        No records match this report
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-amber-800">
                        Try a wider period, or remove the course and computer filters.
                    </p>

                    <div class="mt-3 flex flex-wrap gap-2">

                        <a
                            href="{{ $editUrl(2) }}"
                            class="inline-flex h-10 items-center justify-center rounded-xl bg-amber-600 px-4 text-sm font-semibold text-white transition hover:bg-amber-700"
                        >
                            Change period
                        </a>

                        <a
                            href="{{ $allTimeUrl }}"
                            class="inline-flex h-10 items-center justify-center rounded-xl border border-amber-300 bg-white px-4 text-sm font-semibold text-amber-800 transition hover:bg-amber-100"
                        >
                            Show all time
                        </a>

                    </div>

                </div>

            </div>

        </div>

    @else

        <div>

            <div class="flex flex-col gap-2 border-t border-gray-100 pt-5 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <h3 class="text-lg font-bold text-gray-900">
                        Preview records
                    </h3>

                    <p class="mt-0.5 text-sm text-gray-500">
                        Showing {{ $previewPage->firstItem() ?? 0 }}–{{ $previewPage->lastItem() ?? 0 }}
                        of {{ number_format($previewPage->total()) }}
                    </p>

                </div>

                <p class="text-xs text-gray-400">
                    This is the same data that will appear in the PDF.
                </p>

            </div>


            <div class="mt-4">

                @if ($tab === 'access')
                    @include('admin.reports.partials.access-log')
                @else
                    @include('admin.reports.partials.student-summary')
                @endif

            </div>

        </div>

    @endif


    <div class="flex justify-center border-t border-gray-100 pt-5">

        <a
            href="{{ route('reports.index') }}"
            class="text-xs font-semibold text-gray-400 transition hover:text-gray-700"
        >
            Start over
        </a>

    </div>

</div>
