{{-- ======= ACCESS EVENTS ======= --}}
<div class="mb-6 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">

    <div class="border-b border-gray-100 px-5 py-5 sm:px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                <x-icon name="file" class="h-5 w-5" />

            </div>


            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Access Events
                </h2>

                <p class="text-sm text-gray-500">
                    RFID and workstation activity from pc_access_logs.
                </p>

            </div>

        </div>

    </div>


    <div class="border-b border-gray-100 px-5 py-4 sm:px-6">

        <form method="GET" action="{{ route('monitoring') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center">

            <input type="hidden" name="tab" value="access" />

            <label for="access-search" class="sr-only">
                Search access events
            </label>

            <input
                id="access-search"
                type="search"
                name="q"
                value="{{ $search }}"
                placeholder="Search student, ID, RFID, workstation, course..."
                class="block w-full flex-1 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
            />

            <label for="access-result" class="sr-only">
                Filter by result
            </label>

            <select
                id="access-result"
                name="result"
                data-auto-submit
                class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-700 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 sm:w-40"
            >
                <option value="">All results</option>
                <option value="allowed" @selected($resultFilter === 'allowed')>Allowed</option>
                <option value="denied" @selected($resultFilter === 'denied')>Denied</option>
            </select>

            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                <x-icon name="search" class="h-4 w-4" />
                Search
            </button>

            @if ($search !== '' || $resultFilter !== null)
                <a href="{{ route('monitoring', ['tab' => 'access']) }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                    Reset
                </a>
            @endif

        </form>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full text-left text-sm">

            <thead class="border-b border-gray-100 bg-gray-50/80 text-[11px] font-semibold uppercase tracking-wider text-gray-400">

                <tr>

                    <th class="px-6 py-3.5">
                        Student
                    </th>

                    <th class="px-6 py-3.5">
                        Workstation
                    </th>

                    <th class="px-6 py-3.5">
                        Event
                    </th>

                    <th class="px-6 py-3.5">
                        Result
                    </th>

                    <th class="px-6 py-3.5">
                        Session
                    </th>

                    <th class="px-6 py-3.5">
                        Time
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @forelse ($accessLogs as $log)

                    <tr class="transition hover:bg-gray-50/80">

                        <td class="px-6 py-4">

                            <div>

                                <p class="font-semibold text-gray-800">
                                    {{ $log['student_name'] ?? 'Unknown' }}
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $log['student_external_id'] ?? 'No ID' }}
                                </p>

                                @if ($log['course'])
                                    <p class="mt-0.5 text-[11px] text-gray-400">
                                        {{ $log['course'] }}
                                    </p>
                                @endif

                            </div>

                        </td>


                        <td class="px-6 py-4">

                            <span class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-600">
                                {{ $log['device_name'] }}
                            </span>

                        </td>


                        <td class="px-6 py-4">

                            <p class="text-xs font-semibold text-gray-700">
                                {{ $log['event_type'] }}
                            </p>

                        </td>


                        <td class="px-6 py-4">

                            @if (strtolower($log['event_type'] ?? '') === 'time_in')
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $log['event_type'] }}
                                </span>
                            @elseif (strtolower($log['event_type'] ?? '') === 'time_out')
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    {{ $log['event_type'] }}
                                </span>
                            @elseif (in_array(strtoupper($log['result']), ['ALLOWED', 'GRANTED', 'SUCCESS'], true))
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $log['result'] }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                    {{ $log['result'] }}
                                </span>
                            @endif


                            @if (strtolower($log['event_type'] ?? '') === 'time_out' && ($log['ended_by'] ?? null) === 'system')
                                <p
                                    class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-amber-50 px-2 py-1 text-[11px] font-semibold text-amber-700"
                                    title="{{ $log['ended_reason'] ?? 'Session closed automatically' }}"
                                >
                                    <x-icon name="exclamation-triangle" class="h-3.5 w-3.5" />
                                    Did not log out manually
                                </p>
                            @endif

                        </td>


                        <td class="px-6 py-4">

                            <span class="font-mono text-[10px] text-gray-400">
                                {{ $log['session_id'] ?? '—' }}
                            </span>

                        </td>


                        <td class="whitespace-nowrap px-6 py-4">

                            <p class="text-xs font-medium text-gray-600">
                                {{ $log['occurred_at'] }}
                            </p>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="px-6 py-14 text-center">

                            <p class="text-sm font-semibold text-gray-700">
                                No access events found
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                {{ $search !== '' || $resultFilter !== null ? 'Nothing matches the current search or result filter.' : 'No access event has been recorded yet.' }}
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-6 flex flex-col items-center justify-between gap-3 sm:flex-row">

    <p class="text-xs text-gray-400">
        Showing {{ $accessLogs->firstItem() ?? 0 }}–{{ $accessLogs->lastItem() ?? 0 }} of {{ $accessLogs->total() }} access events
    </p>

    @if ($accessLogs->hasPages())
        {{ $accessLogs->onEachSide(1)->links('vendor.pagination.flowbite') }}
    @endif

</div>
