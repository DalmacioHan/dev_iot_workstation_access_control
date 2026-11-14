@extends('layout.app')

@section('title', 'Event Logs')

@section('content')

@php
    $tabs = [
        ['name' => 'devices',  'label' => 'Devices',           'icon' => 'laptop'],
        ['name' => 'access',   'label' => 'Access Events',     'icon' => 'file'],
        ['name' => 'commands', 'label' => 'Commands',          'icon' => 'dash-menu'],
        ['name' => 'apps',     'label' => 'Application Usage', 'icon' => 'dashboard'],
    ];

    $tabUrl = fn (string $name): string => route(
        'monitoring',
        $name === 'devices' ? [] : ['tab' => $name]
    );
@endphp

<div class="mx-auto max-w-7xl">

    {{-- ======= PAGE HEADER ======= --}}
    <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

        <div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Event Logs
            </h1>


            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
                Every device, access event, command, and application usage record.
                Search the active tab, or open Reports for date ranges and exports.
            </p>

        </div>


        <div class="flex flex-wrap items-center gap-3">

            <button type="button" id="refresh-monitoring" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">

                <x-icon name="refresh" class="h-4 w-4" id="refresh-icon" />

                Refresh

            </button>

        </div>

    </div>


    {{-- ======= SUMMARY CARDS ======= --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Active devices --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                    <x-icon name="calendar" class="h-5 w-5" />

                </div>


                <span class="rounded-lg bg-emerald-50 px-2 py-1 text-[11px] font-semibold text-emerald-700">
                    Enabled
                </span>

            </div>


            <p class="mt-5 text-3xl font-bold text-gray-900">
                {{ $pairedDevices }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Paired devices
            </p>

        </div>


        {{-- Inactive --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-500">

                    <x-icon name="laptop" class="h-5 w-5" />

                </div>

            </div>


            <p class="mt-5 text-3xl font-bold text-gray-900">
                {{ $unpairedDevices }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Unpaired devices
            </p>

        </div>


        {{-- Granted --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                    <x-icon name="search" class="h-5 w-5" />

                </div>

            </div>


            <p class="mt-5 text-3xl font-bold text-gray-900">
                {{ $grantedAccess }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Granted access events this week
            </p>

        </div>


        {{-- Pending commands --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">

                    <x-icon name="clock" class="h-5 w-5" />

                </div>

            </div>


            <p class="mt-5 text-3xl font-bold text-gray-900">
                {{ $pendingCommands }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                Pending commands
            </p>

        </div>

    </div>

    {{-- ======= TABS ======= --}}
    <div class="mb-6 flex flex-col gap-3 rounded-2xl border border-gray-100 bg-white p-1.5 shadow-sm sm:flex-row sm:items-center sm:justify-between">

        <div class="flex flex-wrap items-center gap-1" role="tablist" aria-label="Event log views">

            @foreach ($tabs as $item)

                <a
                    href="{{ $tabUrl($item['name']) }}"
                    role="tab"
                    aria-selected="{{ $tab === $item['name'] ? 'true' : 'false' }}"
                    @if ($tab === $item['name']) aria-current="page" @endif
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition {{ $tab === $item['name'] ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    <x-icon name="{{ $item['icon'] }}" class="h-4 w-4" />
                    {{ $item['label'] }}
                </a>

            @endforeach

        </div>

        <p class="px-3 text-xs text-gray-400">
            Search covers every record in the active tab.
        </p>

    </div>

    @include('admin.monitoring.partials.' . $tab)

</div>


{{-- ======= INTERACTIONS ======= --}}
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Filter select auto-submit (access result filter)
    document.querySelectorAll('[data-auto-submit]').forEach(function (select) {

        select.addEventListener('change', function () {
            this.form.submit();
        });

    });

    // Refresh button (visual feedback)
    const refreshButton = document.getElementById('refresh-monitoring');
    const refreshIcon = document.getElementById('refresh-icon');

    if (refreshButton) {
        refreshButton.addEventListener('click', function () {
            refreshButton.disabled = true;
            refreshButton.classList.add('cursor-not-allowed', 'opacity-70');
            refreshIcon.classList.add('animate-spin');

            // In a real app, you would make an AJAX call or full reload here
            window.location.reload();
        });
    }

});
</script>

@endpush

@endsection
