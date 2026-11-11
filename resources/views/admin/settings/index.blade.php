@extends('layout.app')

@section('title', 'System Settings')

@section('content')

<div class="mx-auto max-w-6xl">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="mb-8">

        <div class="mb-2 flex items-center gap-2">

            <span
                class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600"
            >
                <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>

                System Configuration
            </span>

        </div>


        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
            System Settings
        </h1>


        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
            Configure external student-system connectivity and workstation
            sensor behavior.
        </p>

    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}
    @if (session('success'))

        <div
            class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4"
            role="alert"
        >

            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="m5 12 4 4L19 6"
                    />
                </svg>

            </div>


            <div>

                <p class="text-sm font-semibold text-emerald-800">
                    Settings updated
                </p>

                <p class="mt-0.5 text-xs text-emerald-700">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}
    @if ($errors->any())

        <div
            class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4"
            role="alert"
        >

            <div class="flex gap-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke-width="1.8"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-width="1.8"
                            d="M12 8v5"
                        />

                        <circle
                            cx="12"
                            cy="17"
                            r=".8"
                            fill="currentColor"
                            stroke="none"
                        />
                    </svg>

                </div>


                <div>

                    <p class="text-sm font-semibold text-red-800">
                        Please check your settings
                    </p>

                    <ul class="mt-1 list-inside list-disc text-xs leading-5 text-red-700">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        SETTINGS FORM
    ========================================================== --}}
    <form
        method="POST"
        action="{{ route('settings.update') }}"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

            {{-- =================================================
                LEFT INFORMATION PANEL
            ================================================== --}}
            <div class="lg:col-span-2">

                <div
                    class="relative h-full overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 p-6 text-white shadow-lg shadow-blue-100 sm:p-8"
                >

                    <div
                        class="pointer-events-none absolute -right-16 -top-16 h-44 w-44 rounded-full bg-white/10"
                    ></div>

                    <div
                        class="pointer-events-none absolute -bottom-20 -left-16 h-52 w-52 rounded-full bg-white/5"
                    ></div>


                    <div class="relative">

                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur"
                        >

                            <svg
                                class="h-7 w-7"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 2v3m0 14v3M4.93 4.93l2.12 2.12m9.9 9.9 2.12 2.12M2 12h3m14 0h3M4.93 19.07l2.12-2.12m9.9-9.9 2.12-2.12"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="4"
                                    stroke-width="1.8"
                                />
                            </svg>

                        </div>


                        <h2 class="mt-6 text-2xl font-bold tracking-tight">
                            Configuration
                        </h2>


                        <p class="mt-3 text-sm leading-6 text-blue-100">
                            These settings control how OLH communicates with
                            the external student system and how connected
                            workstation sensors handle inactivity.
                        </p>


                        <div class="mt-8 space-y-5">

                            {{-- External API --}}
                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-sm font-bold text-blue-600"
                                >
                                    1
                                </div>


                                <div>

                                    <p class="text-sm font-semibold">
                                        Student API
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-blue-100">
                                        Connect OLH to the external student
                                        information system.
                                    </p>

                                </div>

                            </div>


                            {{-- PIR --}}
                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/15 text-sm font-bold ring-1 ring-white/20"
                                >
                                    2
                                </div>


                                <div>

                                    <p class="text-sm font-semibold">
                                        PIR Sensor
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-blue-100">
                                        Control how long a workstation waits
                                        without motion before becoming idle.
                                    </p>

                                </div>

                            </div>


                            {{-- Session cleanup --}}
                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/15 text-sm font-bold ring-1 ring-white/20"
                                >
                                    3
                                </div>


                                <div>

                                    <p class="text-sm font-semibold">
                                        Session Cleanup
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-blue-100">
                                        Automatically close sessions left open
                                        by crashes, shutdowns, or lost network.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div
                            class="mt-10 rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm"
                        >

                            <div class="flex gap-3">

                                <svg
                                    class="mt-0.5 h-5 w-5 shrink-0 text-blue-100"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 3 5 6v5c0 4.7 2.9 8.6 7 10 4.1-1.4 7-5.3 7-10V6l-7-3Z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="m9.5 12 1.7 1.7 3.5-3.5"
                                    />
                                </svg>


                                <div>

                                    <p class="text-xs font-semibold">
                                        Administrative settings
                                    </p>

                                    <p class="mt-1 text-[11px] leading-4 text-blue-100">
                                        Only authorized administrators should
                                        be allowed to modify these values.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                RIGHT SETTINGS
            ================================================== --}}
            <div class="space-y-6 lg:col-span-3">

                {{-- =================================================
                    STUDENT API
                ================================================== --}}
                <div
                    class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8"
                >

                    <div class="mb-7 flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke-width="1.8"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"
                                />
                            </svg>

                        </div>


                        <div>

                            <h2 class="text-lg font-bold text-gray-900">
                                MIS / Library System Integration
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Configure the API address used for RFID student
                                lookups against the university MIS or the
                                simulated Library database.
                            </p>

                        </div>

                    </div>


                    <div>

                        <label
                            for="student_api_url"
                            class="mb-2 block text-sm font-semibold text-gray-900"
                        >
                            MIS / Library API URL
                            <span class="text-red-500">*</span>
                        </label>


                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5"
                            >

                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M10.5 13.5 13.5 10.5M8.5 15.5l-1 1a3.54 3.54 0 0 1-5-5l3-3a3.54 3.54 0 0 1 5 0M15.5 8.5l1-1a3.54 3.54 0 0 1 5 5l-3 3a3.54 3.54 0 0 1-5 0"
                                    />
                                </svg>

                            </div>


                            <input
                                type="url"
                                id="student_api_url"
                                name="student_api_url"
                                value="{{ old('student_api_url', $studentApiUrl ?? '') }}"
                                required
                                placeholder="https://students.example.edu/api"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            >

                        </div>


                        @error('student_api_url')

                            <p class="mt-1.5 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-2 text-xs leading-5 text-gray-400">
                            Base URL supplied by the university MIS (or the
                            simulated LibraryApi). Saving here overrides
                            <span class="font-mono">MIS_API_BASE_URL</span>
                            from <span class="font-mono">.env</span>.
                        </p>

                    </div>


                    <div
                        class="mt-5 rounded-2xl border border-blue-100 bg-blue-50/70 p-4"
                    >

                        <div class="flex gap-3">

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm"
                            >

                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.8"
                                        d="M12 11v5"
                                    />

                                    <circle
                                        cx="12"
                                        cy="8"
                                        r=".8"
                                        fill="currentColor"
                                        stroke="none"
                                    />
                                </svg>

                            </div>


                            <div>

                                <p class="text-xs font-semibold text-blue-800">
                                    Current endpoint
                                </p>

                                <p class="mt-1 break-all text-xs leading-5 text-blue-700">
                                    <span class="font-mono">
                                        {{ $currentEndpoint ?? '—' }}
                                    </span>
                                </p>

                                <p class="mt-1 text-xs leading-5 text-blue-700">
                                    This is what RFID scans use right now. A
                                    blank saved value falls back to
                                    <span class="font-mono">MIS_API_BASE_URL</span>
                                    in <span class="font-mono">.env</span>.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    PIR SENSOR
                ================================================== --}}
                <div
                    class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8"
                >

                    <div class="mb-7 flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="2"
                                    stroke-width="1.8"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.8"
                                    d="M8.5 8.5a5 5 0 0 0 0 7M15.5 8.5a5 5 0 0 1 0 7"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.8"
                                    d="M5.5 5.5a9 9 0 0 0 0 13M18.5 5.5a9 9 0 0 1 0 13"
                                />
                            </svg>

                        </div>


                        <div>

                            <h2 class="text-lg font-bold text-gray-900">
                                PIR Sensor Behavior
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Configure how long the workstation waits
                                without detected movement.
                            </p>

                        </div>

                    </div>


                    <div>

                        <label
                            for="pir_timeout_seconds"
                            class="mb-2 block text-sm font-semibold text-gray-900"
                        >
                            Inactivity Timeout
                            <span class="text-red-500">*</span>
                        </label>


                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5"
                            >

                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 7v5l3 2"
                                    />
                                </svg>

                            </div>


                            <input
                                type="number"
                                id="pir_timeout_seconds"
                                name="pir_timeout_seconds"
                                min="5"
                                max="3600"
                                step="1"
                                value="{{ old('pir_timeout_seconds', $pirTimeoutSeconds ?? 60) }}"
                                required
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-24 text-sm font-semibold text-gray-900 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            >


                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4"
                            >
                                <span
                                    class="rounded-lg bg-gray-100 px-2 py-1 text-xs font-medium text-gray-500"
                                >
                                    seconds
                                </span>
                            </div>

                        </div>


                        @error('pir_timeout_seconds')

                            <p class="mt-1.5 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-2 text-xs leading-5 text-gray-400">
                            Allowed range: 5 to 3,600 seconds.
                            For example, 60 seconds means the workstation
                            becomes idle after one minute without detected motion.
                        </p>

                    </div>


                    {{-- Quick values --}}
                    <div class="mt-5">

                        <p class="mb-2 text-xs font-semibold text-gray-500">
                            Quick presets
                        </p>


                        <div class="flex flex-wrap gap-2">

                            <button
                                type="button"
                                data-pir-value="30"
                                class="pir-preset rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                            >
                                30 sec
                            </button>


                            <button
                                type="button"
                                data-pir-value="60"
                                class="pir-preset rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                            >
                                1 min
                            </button>


                            <button
                                type="button"
                                data-pir-value="120"
                                class="pir-preset rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                            >
                                2 min
                            </button>


                            <button
                                type="button"
                                data-pir-value="300"
                                class="pir-preset rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                            >
                                5 min
                            </button>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    SESSION CLEANUP
                ================================================== --}}
                <div
                    class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8"
                >

                    <div class="mb-7 flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 8v5m0 3.5v.5M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"
                                />

                            </svg>

                        </div>


                        <div>

                            <h2 class="text-lg font-bold text-gray-900">
                                Session Cleanup
                            </h2>

                            <p class="mt-1 text-sm leading-6 text-gray-500">
                                Sessions on workstations that stop reporting a
                                heartbeat are closed automatically and marked as
                                "did not log out manually".
                            </p>

                        </div>

                    </div>


                    <div>

                        <label
                            for="stale_session_minutes"
                            class="mb-2 block text-sm font-semibold text-gray-900"
                        >
                            Stale Session Threshold
                            <span class="text-red-500">*</span>
                        </label>


                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5"
                            >

                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 7v5l3 2"
                                    />
                                </svg>

                            </div>


                            <input
                                type="number"
                                id="stale_session_minutes"
                                name="stale_session_minutes"
                                min="1"
                                max="1440"
                                step="1"
                                value="{{ old('stale_session_minutes', $staleSessionMinutes ?? 5) }}"
                                required
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-24 text-sm font-semibold text-gray-900 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            >


                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4"
                            >
                                <span
                                    class="rounded-lg bg-gray-100 px-2 py-1 text-xs font-medium text-gray-500"
                                >
                                    minutes
                                </span>
                            </div>

                        </div>


                        @error('stale_session_minutes')

                            <p class="mt-1.5 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-2 text-xs leading-5 text-gray-400">
                            The kiosk sends a heartbeat every 60 seconds. Five
                            minutes tolerates short network drops while clearing
                            ghost sessions quickly. Allowed range: 1 to 1,440 minutes.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                    SAVE ACTION
                ================================================== --}}
                <div
                    class="flex flex-col gap-3 rounded-3xl border border-gray-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between"
                >

                    <div>

                        <p class="text-sm font-semibold text-gray-900">
                            Save system configuration
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            Changes take effect after they are saved.
                        </p>

                    </div>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                    >

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M5 3h12l2 2v16H5V3Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 3v6h8V3M8 21v-7h8v7"
                            />
                        </svg>

                        Save Settings

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- =========================================================
    PIR PRESETS
========================================================== --}}
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const pirInput =
        document.getElementById('pir_timeout_seconds');

    const presetButtons =
        document.querySelectorAll('.pir-preset');


    presetButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            if (!pirInput) {
                return;
            }


            pirInput.value =
                button.dataset.pirValue;


            pirInput.focus();


            presetButtons.forEach(function (item) {

                item.classList.remove(
                    'border-blue-200',
                    'bg-blue-50',
                    'text-blue-600'
                );

            });


            button.classList.add(
                'border-blue-200',
                'bg-blue-50',
                'text-blue-600'
            );

        });

    });

});

</script>

@endpush

@endsection
