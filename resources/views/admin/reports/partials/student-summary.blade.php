{{-- =========================================================
    DATA TABLE
========================================================== --}}
<div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">

    <div class="relative overflow-x-auto">

        <table class="w-full text-left text-sm text-gray-600">

            <thead class="border-b border-gray-200 bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500">

                <tr>

                    <th class="whitespace-nowrap px-5 py-4">Student</th>
                    <th class="whitespace-nowrap px-5 py-4">Student ID</th>
                    <th class="whitespace-nowrap px-5 py-4">Course</th>
                    <th class="whitespace-nowrap px-5 py-4 text-center">Allowed</th>
                    <th class="whitespace-nowrap px-5 py-4 text-center">Denied</th>
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

                        <td class="px-5 py-4 text-center font-semibold text-gray-900">
                            {{ number_format($student->denied_accesses) }}
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

                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5M4 19h16M8 16v-4M12 16V8M16 16v-7M20 16V6" />
                                    </svg>

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

    <div class="flex justify-center sm:justify-end">

        {{ $students->onEachSide(1)->links('vendor.pagination.flowbite') }}

    </div>

@endif
