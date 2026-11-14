{{-- ======= APPLICATION USAGE ======= --}}
<div class="mb-6 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">

    <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">

                <x-icon name="dashboard" class="h-5 w-5" />

            </div>


            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Application Usage
                </h2>

                <p class="text-sm text-gray-500">
                    Tracked applications and session time.
                </p>

            </div>

        </div>


        <a href="{{ route('analytics') }}" class="inline-flex w-fit items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
            View in Overview
            <x-icon name="arrow-right" class="h-4 w-4" />
        </a>

    </div>


    <div class="border-b border-gray-100 px-5 py-4 sm:px-6">

        <form method="GET" action="{{ route('monitoring') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center">

            <input type="hidden" name="tab" value="apps" />

            <label for="app-search" class="sr-only">
                Search application usage
            </label>

            <input
                id="app-search"
                type="search"
                name="q"
                value="{{ $search }}"
                placeholder="Search app, student, ID, or session..."
                class="block w-full flex-1 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
            />

            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                <x-icon name="search" class="h-4 w-4" />
                Search
            </button>

            @if ($search !== '')
                <a href="{{ route('monitoring', ['tab' => 'apps']) }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                    Reset
                </a>
            @endif

        </form>

    </div>


    <div class="divide-y divide-gray-100">

        @forelse ($appUsage as $usage)

            @php
                $minutes = floor($usage['seconds'] / 60);
                $remainingSeconds = $usage['seconds'] % 60;
            @endphp

            <div class="px-5 py-4 transition hover:bg-gray-50/70 sm:px-6">

                <div class="flex items-center justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-sm font-semibold text-gray-800">
                            {{ $usage['app_name'] }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ $usage['student_name'] ?? 'Unknown student' }}
                            <span class="font-mono text-[10px] text-gray-400">
                                · {{ $usage['student_external_id'] ?? 'No ID' }}
                            </span>
                        </p>

                    </div>


                    <span class="shrink-0 rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-600">
                        {{ $minutes }}m {{ $remainingSeconds }}s
                    </span>

                </div>


                <div class="mt-3 flex items-center justify-between gap-3 border-t border-gray-100 pt-3">

                    <span class="max-w-[200px] truncate font-mono text-[10px] text-gray-400">
                        {{ $usage['session_id'] }}
                    </span>


                    <span class="text-[10px] text-gray-400">
                        {{ $usage['occurred_at'] }}
                    </span>

                </div>

            </div>

        @empty

            <div class="px-5 py-14 text-center sm:px-6">

                <p class="text-sm font-semibold text-gray-700">
                    No application usage found
                </p>

                <p class="mt-1 text-xs text-gray-400">
                    {{ $search !== '' ? 'Nothing matches "' . $search . '".' : 'No application usage has been tracked yet.' }}
                </p>

            </div>

        @endforelse

    </div>

</div>

<div class="mt-6 flex flex-col items-center justify-between gap-3 sm:flex-row">

    <p class="text-xs text-gray-400">
        Showing {{ $appUsage->firstItem() ?? 0 }}–{{ $appUsage->lastItem() ?? 0 }} of {{ $appUsage->total() }} usage records
    </p>

    @if ($appUsage->hasPages())
        {{ $appUsage->onEachSide(1)->links('vendor.pagination.flowbite') }}
    @endif

</div>
