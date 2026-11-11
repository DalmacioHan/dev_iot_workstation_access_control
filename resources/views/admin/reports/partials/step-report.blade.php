<form method="GET" action="{{ route('reports.index') }}" class="space-y-6">

    <input type="hidden" name="step" value="2">

    @include('admin.reports.partials.hidden-state', ['except' => ['tab']])


    <div>

        <p class="text-xs font-bold uppercase tracking-wider text-blue-600">
            Step 1
        </p>

        <h2 class="mt-1 text-xl font-bold text-gray-900 sm:text-2xl">
            What kind of report do you need?
        </h2>

        <p class="mt-1 text-sm leading-6 text-gray-500">
            Choose one. You can change this later.
        </p>

    </div>


    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

        {{-- Activity records --}}
        <label class="relative block cursor-pointer">

            <input
                type="radio"
                name="tab"
                value="access"
                class="peer sr-only"
                @checked($tab === 'access')
            >

            <span
                class="pointer-events-none absolute right-4 top-4 z-10 flex h-6 w-6 items-center justify-center rounded-full border-2 border-gray-300 bg-white transition peer-checked:border-blue-600 peer-checked:bg-blue-600"
            >
                <x-icon name="check" class="h-3.5 w-3.5 text-white" />
            </span>

            <span
                class="flex h-full flex-col rounded-2xl border-2 border-gray-200 bg-white p-5 transition
                hover:border-blue-200 hover:bg-blue-50/30
                peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:ring-4 peer-checked:ring-blue-100 peer-checked:shadow-md peer-checked:shadow-blue-100/60"
            >

                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                    <x-icon name="file" class="h-5 w-5" />

                </span>


                <span class="mt-4 text-base font-bold text-gray-900">
                    Activity records
                </span>

                <span class="mt-1 text-sm leading-6 text-gray-500">
                    Every check-in, check-out, and denied attempt.
                    Best for investigating a specific record or person.
                </span>

            </span>

        </label>


        {{-- Student totals --}}
        <label class="relative block cursor-pointer">

            <input
                type="radio"
                name="tab"
                value="students"
                class="peer sr-only"
                @checked($tab === 'students')
            >

            <span
                class="pointer-events-none absolute right-4 top-4 z-10 flex h-6 w-6 items-center justify-center rounded-full border-2 border-gray-300 bg-white transition peer-checked:border-blue-600 peer-checked:bg-blue-600"
            >
                <x-icon name="check" class="h-3.5 w-3.5 text-white" />
            </span>

            <span
                class="flex h-full flex-col rounded-2xl border-2 border-gray-200 bg-white p-5 transition
                hover:border-blue-200 hover:bg-blue-50/30
                peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:ring-4 peer-checked:ring-blue-100 peer-checked:shadow-md peer-checked:shadow-blue-100/60"
            >

                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                    <x-icon name="users" class="h-5 w-5" />

                </span>


                <span class="mt-4 text-base font-bold text-gray-900">
                    Student totals
                </span>

                <span class="mt-1 text-sm leading-6 text-gray-500">
                    One row per student with totals and first/last access.
                    Counts check-ins only, not check-outs.
                </span>

            </span>

        </label>

    </div>


    <div class="flex items-center justify-end border-t border-gray-100 pt-5">

        <button
            type="submit"
            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
        >
            Next: choose period
            <x-icon name="arrow-right" class="h-4 w-4" />
        </button>

    </div>

</form>
