@extends('layout.app')

@section('title', 'Add Device')

@section('content')

<div class="min-h-[calc(100vh-5rem)] bg-slate-50/70 px-4 py-6 sm:px-6 lg:px-8">

<div class="mx-auto max-w-6xl">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="mb-2 flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 6v12m6-6H6" />
                    </svg>
                </span>

                <span class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">
                    Device Management
                </span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                Add Device
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Register a new workstation and connect it to your device network.
            </p>
        </div>

        <a href="{{ route('device') }}"
           class="inline-flex h-10 items-center justify-center gap-2 self-start rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100 sm:self-auto">

            <svg class="h-4 w-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19 12H5m6-6-6 6 6 6" />
            </svg>

            Back to Devices
        </a>
    </div>


    {{-- ========================================================= --}}
    {{-- MAIN GRID --}}
    {{-- ========================================================= --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">


        {{-- ===================================================== --}}
        {{-- LEFT INFORMATION PANEL --}}
        {{-- ===================================================== --}}
        <div class="lg:col-span-2">

            <div class="relative h-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- Decorative background --}}
                <div class="absolute inset-x-0 top-0 h-48 overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-600">
                    <div class="absolute -right-16 -top-20 h-48 w-48 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-20 -left-16 h-48 w-48 rounded-full bg-white/10"></div>
                </div>

                <div class="relative flex h-full flex-col p-6 sm:p-8">

                    {{-- Icon --}}
                    <div class="mb-8 flex h-20 w-20 items-center justify-center rounded-3xl border border-white/20 bg-white/15 text-white shadow-lg backdrop-blur-sm">

                        <svg class="h-10 w-10"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.6">
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path stroke-linecap="round" d="M8 7h8M8 11h8M8 15h5"/>
                            <circle cx="17" cy="17" r="1"/>
                        </svg>

                    </div>

                    {{-- Heading --}}
                    <div class="mb-8">
                        <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-blue-700">
                            New Workstation
                        </span>

                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-slate-950">
                            Register your device
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-slate-500">
                            Add a device to your system so it can be assigned and identified as a workstation.
                        </p>
                    </div>


                    {{-- Steps --}}
                    <div class="space-y-4">

                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-xs font-bold text-blue-700">
                                01
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-800">
                                    Find the device code
                                </p>
                                <p class="mt-0.5 text-xs leading-5 text-slate-500">
                                    Locate the unique code assigned to your ESP device.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-xs font-bold text-indigo-700">
                                02
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-800">
                                    Choose a workstation name
                                </p>
                                <p class="mt-0.5 text-xs leading-5 text-slate-500">
                                    Give the device an easy-to-recognize workstation name.
                                </p>
                            </div>
                        </div>



                    </div>


                    {{-- Important Notice --}}
                    <div class="mt-auto pt-8">

                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm ring-1 ring-amber-200">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 9v3.75m0 3h.007v.008H12v-.008ZM10.343 3.94l-7.5 13A1.5 1.5 0 0 0 4.142 19.2h15.716a1.5 1.5 0 0 0 1.299-2.26l-7.5-13a1.5 1.5 0 0 0-2.598 0Z" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-bold text-amber-900">
                                        Device code must be unique
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-amber-800/80">
                                        Make sure the code matches the value printed or stored on the ESP device.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>


        {{-- ===================================================== --}}
        {{-- RIGHT FORM --}}
        {{-- ===================================================== --}}
        <div class="lg:col-span-3">

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                {{-- Form Header --}}
                <div class="border-b border-slate-100 px-6 py-6 sm:px-8">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                            <svg class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h4"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base font-bold text-slate-950">
                                Device Information
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Enter the details below to register your workstation.
                            </p>
                        </div>

                    </div>
                </div>


                {{-- Form --}}
                <form method="POST"
                      action="{{ route('device.store') }}"
                      class="p-6 sm:p-8">

                    @csrf

                    <div class="space-y-6">

                        {{-- Device Code --}}
                        <div>

                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label for="device_uid"
                                       class="block text-sm font-semibold text-slate-800">
                                    Device Code
                                    <span class="text-red-500">*</span>
                                </label>

                                <span class="text-[11px] font-medium uppercase tracking-wider text-slate-400">
                                    Required
                                </span>
                            </div>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 16.5v-9Z" />
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M8 9.5h8M8 13h4" />
                                    </svg>
                                </div>

                                <input type="text"
                                       id="device_uid"
                                       name="device_uid"
                                       value="{{ old('device_uid') }}"
                                       placeholder="e.g. 12345"
                                       autocomplete="off"
                                       class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                       required />

                            </div>

                            @error('device_uid')
                                <div class="mt-2 flex items-center gap-1.5 text-xs font-medium text-red-600">
                                    <svg class="h-3.5 w-3.5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round"
                                              d="M12 8v4m0 4h.01"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror

                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                Enter the unique code printed on or stored inside the ESP device.
                            </p>

                        </div>


                        {{-- Workstation Name --}}
                        <div>

                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label for="workstation_name"
                                       class="block text-sm font-semibold text-slate-800">
                                    Workstation Name
                                    <span class="text-red-500">*</span>
                                </label>

                                <span class="text-[11px] font-medium uppercase tracking-wider text-slate-400">
                                    Required
                                </span>
                            </div>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                                        <path stroke-linecap="round"
                                              d="M8 17h8M9 7h6"/>
                                    </svg>
                                </div>

                                <input type="text"
                                       id="workstation_name"
                                       name="workstation_name"
                                       value="{{ old('workstation_name') }}"
                                       placeholder="e.g. PC 1"
                                       class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                       required />

                            </div>

                            @error('workstation_name')
                                <div class="mt-2 flex items-center gap-1.5 text-xs font-medium text-red-600">
                                    <svg class="h-3.5 w-3.5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round"
                                              d="M12 8v4m0 4h.01"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror

                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                Use a short, recognizable name such as <span class="font-semibold text-slate-500">PC 1</span> or <span class="font-semibold text-slate-500">Lab Workstation A</span>.
                            </p>

                        </div>


                        {{-- Registration Summary --}}
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m5 12 4 4L19 6" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-slate-800">
                                        Ready to register?
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        Check that your device code is correct before saving. The device will be available for workstation assignments after registration.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                        <a href="{{ route('device') }}"
                           class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">
                            Cancel
                        </a>

                        <button type="submit"
                                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">

                            <svg class="h-4 w-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m5 12 4 4L19 6" />
                            </svg>

                            Save Device
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>

</div>


</div>

@endsection
