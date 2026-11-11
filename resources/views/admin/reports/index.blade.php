@extends('layout.app')

@section('title', 'Reports')

@section('content')

@php
    $stepLabels = [
        1 => 'Report',
        2 => 'Period',
        3 => 'Filters',
        4 => 'Review',
    ];

    $baseQuery = request()->except(['step', 'page']);

    $stepUrl = fn (int $target): string => route(
        'reports.index',
        array_merge($baseQuery, ['step' => $target])
    );

    $periodLabel = $isAllTime
        ? 'All time'
        : \Carbon\Carbon::parse($dateFrom)->format('M d, Y')
            . ' – ' .
            \Carbon\Carbon::parse($dateTo)->format('M d, Y');

    $courseLabel = request('course') ?: 'All courses';
    $computerLabel = request('device') ?: 'All computers';

    $pdfQuery = array_filter([
        'period' => $isAllTime ? 'all' : $period,
        'date_from' => $isAllTime ? null : $dateFrom,
        'date_to' => $isAllTime ? null : $dateTo,
        'course' => request('course'),
        'device' => request('device'),
        'search' => $tab === 'access' ? request('search') : null,
        'event' => $tab === 'access' ? request('event') : null,
        'result' => $tab === 'access' ? request('result') : null,
        'reason' => $tab === 'access' ? request('reason') : null,
    ], fn ($value) => $value !== null && $value !== '');
@endphp

<div class="mx-auto max-w-6xl space-y-6">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div>

        <div class="mb-2 flex items-center gap-2">

            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">

                <x-icon name="file" class="h-4 w-4" />

            </span>


            <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">
                Insights
            </span>

        </div>


        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
            Reports
        </h1>


        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
            Answer a few questions and we’ll prepare the report.
            Preview it before exporting.
        </p>

    </div>


    {{-- =========================================================
        WIZARD
    ========================================================== --}}
    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

        @include('admin.reports.partials.stepper', ['stepLabels' => $stepLabels])

        <div class="p-5 sm:p-7">

            @if ($step === 1)
                @include('admin.reports.partials.step-report')
            @elseif ($step === 2)
                @include('admin.reports.partials.step-period')
            @elseif ($step === 3)
                @include('admin.reports.partials.step-filters')
            @else
                @include('admin.reports.partials.step-review')
            @endif

        </div>

    </div>

</div>


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const periodRadios = document.querySelectorAll('input[name="period"]');
    const customDates = document.getElementById('custom-dates');

    if (periodRadios.length && customDates) {

        function toggleCustomDates() {
            const selected = document.querySelector('input[name="period"]:checked');

            customDates.classList.toggle(
                'hidden',
                !selected || selected.value !== 'custom'
            );
        }

        periodRadios.forEach(function (radio) {
            radio.addEventListener('change', toggleCustomDates);
        });

        toggleCustomDates();
    }

});
</script>

@endpush

@endsection
