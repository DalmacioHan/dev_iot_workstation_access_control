{{-- ======= DEVICES ======= --}}
<div class="mb-6 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">

    <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-5 sm:px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                <x-icon name="laptop" class="h-5 w-5" />

            </div>


            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Workstation Devices
                </h2>

                <p class="text-sm text-gray-500">
                    Registered devices and their latest communication.
                </p>

            </div>

        </div>


        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

            <form method="GET" action="{{ route('monitoring') }}" class="flex flex-1 flex-col gap-2 sm:flex-row sm:items-center">

                <input type="hidden" name="tab" value="devices" />

                <label for="device-search" class="sr-only">
                    Search devices
                </label>

                <input
                    id="device-search"
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Search workstation or pairing code..."
                    class="block w-full flex-1 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                />

                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                    <x-icon name="search" class="h-4 w-4" />
                    Search
                </button>

                @if ($search !== '')
                    <a href="{{ route('monitoring') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                        Reset
                    </a>
                @endif

            </form>


            <a href="{{ route('device') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                Manage devices
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>

        </div>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full text-left">

            <thead class="border-b border-gray-100 bg-gray-50/80 text-[11px] font-semibold uppercase tracking-wider text-gray-400">

                <tr>

                    <th class="px-6 py-3.5">
                        Workstation
                    </th>

                    <th class="px-6 py-3.5">
                        Last Seen
                    </th>

                    <th class="px-6 py-3.5">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @forelse ($devices as $device)

                    <tr class="transition hover:bg-gray-50/80">

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $device['is_paired'] ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-400' }}">

                                    <x-icon name="laptop" class="h-5 w-5" />

                                </div>


                                <div>

                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $device['workstation_name'] }}
                                    </p>

                                    <p class="mt-0.5 text-[11px] text-gray-400">
                                        Device #{{ $device['id'] }}
                                        @if ($device['pairing_code'])
                                            · {{ $device['pairing_code'] }}
                                        @endif
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td class="whitespace-nowrap px-6 py-4">

                            <div class="flex items-center gap-2">

                                <span class="h-2 w-2 rounded-full {{ $device['is_paired'] ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>

                                <span class="text-xs text-gray-500" title="{{ $device['last_seen_title'] }}">
                                    {{ $device['last_seen_at'] }}
                                </span>

                            </div>

                        </td>


                        <td class="px-6 py-4">

                            @if ($device['is_paired'])

                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Paired
                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                    Unpaired
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3" class="px-6 py-14 text-center">

                            <p class="text-sm font-semibold text-gray-700">
                                No devices found
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                {{ $search !== '' ? 'Nothing matches "' . $search . '".' : 'No workstation has registered yet.' }}
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
        Showing {{ $devices->firstItem() ?? 0 }}–{{ $devices->lastItem() ?? 0 }} of {{ $devices->total() }} workstations
    </p>

    @if ($devices->hasPages())
        {{ $devices->onEachSide(1)->links('vendor.pagination.flowbite') }}
    @endif

</div>
