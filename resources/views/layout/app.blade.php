<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    <title>
        @yield('title', 'Dashboard') | OLH
    </title>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    {{-- Flowbite --}}
    <link
        href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css"
        rel="stylesheet"
    >

</head>


<body class="bg-gray-50 text-gray-900 antialiased">

    {{-- =========================================================
        TOP NAVBAR
    ========================================================== --}}
    <nav
        class="fixed top-0 z-50 w-full border-b border-gray-200 bg-white"
    >

        <div class="px-4 py-3 lg:px-6">

            <div class="flex items-center justify-between">

                {{-- =================================================
                    LEFT SIDE
                ================================================== --}}
                <div class="flex items-center">

                    {{-- Mobile Sidebar Button --}}
                    <button
                        data-drawer-target="logo-sidebar"
                        data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar"
                        type="button"
                        class="mr-3 inline-flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:hidden"
                    >

                        <span class="sr-only">
                            Open sidebar
                        </span>


                        <x-icon name="dash-menu" class="h-5 w-5" aria-hidden="true" />

                    </button>


                    {{-- Brand --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-3"
                    >

                        <div
                            class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl bg-blue-600 shadow-sm"
                        >

                            <img
                                src="{{ asset('image/library_logo.jpg') }}"
                                class="h-full w-full object-cover"
                                alt="OLH Logo"
                            >

                        </div>


                        <div class="hidden sm:block">

                            <p
                                class="text-base font-bold tracking-tight text-gray-900"
                            >
                                OLH
                            </p>


                            <p
                                class="text-[11px] font-medium text-gray-400"
                            >
                                Workstation Management
                            </p>

                        </div>

                    </a>

                </div>


                {{-- =================================================
                    RIGHT SIDE
                ================================================== --}}
                <div class="flex items-center gap-3">

                    <div
                        class="hidden h-8 w-px bg-gray-200 sm:block"
                    ></div>


                    {{-- =================================================
                        USER MENU
                    ================================================== --}}
                    <div class="relative">

                        <button
                            type="button"
                            class="flex items-center gap-3 rounded-xl p-1.5 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            aria-expanded="false"
                            data-dropdown-toggle="dropdown-user"
                        >

                            <img
                                class="h-9 w-9 rounded-xl object-cover ring-2 ring-gray-100"
                                src="{{ Auth::user()->profile_picture
                                    ? asset('storage/' . Auth::user()->profile_picture)
                                    : asset('image/default_user.png') }}"
                                alt="{{ Auth::user()->name }}"
                            >


                            <div class="hidden text-left md:block">

                                <p
                                    class="max-w-[140px] truncate text-sm font-semibold text-gray-900"
                                >
                                    {{ Auth::user()->name }}
                                </p>


                                <p
                                    class="max-w-[140px] truncate text-xs text-gray-400"
                                >
                                    {{ Auth::user()->email }}
                                </p>

                            </div>


                            <x-icon name="chevron-down" class="hidden h-4 w-4 text-gray-400 md:block" />

                        </button>


                        {{-- User Dropdown --}}
                        <div
                            id="dropdown-user"
                            class="z-50 hidden w-64 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xl"
                        >

                            {{-- User Header --}}
                            <div
                                class="border-b border-gray-100 bg-gray-50/70 px-4 py-4"
                            >

                                <div class="flex items-center gap-3">

                                    <img
                                        class="h-10 w-10 rounded-xl object-cover"
                                        src="{{ Auth::user()->profile_picture
                                            ? asset('storage/' . Auth::user()->profile_picture)
                                            : asset('image/default_user.png') }}"
                                        alt="{{ Auth::user()->name }}"
                                    >


                                    <div class="min-w-0">

                                        <p
                                            class="truncate text-sm font-semibold text-gray-900"
                                        >
                                            {{ Auth::user()->name }}
                                        </p>


                                        <p
                                            class="truncate text-xs text-gray-500"
                                        >
                                            {{ Auth::user()->email }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <ul class="p-2 text-sm text-gray-700">

                                {{-- Dashboard --}}
                                <li>

                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-blue-50 hover:text-blue-600"
                                    >

                                        <x-icon name="dashboard" class="h-5 w-5" />

                                        Dashboard

                                    </a>

                                </li>


                                {{-- Manage Account --}}
                                <li>

                                    <a
                                        href="{{ route('account') }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-blue-50 hover:text-blue-600"
                                    >

                                        <x-icon name="user-plus" class="h-5 w-5" />

                                        Manage Account

                                    </a>

                                </li>


                                {{-- System Settings --}}
                                @if(auth()->user()->isSuperAdmin())

                                    <li>

                                        <a
                                            href="{{ route('settings.index') }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-blue-50 hover:text-blue-600"
                                        >

                                            <x-icon name="settings" class="h-5 w-5" />

                                            System Settings

                                        </a>

                                    </li>

                                @endif


                                {{-- Sign Out --}}
                                <li>

                                    <a
                                        href="{{ route('logout') }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-600 transition hover:bg-red-50"
                                    >

                                        <x-icon name="logout" class="h-5 w-5" />

                                        Sign out

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </nav>


    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}
    <aside
        id="logo-sidebar"
        class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-20 transition-transform sm:translate-x-0"
        aria-label="Sidebar"
    >

        <div
            class="flex h-full flex-col overflow-y-auto px-4 pb-5"
        >

            {{-- Sidebar Heading --}}
            <div class="mb-5 px-2">

                <p
                    class="text-[11px] font-semibold uppercase tracking-wider text-gray-400"
                >
                    Main Menu
                </p>

            </div>


            {{-- =====================================================
                NAVIGATION
            ====================================================== --}}
            <ul class="space-y-1.5">

                {{-- =================================================
                    DASHBOARD
                ================================================== --}}
                <li>

                    <a
                        href="{{ route('dashboard') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('dashboard')
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >

                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-lg
                            {{ request()->routeIs('dashboard')
                                ? 'bg-blue-600 text-white shadow-sm'
                                : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}"
                        >

                            <x-icon name="dashboard" class="h-5 w-5" />

                        </span>

                        <span>
                            Dashboard
                        </span>

                    </a>

                </li>


                {{-- =================================================
                    DEVICES
                ================================================== --}}
                <li>

                    <a
                        href="{{ route('device') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('device*')
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >

                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-lg
                            {{ request()->routeIs('device*')
                                ? 'bg-blue-600 text-white shadow-sm'
                                : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}"
                        >

                            <x-icon name="laptop" class="h-5 w-5" />

                        </span>

                        <span>
                            Device
                        </span>

                    </a>

                </li>


                {{-- =================================================
                    INSIGHTS WITH SUBMENU
                ================================================== --}}
                <li>

                    @php
                        $insightsActive = request()->routeIs('analytics')
                            || request()->routeIs('monitoring*')
                            || request()->routeIs('reports*');
                    @endphp

                    <button
                        type="button"
                        class="group flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ $insightsActive
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        aria-controls="insights-submenu"
                        aria-expanded="{{ $insightsActive ? 'true' : 'false' }}"
                        data-collapse-toggle="insights-submenu"
                    >

                        <span
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                            {{ $insightsActive
                                ? 'bg-blue-600 text-white shadow-sm'
                                : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}"
                        >

                            <x-icon name="chart-vertical" class="h-5 w-5" />

                        </span>


                        <span class="flex-1 text-left">
                            Insights
                        </span>


                        <x-icon name="chevron-down" class="h-4 w-4 shrink-0 transition-transform duration-200 {{ $insightsActive ? 'rotate-180' : '' }}" />

                    </button>


                    <ul
                        id="insights-submenu"
                        class="mt-1 space-y-1 pl-6
                        {{ $insightsActive ? '' : 'hidden' }}"
                    >

                        {{-- OVERVIEW --}}
                        <li>

                            <a
                                href="{{ route('analytics') }}"
                                class="group flex items-center gap-3 rounded-xl py-2.5 pl-4 pr-3 text-sm font-medium transition
                                {{ request()->routeIs('analytics')
                                    ? 'bg-blue-50 text-blue-600'
                                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                            >

                                <span
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg
                                    {{ request()->routeIs('analytics')
                                        ? 'bg-blue-100 text-blue-600'
                                        : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100 group-hover:text-gray-600' }}"
                                >

                                    <x-icon name="chart-vertical" class="h-4 w-4" />

                                </span>


                                <span class="block truncate">
                                    Overview
                                </span>

                            </a>

                        </li>


                        {{-- EVENT LOGS --}}
                        <li>

                            <a
                                href="{{ route('monitoring') }}"
                                class="group flex items-center gap-3 rounded-xl py-2.5 pl-4 pr-3 text-sm font-medium transition
                                {{ request()->routeIs('monitoring*')
                                    ? 'bg-blue-50 text-blue-600'
                                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                            >

                                <span
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg
                                    {{ request()->routeIs('monitoring*')
                                        ? 'bg-blue-100 text-blue-600'
                                        : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100 group-hover:text-gray-600' }}"
                                >

                                    <x-icon name="chart" class="h-4 w-4" />

                                </span>


                                <span class="block truncate">
                                    Event Logs
                                </span>

                            </a>

                        </li>


                        {{-- REPORTS --}}
                        <li>

                            <a
                                href="{{ route('reports.index') }}"
                                class="group flex items-center gap-3 rounded-xl py-2.5 pl-4 pr-3 text-sm font-medium transition
                                {{ request()->routeIs('reports*')
                                    ? 'bg-blue-50 text-blue-600'
                                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}"
                            >

                                <span
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg
                                    {{ request()->routeIs('reports*')
                                        ? 'bg-blue-100 text-blue-600'
                                        : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100 group-hover:text-gray-600' }}"
                                >

                                    <x-icon name="file" class="h-4 w-4" />

                                </span>


                                <span class="block truncate">
                                    Reports
                                </span>

                            </a>

                        </li>

                    </ul>

                </li>


                {{-- =================================================
                    USERS
                ================================================== --}}
                @if(auth()->user()->isSuperAdmin())

                    <li>

                        <a
                            href="{{ route('user') }}"
                            class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                            {{ request()->routeIs('user.*')
                                ? 'bg-blue-50 text-blue-600'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        >

                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-lg
                                {{ request()->routeIs('user.*')
                                    ? 'bg-blue-600 text-white shadow-sm'
                                    : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}"
                            >

                                <x-icon name="users" class="h-5 w-5" />

                            </span>

                            <span>
                                Users
                            </span>

                        </a>

                    </li>

                @endif


                {{-- =================================================
                    SETTINGS
                ================================================== --}}
                @if(auth()->user()->isSuperAdmin())

                    <li>

                        <a
                            href="{{ route('settings.index') }}"
                            class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                            {{ request()->routeIs('settings.*')
                                ? 'bg-blue-50 text-blue-600'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        >

                            <span
                                class="flex h-9 w-9 items-center justify-center rounded-lg
                                {{ request()->routeIs('settings.*')
                                    ? 'bg-blue-600 text-white shadow-sm'
                                    : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}"
                            >

                                <x-icon name="settings" class="h-5 w-5" />

                            </span>


                            <span>
                                Settings
                            </span>

                        </a>

                    </li>

                @endif

            </ul>


            {{-- =====================================================
                SIDEBAR BOTTOM
            ====================================================== --}}
            <div class="mt-auto pt-5">

                <div class="mb-3 h-px bg-gray-100"></div>


                <div
                    class="rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 p-4"
                >

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white"
                        >

                            <x-icon name="information-circle" class="h-4 w-4" />

                        </div>


                        <div>

                            <p
                                class="text-xs font-semibold text-gray-800"
                            >
                                OLH Library
                            </p>


                            <p
                                class="mt-0.5 text-[11px] leading-4 text-gray-500"
                            >
                                Device and student activity management.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </aside>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <main
        class="min-h-screen bg-gray-50 pt-20 sm:ml-64"
    >

        <div class="p-4 sm:p-6 lg:p-8">

            @yield('content')

        </div>


        {{-- =====================================================
            GLOBAL MODALS
        ====================================================== --}}
        <x-success-modal />

        <x-toast-modal />

        <x-error-modal />

        <x-confirm-modal />

        <x-delete-modal />

    </main>


    @stack('modals')

    @stack('scripts')


    {{-- Flowbite --}}
    <script
        src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"
    ></script>

</body>

</html>
