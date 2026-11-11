@php
    $periodOptions = [
        [
            'value' => 'today',
            'label' => 'Today',
            'hint' => now()->format('M d, Y'),
        ],
        [
            'value' => 'week',
            'label' => 'Last 7 days',
            'hint' => now()->subDays(6)->format('M d') . ' – ' . now()->format('M d, Y'),
        ],
        [
            'value' => 'month',
            'label' => 'This month',
            'hint' => now()->startOfMonth()->format('M d') . ' – ' . now()->format('M d, Y'),
        ],
        [
            'value' => 'all',
            'label' => 'All time',
            'hint' => 'Everything on record',
        ],
        [
            'value' => 'custom',
            'label' => 'Custom dates',
            'hint' => 'Pick your own start and end',
        ],
    ];
@endphp

<form method="GET" action="{{ route('reports.index') }}" class="space-y-6" id="period-form">

    <input type="hidden" name="step" value="3">

    @include('admin.reports.partials.hidden-state', [
        'except' => ['period', 'date_from', 'date_to', 'range'],
    ])


    <div>

        <p class="text-xs font-bold uppercase tracking-wider text-blue-600">
            Step 2
        </p>

        <h2 class="mt-1 text-xl font-bold text-gray-900 sm:text-2xl">
            When should the report cover?
        </h2>

        <p class="mt-1 text-sm leading-6 text-gray-500">
            Pick the period you need. “This month” is selected by default.
        </p>

    </div>


    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">

        @foreach ($periodOptions as $option)

            <label class="relative block cursor-pointer">

                <input
                    type="radio"
                    name="period"
                    value="{{ $option['value'] }}"
                    class="peer sr-only"
                    @checked($period === $option['value'])
                >

                <span
                    class="pointer-events-none absolute right-3 top-1/2 z-10 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full border-2 border-gray-300 bg-white transition peer-checked:border-blue-600 peer-checked:bg-blue-600"
                >
                    <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m5 13 4 4L19 7" />
                    </svg>
                </span>

                <span
                    class="flex h-full flex-col justify-center rounded-2xl border-2 border-gray-200 bg-white py-3.5 pl-4 pr-12 transition
                    hover:border-blue-200 hover:bg-blue-50/30
                    peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:ring-4 peer-checked:ring-blue-100 peer-checked:shadow-md peer-checked:shadow-blue-100/60"
                >

                    <span class="text-sm font-bold text-gray-900">
                        {{ $option['label'] }}
                    </span>

                    <span class="mt-0.5 text-xs text-gray-500">
                        {{ $option['hint'] }}
                    </span>

                </span>

            </label>

        @endforeach

    </div>


    {{-- Custom dates --}}
    <div
        id="custom-dates"
        class="{{ $period === 'custom' ? '' : 'hidden' }} rounded-2xl border border-gray-200 bg-gray-50/70 p-4"
    >

        <p class="text-sm font-semibold text-gray-700">
            Choose your dates
        </p>

        <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div>

                <label for="date_from" class="mb-1.5 block text-xs font-semibold text-gray-600">
                    Date from
                </label>

                <input
                    type="date"
                    id="date_from"
                    name="date_from"
                    value="{{ $dateFrom ?? '' }}"
                    class="block h-11 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                >

            </div>


            <div>

                <label for="date_to" class="mb-1.5 block text-xs font-semibold text-gray-600">
                    Date to
                </label>

                <input
                    type="date"
                    id="date_to"
                    name="date_to"
                    value="{{ $dateTo ?? '' }}"
                    class="block h-11 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                >

            </div>

        </div>

    </div>


    <div class="flex flex-col-reverse gap-2 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">

        <a
            href="{{ $stepUrl(1) }}"
            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m5 5-5-5 5-5" />
            </svg>
            Back
        </a>


        <button
            type="submit"
            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
        >
            Next: add filters
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-5-5 5 5-5 5" />
            </svg>
        </button>

    </div>

</form>
