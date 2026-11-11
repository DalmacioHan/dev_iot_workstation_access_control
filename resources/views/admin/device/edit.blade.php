@extends('layout.app')

@section('title', 'Edit Device')

@section('content')

<div class="min-h-[calc(100vh-5rem)] bg-slate-50/70 px-4 py-6 sm:px-6 lg:px-8">


<div class="mx-auto max-w-5xl">


    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="mb-2 flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <x-icon name="laptop" class="h-4 w-4" />
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

            <x-icon name="arrow-left" class="h-4 w-4" />

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
                        <x-icon name="laptop" class="h-7 w-7" />
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-100">
                            Workstation
                        </p>

                        <h2 class="mt-1 truncate text-xl font-bold text-white">
                            {{ $device->workstation_name }}
                        </h2>

                    </div>

                </div>
                

            </div>
        </div>

        <div class="grid grid-cols-1 divide-y divide-slate-100 sm:grid-cols-3 sm:divide-x sm:divide-y-0">


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
                    <x-icon name="file" class="h-5 w-5" />
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
                            <x-icon name="laptop" class="h-4 w-4" />
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
                            <x-icon name="information-circle" class="h-3.5 w-3.5" />
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

                        {{-- Pairing Mode --}}
                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">

                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-amber-600 shadow-sm ring-1 ring-amber-200">
                                    <x-icon name="exclamation-triangle" class="h-5 w-5" />
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

                    <x-icon name="check" class="h-4 w-4" />

                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


</div>

@endsection
