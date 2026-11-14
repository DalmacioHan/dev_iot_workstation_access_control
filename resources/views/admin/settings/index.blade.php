@extends('layout.app')

@section('title', 'System Settings')

@section('content')

@php
    $tabs = [
        'client' => [
            'label' => 'Client Behavior',
            'icon' => 'bolt',
        ],
        'mis' => [
            'label' => 'MIS / UISA API',
            'icon' => 'globe',
        ],
        'sessions' => [
            'label' => 'Sessions',
            'icon' => 'clock',
        ],
    ];

    $requestedTab = (string) (request('tab') ?: old('section'));
    $activeTab = array_key_exists($requestedTab, $tabs) ? $requestedTab : 'client';

    $timerFields = [
        [
            'name' => 'client_no_presence_timeout_seconds',
            'label' => 'No-Presence Timeout',
            'value' => old('client_no_presence_timeout_seconds', $noPresenceTimeoutSeconds ?? 300),
            'min' => 30,
            'max' => 86400,
            'presets' => [['1 min', 60], ['5 min', 300], ['10 min', 600], ['30 min', 1800]],
            'help' => 'The workstation counts as empty when both the PIR sensor and the keyboard/mouse have been silent for this long. Allowed 30 to 86,400 seconds.',
        ],
        [
            'name' => 'client_inactivity_warning_seconds',
            'label' => 'Warning Countdown',
            'value' => old('client_inactivity_warning_seconds', $inactivityWarningSeconds ?? 10),
            'min' => 3,
            'max' => 120,
            'presets' => [['5 s', 5], ['10 s', 10], ['30 s', 30]],
            'help' => 'How long the "Are you still there?" prompt counts down before the workstation client locks. Allowed 3 to 120 seconds.',
        ],
        [
            'name' => 'client_shutdown_grace_seconds',
            'label' => 'Shutdown Grace Period',
            'value' => old('client_shutdown_grace_seconds', $shutdownGraceSeconds ?? 90),
            'min' => 5,
            'max' => 3600,
            'presets' => [['30 s', 30], ['60 s', 60], ['90 s', 90]],
            'help' => 'How long the locked screen stays up before the PC powers down. Staff can still scan a card or cancel with the admin PIN. Allowed 5 to 3,600 seconds.',
        ],
    ];
@endphp

