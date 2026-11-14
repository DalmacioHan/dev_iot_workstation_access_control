{{-- ======= COMMANDS ======= --}}
<div class="mb-6 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">

    <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">

                <x-icon name="dash-menu" class="h-5 w-5" />

            </div>


            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Device Commands
                </h2>

                <p class="text-sm text-gray-500">
                    Command delivery and acknowledgement status.
                </p>

            </div>

        </div>

    </div>


    <div class="border-b border-gray-100 px-5 py-4 sm:px-6">

        <form method="GET" action="{{ route('monitoring') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center">

            <input type="hidden" name="tab" value="commands" />

            <label for="command-search" class="sr-only">
                Search commands
            </label>

            <input
                id="command-search"
                type="search"
                name="q"
                value="{{ $search }}"
                placeholder="Search command, message, status, workstation..."
                class="block w-full flex-1 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
            />

            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                <x-icon name="search" class="h-4 w-4" />
                Search
            </button>

            @if ($search !== '')
                <a href="{{ route('monitoring', ['tab' => 'commands']) }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                    Reset
                </a>
            @endif

        </form>

    </div>


    <div class="divide-y divide-gray-100">

        @forelse ($deviceCommands as $command)

            <div class="flex flex-col gap-4 px-5 py-4 transition hover:bg-gray-50/70 sm:flex-row sm:items-center sm:px-6">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500">

                    <x-icon name="laptop" class="h-5 w-5" />

                </div>


                <div class="min-w-0 flex-1">

                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <div class="flex flex-wrap items-center gap-2">

                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $command['command'] }}
                                </p>

                                <span class="text-xs text-gray-400">
                                    {{ $command['device_name'] }}
                                </span>

                            </div>


                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                {{ $command['message'] }}
                            </p>

                        </div>


                        @if ($command['status'] === 'ACKNOWLEDGED')

                            <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Acknowledged
                            </span>

                        @elseif ($command['status'] === 'PENDING')

                            <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                Pending
                            </span>

                        @else

                            <span class="inline-flex w-fit items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1 text-[11px] font-semibold text-red-600">
                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                Failed
                            </span>

                        @endif

                    </div>


                    <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1 text-[10px] text-gray-400">

                        <span>
                            Created {{ $command['created_at'] }}
                        </span>

                        <span>
                            Acknowledged: {{ $command['acknowledged_at'] ?? 'Not yet' }}
                        </span>

                    </div>

                </div>

            </div>

        @empty

            <div class="px-5 py-14 text-center sm:px-6">

                <p class="text-sm font-semibold text-gray-700">
                    No commands found
                </p>

                <p class="mt-1 text-xs text-gray-400">
                    {{ $search !== '' ? 'Nothing matches "' . $search . '".' : 'No command has been sent yet.' }}
                </p>

            </div>

        @endforelse

    </div>

</div>

<div class="mt-6 flex flex-col items-center justify-between gap-3 sm:flex-row">

    <p class="text-xs text-gray-400">
        Showing {{ $deviceCommands->firstItem() ?? 0 }}–{{ $deviceCommands->lastItem() ?? 0 }} of {{ $deviceCommands->total() }} commands
    </p>

    @if ($deviceCommands->hasPages())
        {{ $deviceCommands->onEachSide(1)->links('vendor.pagination.flowbite') }}
    @endif

</div>
