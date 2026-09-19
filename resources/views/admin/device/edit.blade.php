@extends('layout.app')

@section('title', 'Edit Device')

@section('content')

<div class="min-h-[calc(100vh-5rem)] bg-slate-50/70 px-4 py-6 sm:px-6 lg:px-8">


<div class="mx-auto max-w-5xl">


    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="mb-2 flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <rect x="4" y="4" width="16" height="16" rx="2"/>
                        <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h4"/>
                    </svg>
                </span>

                <span class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">
                    Device Management
                </span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                Edit Device
            </h1>

            <p class="mt-1 max-w-2xl text-sm text-slate-500">
                Update the workstation name and operational status for this device.
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
    {{-- DEVICE OVERVIEW --}}
    {{-- ========================================================= --}}
    <div class="mb-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-600 px-6 py-6 sm:px-8">

            <div class="absolute -right-12 -top-16 h-40 w-40 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-24 left-1/3 h-48 w-48 rounded-full bg-white/10"></div>

            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-4">

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-white/20 bg-white/15 text-white shadow-lg backdrop-blur-sm">
                        <svg class="h-7 w-7"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.7">
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path stroke-linecap="round" d="M8 7h8M8 11h8M8 15h5"/>
                            <circle cx="17" cy="17" r="1"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-100">
                            Workstation
                        </p>

                        <h2 class="mt-1 truncate text-xl font-bold text-white">
                            {{ $device->workstation_name }}
                        </h2>

                        <p class="mt-1 font-mono text-xs text-blue-100">
                            Device #{{ $device->device_uid }}
                        </p>
                    </div>

                </div>


                {{-- Current Status --}}
                <div class="flex items-center self-start rounded-full border border-white/20 bg-white/10 px-3 py-1.5 backdrop-blur-sm">

                    @if($device->is_active)
                        <span class="mr-2 h-2 w-2 rounded-full bg-emerald-300 shadow-[0_0_0_3px_rgba(110,231,183,0.15)]"></span>
                        <span class="text-xs font-bold text-white">
                            Active
                        </span>
                    @else
                        <span class="mr-2 h-2 w-2 rounded-full bg-slate-300"></span>
                        <span class="text-xs font-bold text-white">
                            Inactive
                        </span>
                    @endif

                </div>

            </div>
        </div>

        <div class="grid grid-cols-1 divide-y divide-slate-100 sm:grid-cols-3 sm:divide-x sm:divide-y-0">

            <div class="p-5">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    Device Code
                </p>

                <p class="mt-1.5 truncate font-mono text-sm font-semibold text-slate-700">
                    {{ $device->device_uid }}
                </p>
            </div>

            <div class="p-5">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    Workstation
                </p>

                <p class="mt-1.5 truncate text-sm font-semibold text-slate-700">
                    {{ $device->workstation_name }}
                </p>
            </div>

            <div class="p-5">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    Configuration
                </p>

                <p class="mt-1.5 text-sm font-semibold text-slate-700">
                    @if(empty($device->pairing_code))
                        Standard
                    @else
                        Pairing Mode
                    @endif
                </p>
            </div>

        </div>
    </div>


    {{-- ========================================================= --}}
    {{-- MAIN FORM --}}
    {{-- ========================================================= --}}
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
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M11.25 4.5H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-4.5M14.25 4.5h5.25m0 0v5.25m0-5.25-7.5 7.5" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-base font-bold text-slate-950">
                        Device Settings
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Modify the details and operational settings for this device.
                    </p>
                </div>

            </div>

        </div>


        <form method="POST"
              action="{{ route('device.update', $device->id) }}"
              class="p-6 sm:p-8">

            @csrf
            @method('PUT')

            <div class="space-y-7">


                {{-- ================================================= --}}
                {{-- DEVICE CODE --}}
                {{-- ================================================= --}}
                <div>

                    <label for="device_uid"
                           class="mb-2 block text-sm font-semibold text-slate-800">
                        Device Code
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="h-4 w-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <rect x="4" y="5" width="16" height="14" rx="2"/>
                                <path stroke-linecap="round"
                                      d="M8 9h8M8 13h5"/>
                            </svg>
                        </div>

                        <input type="text"
                               id="device_uid"
                               value="{{ $device->device_uid }}"
                               disabled
                               class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-100 pl-10 pr-4 font-mono text-sm font-semibold text-slate-500 shadow-sm cursor-not-allowed">

                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5">
                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-200 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                <svg class="h-3 w-3"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M16.5 10.5V7.875a4.5 4.5 0 0 0-9 0V10.5m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v7.5A1.5 1.5 0 0 1 17.25 21H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                </svg>
                                Locked
                            </span>
                        </div>

                    </div>

                    <div class="mt-2 flex items-start gap-2">

                        <svg class="mt-0.5 h-3.5 w-3.5 shrink-0 text-slate-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 9v3.75m0 3h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        <p class="text-xs leading-5 text-slate-400">
                            The physical device code is permanently associated with this hardware and cannot be changed.
                        </p>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- WORKSTATION NAME --}}
                {{-- ================================================= --}}
                <div>

                    <label for="workstation_name"
                           class="mb-2 block text-sm font-semibold text-slate-800">
                        Workstation Name
                        <span class="text-red-500">*</span>
                    </label>

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
                               value="{{ old('workstation_name', $device->workstation_name) }}"
                               placeholder="{{ $device->workstation_name }}"
                               class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                               required>

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
                        Choose a short, recognizable name for this workstation.
                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- STATUS --}}
                {{-- ================================================= --}}
                <div>

                    @if(empty($device->pairing_code))

                        <label for="is_active"
                               class="mb-2 block text-sm font-semibold text-slate-800">
                            Device Status
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                @if(old('is_active', $device->is_active) == 1)
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                @else
                                    <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                                @endif
                            </div>

                            <select id="is_active"
                                    name="is_active"
                                    class="block h-12 w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-10 text-sm font-medium text-slate-900 shadow-sm outline-none transition hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                    required>

                                <option value="1" @selected(old('is_active', $device->is_active) == 1)>
                                    Active
                                </option>

                                <option value="0" @selected(old('is_active', $device->is_active) == 0)>
                                    Inactive
                                </option>

                            </select>

                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                                <svg class="h-4 w-4"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="m6 9 6 6 6-6" />
                                </svg>
                            </div>

                        </div>

                        @error('is_active')
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

                        {{-- Active / Inactive Notice --}}
                        <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm ring-1 ring-amber-200">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-bold text-amber-900">
                                        Status change affects access
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-amber-800/80">
                                        Setting this hardware instance to inactive will automatically interrupt access permissions over any currently designated multi-sensor configurations.
                                    </p>
                                </div>

                            </div>

                        </div>

                    @else

                        {{-- Pairing Mode --}}
                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm ring-1 ring-amber-200">
                                    <svg class="h-5 w-5"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>

                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="text-sm font-bold text-amber-900">
                                            Device is in pairing mode
                                        </p>

                                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-700">
                                            Restricted
                                        </span>
                                    </div>

                                    <p class="mt-1.5 text-xs leading-5 text-amber-800/80">
                                        This device cannot be deactivated until the pairing process is completed or cancelled.
                                    </p>
                                </div>

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- ACTIONS --}}
            {{-- ================================================= --}}
            <div class="mt-6 flex flex-col-reverse gap-3 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-end">

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

                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


</div>

@endsection
