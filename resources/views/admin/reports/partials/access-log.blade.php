@php
    $visibleColumnCount = collect($columns)->filter()->count();
@endphp


{{-- =========================================================
    DATA TABLE
========================================================== --}}
<div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

    <div class="relative overflow-x-auto">

        <table class="w-full text-left text-sm text-gray-600">

            <thead class="border-b border-gray-200 bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">

                <tr>

                    @if ($columns['student_name'])
                        <th scope="col" class="whitespace-nowrap px-5 py-4 sm:px-6">Student</th>
                    @endif

                    @if ($columns['course'])
                        <th scope="col" class="whitespace-nowrap px-5 py-4 sm:px-6">Course</th>
                    @endif

                    @if ($columns['device'])
                        <th scope="col" class="whitespace-nowrap px-5 py-4 sm:px-6">Computer</th>
                    @endif

                    @if ($columns['date_time'])
                        <th scope="col" class="whitespace-nowrap px-5 py-4 sm:px-6">Date &amp; Time</th>
                    @endif

                    @if ($columns['event'])
                        <th scope="col" class="whitespace-nowrap px-5 py-4 sm:px-6">Event</th>
                    @endif

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @forelse ($logs as $log)

                    <tr class="transition hover:bg-blue-50/40">

                        {{-- Student --}}
                        @if ($columns['student_name'])
                            <td class="px-5 py-4 sm:px-6">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xs font-bold text-blue-600">
                                        {{ strtoupper(substr($log->student_name ?? '?', 0, 1)) }}
                                    </div>

                                    <div>

                                        <p class="font-semibold text-gray-900">
                                            {{ $log->student_name ?: 'Unknown Student' }}
                                        </p>

                                        @if (!empty($log->student_external_id))
                                            <p class="mt-0.5 text-[11px] text-gray-400">
                                                {{ $log->student_external_id }}
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </td>
                        @endif


                        {{-- Course --}}
                        @if ($columns['course'])
                            <td class="px-5 py-4 sm:px-6">

                                @if ($log->course)
                                    <span class="inline-flex items-center rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                                        {{ $log->course }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif

                            </td>
                        @endif


                        {{-- Computer --}}
                        @if ($columns['device'])
                            <td class="px-5 py-4 sm:px-6">

                                <div class="flex items-center gap-2">

                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                                        <x-icon name="file" class="h-4 w-4" />
                                    </span>

                                    <div>

                                        <p class="font-medium text-gray-800">
                                            {{ $log->workstation_name }}
                                        </p>

                                        @if (!empty($log->device_uid))
                                            <p class="mt-0.5 font-mono text-[10px] text-gray-400">
                                                {{ $log->device_uid }}
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </td>
                        @endif


                        {{-- Date --}}
                        @if ($columns['date_time'])
                            <td class="px-5 py-4 sm:px-6">

                                <span class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                                    {{ $log->occurred_at }}
                                </span>

                            </td>
                        @endif


                        {{-- Event --}}
                        @if ($columns['event'])
                            <td class="px-5 py-4 sm:px-6">

                                @if (in_array(strtolower($log->event_type ?? ''), ['allowed', 'granted', 'success', 'time_in'], true))
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                        {{ $log->event_type }}
                                    </span>
                                @elseif (strtolower($log->event_type ?? '') === 'time_out')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        {{ $log->event_type }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        {{ $log->event_type }}
                                    </span>
                                @endif


                                @if (strtolower($log->event_type ?? '') === 'time_out' && ($log->ended_by ?? null) === 'system')
                                    <span
                                        class="mt-2 flex items-center gap-1.5 text-[11px] font-semibold text-amber-600"
                                        title="{{ $log->ended_reason ?? 'Session closed automatically' }}"
                                    >
                                        <x-icon name="exclamation-triangle" class="h-3.5 w-3.5" />
                                        Did not log out manually
                                    </span>
                                @endif

                            </td>
                        @endif

                    </tr>

                @empty

                    <tr>

                        <td colspan="{{ max(1, $visibleColumnCount) }}" class="px-6 py-16 text-center">

                            <div class="mx-auto flex max-w-sm flex-col items-center">

                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">

                                    <x-icon name="file" class="h-7 w-7" />

                                </div>

                                <h3 class="mt-4 text-sm font-bold text-gray-800">
                                    No access records found
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Nothing matches these filters. Try a wider date range or reset the filters.
                                </p>

                                <a
                                    href="{{ route('reports.index', ['tab' => 'access', 'step' => 3]) }}"
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
@if ($logs->hasPages())

    <div class="flex justify-center sm:justify-end">

        {{ $logs->onEachSide(1)->links('vendor.pagination.flowbite') }}

    </div>

@endif
