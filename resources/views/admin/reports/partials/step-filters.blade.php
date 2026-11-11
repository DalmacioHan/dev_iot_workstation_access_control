@php
    $hasAdvancedFilters = request()->hasAny([
        'search',
        'event',
        'result',
        'reason',
    ]);

    $skipQuery = request()->except([
        'step',
        'page',
        'course',
        'device',
        'search',
        'event',
        'result',
        'reason',
        'cols',
        'columns_configured',
    ]);

    $skipUrl = route(
        'reports.index',
        array_merge($skipQuery, ['step' => 4])
    );
@endphp

<form method="GET" action="{{ route('reports.index') }}" class="space-y-6">

    <input type="hidden" name="step" value="4">

    @include('admin.reports.partials.hidden-state', [
        'except' => [
            'course',
            'device',
            'search',
            'event',
            'result',
            'reason',
            'cols',
            'columns_configured',
        ],
    ])


    <div>

        <p class="text-xs font-bold uppercase tracking-wider text-blue-600">
            Step 3
        </p>

        <h2 class="mt-1 text-xl font-bold text-gray-900 sm:text-2xl">
            Do you want to narrow it down?
        </h2>

        <p class="mt-1 text-sm leading-6 text-gray-500">
            This step is optional. Leave everything blank to include all courses and computers.
        </p>

    </div>


    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        {{-- Course --}}
        <div>

            <label for="course" class="mb-1.5 block text-xs font-semibold text-gray-600">
                Course
            </label>

            <select
                id="course"
                name="course"
                class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
            >
                <option value="">All courses</option>

                @foreach ($courses as $course)
                    <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>
                        {{ $course }}
                    </option>
                @endforeach
            </select>

        </div>


        {{-- Computer --}}
        <div>

            <label for="device" class="mb-1.5 block text-xs font-semibold text-gray-600">
                Computer
            </label>

            <select
                id="device"
                name="device"
                class="block h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
            >
                <option value="">All computers</option>

                @foreach ($devices as $device)
                    <option value="{{ $device }}" {{ request('device') == $device ? 'selected' : '' }}>
                        {{ $device }}
                    </option>
                @endforeach
            </select>

        </div>

    </div>


    @if ($tab === 'access')

        <details
            class="rounded-2xl border border-gray-200 bg-gray-50/70 px-4 py-3"
            {{ $hasAdvancedFilters ? 'open' : '' }}
        >

            <summary class="cursor-pointer text-sm font-semibold text-gray-700">
                Advanced filters
                <span class="ml-1 text-xs font-normal text-gray-400">
                    (search, event, result, reason, columns)
                </span>
            </summary>


            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Search --}}
                <div class="sm:col-span-2 xl:col-span-4">

                    <label for="search" class="mb-1.5 block text-xs font-semibold text-gray-600">
                        Search
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search student, ID, RFID, computer, course, event, result..."
                        class="block h-11 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                    >

                </div>


                {{-- Event --}}
                <div>

                    <label for="event" class="mb-1.5 block text-xs font-semibold text-gray-600">
                        Event
                    </label>

                    <select id="event" name="event" class="block h-11 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50">
                        <option value="">All events</option>

                        @foreach ($events as $event)
                            <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                                {{ $event }}
                            </option>
                        @endforeach
                    </select>

                </div>


                {{-- Result --}}
                <div>

                    <label for="result" class="mb-1.5 block text-xs font-semibold text-gray-600">
                        Result
                    </label>

                    <select id="result" name="result" class="block h-11 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50">
                        <option value="">All results</option>

                        @foreach ($results as $result)
                            <option value="{{ $result }}" {{ request('result') == $result ? 'selected' : '' }}>
                                {{ $result }}
                            </option>
                        @endforeach
                    </select>

                </div>


                {{-- Reason --}}
                <div class="sm:col-span-2">

                    <label for="reason" class="mb-1.5 block text-xs font-semibold text-gray-600">
                        Reason
                    </label>

                    <select id="reason" name="reason" class="block h-11 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50">
                        <option value="">All reasons</option>

                        @foreach ($reasons as $reason)
                            <option value="{{ $reason }}" {{ request('reason') == $reason ? 'selected' : '' }}>
                                {{ $reason }}
                            </option>
                        @endforeach
                    </select>

                </div>

            </div>


            {{-- Columns --}}
            <div class="mt-4 rounded-2xl border border-gray-200 bg-white px-4 py-3">

                <p class="text-xs font-semibold text-gray-600">
                    Columns to show
                </p>

                <input type="hidden" name="columns_configured" value="1">

                <div class="mt-3 flex flex-wrap gap-x-6 gap-y-3">

                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border-2 border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-blue-200 hover:bg-blue-50/30 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                        <input type="checkbox" name="cols[student_name]" value="1" class="h-4 w-4 rounded border-gray-300 accent-blue-600 focus:ring-blue-500" {{ $columns['student_name'] ? 'checked' : '' }}>
                        Student
                    </label>

                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border-2 border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-blue-200 hover:bg-blue-50/30 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                        <input type="checkbox" name="cols[course]" value="1" class="h-4 w-4 rounded border-gray-300 accent-blue-600 focus:ring-blue-500" {{ $columns['course'] ? 'checked' : '' }}>
                        Course
                    </label>

                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border-2 border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-blue-200 hover:bg-blue-50/30 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                        <input type="checkbox" name="cols[device]" value="1" class="h-4 w-4 rounded border-gray-300 accent-blue-600 focus:ring-blue-500" {{ $columns['device'] ? 'checked' : '' }}>
                        Computer
                    </label>

                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border-2 border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-blue-200 hover:bg-blue-50/30 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                        <input type="checkbox" name="cols[date_time]" value="1" class="h-4 w-4 rounded border-gray-300 accent-blue-600 focus:ring-blue-500" {{ $columns['date_time'] ? 'checked' : '' }}>
                        Date &amp; time
                    </label>

                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl border-2 border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-blue-200 hover:bg-blue-50/30 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                        <input type="checkbox" name="cols[event]" value="1" class="h-4 w-4 rounded border-gray-300 accent-blue-600 focus:ring-blue-500" {{ $columns['event'] ? 'checked' : '' }}>
                        Event
                    </label>

                </div>

            </div>

        </details>

    @endif


    <div class="flex flex-col-reverse gap-2 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">

        <a
            href="{{ $stepUrl(2) }}"
            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m5 5-5-5 5-5" />
            </svg>
            Back
        </a>


        <div class="flex flex-col gap-2 sm:flex-row">

            <a
                href="{{ $skipUrl }}"
                class="inline-flex h-11 items-center justify-center rounded-xl px-4 text-sm font-semibold text-gray-500 transition hover:bg-gray-50 hover:text-gray-800"
            >
                Skip this step
            </a>

            <button
                type="submit"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
            >
                Next: review report
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-5-5 5 5-5 5" />
                </svg>
            </button>

        </div>

    </div>

</form>