<div class="mx-auto max-w-5xl">

    {{-- Page header --}}
    <div class="mb-8">

        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
            System Settings
        </h1>

        <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-500">
            Configure workstation client behavior, the student-system connection, and stale-session cleanup.
            Each section saves on its own.
        </p>

    </div>


    {{-- Success message --}}
    @if (session('success'))

        <div
            class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4"
            role="alert"
        >

            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"
            >
                <x-icon name="check" class="h-5 w-5" />
            </div>


            <div>

                <p class="text-sm font-semibold text-emerald-800">
                    Settings updated
                </p>

                <p class="mt-1 text-xs text-emerald-700">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- Validation errors --}}
    @if ($errors->any())

        <div
            class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4"
            role="alert"
        >

            <div class="flex gap-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600"
                >
                    <x-icon name="clock" class="h-5 w-5" />
                </div>


                <div>

                    <p class="text-sm font-semibold text-red-800">
                        Please check your settings
                    </p>

                    <ul class="mt-1.5 list-inside list-disc space-y-1 text-xs leading-5 text-red-700">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- Tabs --}}
    <div
        class="mb-6 flex flex-col gap-3 rounded-2xl border border-gray-100 bg-white p-1.5 shadow-sm sm:flex-row sm:items-center sm:justify-between"
    >

        <div
            class="flex flex-wrap items-center gap-1"
            role="tablist"
            aria-label="Settings sections"
        >

            @foreach ($tabs as $key => $tab)

                <button
                    type="button"
                    role="tab"
                    id="tab-{{ $key }}"
                    aria-controls="panel-{{ $key }}"
                    aria-selected="{{ $activeTab === $key ? 'true' : 'false' }}"
                    data-settings-tab="{{ $key }}"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition {{ $activeTab === $key ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >

                    <x-icon :name="$tab['icon']" class="h-4 w-4" />

                    {{ $tab['label'] }}

                </button>

            @endforeach

        </div>


        <p class="px-3 text-xs text-gray-400">
            Each section saves independently.
        </p>

    </div>


    {{-- =========================================================
        CLIENT BEHAVIOR
    ========================================================== --}}
    <section
        id="panel-client"
        role="tabpanel"
        aria-labelledby="tab-client"
        data-settings-panel="client"
        class="rounded-3xl border border-gray-100 bg-white shadow-sm @if ($activeTab !== 'client') hidden @endif"
    >

        <form
            method="POST"
            action="{{ route('settings.update') }}"
            class="p-6 sm:p-9"
        >

            @csrf

            @method('PUT')

            <input type="hidden" name="section" value="client">


            <div class="mb-8 flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600"
                >
                    <x-icon name="bolt" class="h-5 w-5" />
                </div>


                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Power &amp; Idle
                    </h2>

                    <p class="mt-1 max-w-xl text-sm leading-6 text-gray-500">
                        Delivered to every workstation client at app start. Each client keeps the last copy,
                        so it still works while the server is offline.
                    </p>

                </div>

            </div>


            <div class="space-y-7">

                @foreach ($timerFields as $field)

                    <div>

                        <label
                            for="{{ $field['name'] }}"
                            class="mb-2.5 block text-sm font-semibold text-gray-900"
                        >
                            {{ $field['label'] }}
                            <span class="text-red-500">*</span>
                        </label>


                        <div class="relative max-w-md">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5"
                            >
                                <x-icon name="clock" class="h-5 w-5 text-gray-400" />
                            </div>


                            <input
                                type="number"
                                id="{{ $field['name'] }}"
                                name="{{ $field['name'] }}"
                                min="{{ $field['min'] }}"
                                max="{{ $field['max'] }}"
                                step="1"
                                value="{{ $field['value'] }}"
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


                        <div class="mt-2.5 flex flex-wrap items-center gap-1.5">

                            @foreach ($field['presets'] as [$presetLabel, $presetValue])

                                <button
                                    type="button"
                                    data-preset-target="{{ $field['name'] }}"
                                    data-preset-value="{{ $presetValue }}"
                                    class="rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-[11px] font-medium text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                                >
                                    {{ $presetLabel }}
                                </button>

                            @endforeach


                            <span
                                class="ml-1 text-[11px] font-medium text-gray-400"
                                data-seconds-hint="{{ $field['name'] }}"
                            ></span>

                        </div>


                        @error($field['name'])

                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror


                        <p class="mt-2 max-w-xl text-xs leading-5 text-gray-400">
                            {{ $field['help'] }}
                        </p>

                    </div>

                @endforeach

            </div>


            <div class="mt-8 border-t border-gray-100 pt-7">

                <label
                    for="client_admin_pin"
                    class="mb-2.5 block text-sm font-semibold text-gray-900"
                >
                    Admin PIN (server-managed)
                </label>

                <div class="relative max-w-md">
                    <input
                        type="text"
                        id="client_admin_pin"
                        name="client_admin_pin"
                        value="{{ old('client_admin_pin', $adminPin ?? '') }}"
                        maxlength="50"
                        autocomplete="off"
                        placeholder="Leave blank to use the local/client PIN"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-semibold text-gray-900 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >
                </div>

                @error('client_admin_pin')
                    <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-2 max-w-xl text-xs leading-5 text-gray-400">
                    When set, this PIN is pushed to all workstation clients and cached for offline use.
                    Leave blank to fall back to the PIN configured locally on each client/agent.
                </p>

            </div>


            <div class="mt-6 border-t border-gray-100 pt-7">

                <label
                    class="flex cursor-pointer items-start gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4"
                >

                    <input
                        type="checkbox"
                        id="client_disable_task_manager"
                        name="client_disable_task_manager"
                        value="1"
                        @checked(old('client_disable_task_manager', $disableTaskManager ?? false))
                        class="mt-0.5 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    >


                    <span>

                        <span class="block text-sm font-semibold text-gray-900">
                            Disable Task Manager
                        </span>

                        <span class="mt-1 block max-w-xl text-xs leading-5 text-gray-500">
                            The access agent applies this machine-wide so students cannot end the
                            client process. Leave it off if staff need Task Manager on this PC.
                        </span>

                    </span>

                </label>


                @error('client_disable_task_manager')

                    <p class="mt-2 text-xs font-medium text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            <p class="mt-6 max-w-2xl text-xs leading-5 text-gray-400">
                Changes apply the next time each workstation client app starts. The client keeps the last
                downloaded copy, so these timers still work if the server is briefly offline.
            </p>


            <div
                class="mt-8 flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-between"
            >

                <p class="text-xs text-gray-400">
                    Applies to every workstation client on its next start.
                </p>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <x-icon name="save-floppy" class="h-5 w-5" />

                    Save Client Behavior
                </button>

            </div>

        </form>

    </section>


    {{-- =========================================================
        MIS / LIBRARY API
    ========================================================== --}}
    <section
        id="panel-mis"
        role="tabpanel"
        aria-labelledby="tab-mis"
        data-settings-panel="mis"
        class="rounded-3xl border border-gray-100 bg-white shadow-sm @if ($activeTab !== 'mis') hidden @endif"
    >

        <form
            method="POST"
            action="{{ route('settings.update') }}"
            class="p-6 sm:p-9"
        >

            @csrf

            @method('PUT')

            <input type="hidden" name="section" value="mis">


            <div class="mb-8 flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
                >
                    <x-icon name="globe" class="h-5 w-5" />
                </div>


                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        MIS / Library System
                    </h2>

                    <p class="mt-1 max-w-xl text-sm leading-6 text-gray-500">
                        API address used for RFID student lookups against the university MIS
                        or the simulated Library database.
                    </p>

                </div>

            </div>


            <div>

                <label
                    for="student_api_url"
                    class="mb-2.5 block text-sm font-semibold text-gray-900"
                >
                    MIS / Library API URL
                    <span class="text-red-500">*</span>
                </label>


                <div class="relative">

                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5"
                    >
                        <x-icon name="link" class="h-5 w-5 text-gray-400" />
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

                    <p class="mt-2 text-xs font-medium text-red-600">
                        {{ $message }}
                    </p>

                @enderror


                <p class="mt-2 text-xs leading-5 text-gray-400">
                    Saving here overrides <span class="font-mono">MIS_API_BASE_URL</span>
                    from <span class="font-mono">.env</span>.
                </p>

            </div>


            <div class="mt-8 rounded-2xl border border-blue-100 bg-blue-50/70 p-5">

                <div class="flex gap-3">

                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm"
                    >
                        <x-icon name="information-circle" class="h-5 w-5" />
                    </div>


                    <div>

                        <p class="text-xs font-semibold text-blue-800">
                            Current endpoint
                        </p>

                        <p class="mt-1.5 break-all text-xs leading-5 text-blue-700">
                            <span class="font-mono">{{ $currentEndpoint ?? '—' }}</span>
                        </p>

                        <p class="mt-1.5 max-w-xl text-xs leading-5 text-blue-700">
                            This is what RFID scans use right now. A blank saved value falls
                            back to <span class="font-mono">MIS_API_BASE_URL</span> in
                            <span class="font-mono">.env</span>.
                        </p>

                    </div>

                </div>

            </div>


            <div
                class="mt-8 flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-between"
            >

                <p class="text-xs text-gray-400">
                    Takes effect immediately for new RFID lookups.
                </p>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <x-icon name="save-floppy" class="h-5 w-5" />

                    Save API Settings
                </button>

            </div>

        </form>

    </section>


    {{-- =========================================================
        SESSIONS
    ========================================================== --}}
    <section
        id="panel-sessions"
        role="tabpanel"
        aria-labelledby="tab-sessions"
        data-settings-panel="sessions"
        class="rounded-3xl border border-gray-100 bg-white shadow-sm @if ($activeTab !== 'sessions') hidden @endif"
    >

        <form
            method="POST"
            action="{{ route('settings.update') }}"
            class="p-6 sm:p-9"
        >

            @csrf

            @method('PUT')

            <input type="hidden" name="section" value="sessions">


            <div class="mb-8 flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600"
                >
                    <x-icon name="exclamation-triangle" class="h-5 w-5" />
                </div>


                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Session Cleanup
                    </h2>

                    <p class="mt-1 max-w-xl text-sm leading-6 text-gray-500">
                        Sessions on workstations that stop reporting a heartbeat are closed
                        automatically and marked as "did not log out manually".
                    </p>

                </div>

            </div>


            <div>

                <label
                    for="stale_session_minutes"
                    class="mb-2.5 block text-sm font-semibold text-gray-900"
                >
                    Stale Session Threshold
                    <span class="text-red-500">*</span>
                </label>


                <div class="relative max-w-md">

                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5"
                    >
                        <x-icon name="clock" class="h-5 w-5 text-gray-400" />
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


                <div class="mt-2.5 flex flex-wrap items-center gap-1.5">

                    @foreach ([['3 min', 3], ['5 min', 5], ['10 min', 10]] as [$presetLabel, $presetValue])

                        <button
                            type="button"
                            data-preset-target="stale_session_minutes"
                            data-preset-value="{{ $presetValue }}"
                            class="rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-[11px] font-medium text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                        >
                            {{ $presetLabel }}
                        </button>

                    @endforeach

                </div>


                @error('stale_session_minutes')

                    <p class="mt-2 text-xs font-medium text-red-600">
                        {{ $message }}
                    </p>

                @enderror


                <p class="mt-2 max-w-xl text-xs leading-5 text-gray-400">
                    The workstation client sends a heartbeat every 60 seconds. Five minutes tolerates short
                    network drops while clearing ghost sessions quickly. Allowed 1 to 1,440
                    minutes.
                </p>

            </div>


            <div
                class="mt-8 flex flex-col gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:items-center sm:justify-between"
            >

                <p class="text-xs text-gray-400">
                    Applies on the next session check.
                </p>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                >
                    <x-icon name="save-floppy" class="h-5 w-5" />

                    Save Session Settings
                </button>

            </div>

        </form>

    </section>

</div>


<script>
    (() => {
        const tabs = Array.from(document.querySelectorAll('[data-settings-tab]'));
        const panels = Array.from(document.querySelectorAll('[data-settings-panel]'));

        function activate(name, focusTab = false) {
            if (!tabs.some((tab) => tab.dataset.settingsTab === name)) return;

            tabs.forEach((tab) => {
                const active = tab.dataset.settingsTab === name;

                tab.classList.toggle('bg-blue-600', active);
                tab.classList.toggle('text-white', active);
                tab.classList.toggle('shadow-sm', active);
                tab.classList.toggle('text-gray-500', !active);
                tab.classList.toggle('hover:bg-gray-50', !active);
                tab.classList.toggle('hover:text-gray-900', !active);
                tab.setAttribute('aria-selected', active ? 'true' : 'false');
                tab.tabIndex = active ? 0 : -1;

                if (active && focusTab) tab.focus();
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.settingsPanel !== name);
            });

            if (window.location.hash !== '#' + name) {
                history.replaceState(null, '', '#' + name);
            }
        }

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => activate(tab.dataset.settingsTab));

            tab.addEventListener('keydown', (event) => {
                if (event.key !== 'ArrowRight' && event.key !== 'ArrowLeft') return;

                event.preventDefault();

                const offset = event.key === 'ArrowRight' ? 1 : -1;
                const next = (index + offset + tabs.length) % tabs.length;

                activate(tabs[next].dataset.settingsTab, true);
            });
        });

        document.querySelectorAll('[data-preset-target]').forEach((chip) => {
            chip.addEventListener('click', () => {
                const input = document.getElementById(chip.dataset.presetTarget);
                if (!input) return;

                input.value = chip.dataset.presetValue;
                input.dispatchEvent(new Event('input', { bubbles: true }));
            });
        });

        document.querySelectorAll('[data-seconds-hint]').forEach((hint) => {
            const input = document.getElementById(hint.dataset.secondsHint);
            if (!input) return;

            const update = () => {
                const seconds = Number.parseInt(input.value, 10);

                if (!Number.isFinite(seconds) || seconds <= 0) {
                    hint.textContent = '';
                    return;
                }

                hint.textContent = seconds >= 60
                    ? '= ' + (Math.round((seconds / 60) * 10) / 10) + ' min'
                    : '= ' + seconds + ' s';
            };

            input.addEventListener('input', update);
            update();
        });

        const hash = window.location.hash.replace('#', '');
        const initial = tabs.some((tab) => tab.dataset.settingsTab === hash)
            ? hash
            : @json($activeTab);

        activate(initial);
    })();
</script>

@endsection
