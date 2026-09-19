
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Dashboard') | OLH</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Flowbite --}}
    <link
        href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css"
        rel="stylesheet"
    />

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

                <div class="flex items-center">

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
                        <svg
                            class="h-5 w-5"
                            aria-hidden="true"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>



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
                            <p class="text-base font-bold tracking-tight text-gray-900">
                                OLH
                            </p>

                            <p class="text-[11px] font-medium text-gray-400">
                                Library Management
                            </p>
                        </div>

                    </a>

                </div>


                {{-- RIGHT SIDE --}}
                <div class="flex items-center gap-3">

                    
                    {{-- Divider --}}
                    <div class="hidden h-8 w-px bg-gray-200 sm:block"></div>

                    {{-- USER MENU --}}
                    <div class="relative">
                        <button
                            type="button"
                            class="flex items-center gap-3 rounded-xl p-1.5 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            aria-expanded="false"
                            data-dropdown-toggle="dropdown-user"
                        >
                            {{-- Avatar --}}
                            <img
                                class="h-9 w-9 rounded-xl object-cover ring-2 ring-gray-100"
                                src="{{ Auth::user()->profile_picture
                                    ? asset('storage/' . Auth::user()->profile_picture)
                                    : asset('image/default_user.png') }}"
                                alt="{{ Auth::user()->name }}"
                            >
                            {{-- User information --}}
                            <div class="hidden text-left md:block">

                                <p class="max-w-[140px] truncate text-sm font-semibold text-gray-900">
                                    {{ Auth::user()->name }}
                                </p>

                                <p class="max-w-[140px] truncate text-xs text-gray-400">
                                    {{ Auth::user()->email }}
                                </p>

                            </div>

                            {{-- Chevron --}}
                            <svg
                                class="hidden h-4 w-4 text-gray-400 md:block"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m6 9 6 6 6-6"
                                />
                            </svg>

                        </button>


                        {{-- DROPDOWN --}}
                        <div
                            id="dropdown-user"
                            class="z-50 hidden w-64 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xl"
                        >

                            {{-- User header --}}
                            <div class="border-b border-gray-100 bg-gray-50/70 px-4 py-4">

                                <div class="flex items-center gap-3">

                                    <img
                                        class="h-10 w-10 rounded-xl object-cover"
                                        src="{{ Auth::user()->profile_picture
                                            ? asset('storage/' . Auth::user()->profile_picture)
                                            : asset('image/default_user.png') }}"
                                        alt="{{ Auth::user()->name }}"
                                    >

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-gray-900">
                                            {{ Auth::user()->name }}
                                        </p>

                                        <p class="truncate text-xs text-gray-500">
                                            {{ Auth::user()->email }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Menu --}}
                            <ul class="p-2 text-sm text-gray-700">

                                <li>
                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-blue-50 hover:text-blue-600"
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
                                                d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"
                                            />
                                        </svg>

                                        Dashboard
                                    </a>
                                </li>


                                <li>
                                    <a
                                        href="{{ route('account') }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-blue-50 hover:text-blue-600"
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
                                                d="M15 19a4 4 0 0 0-8 0M11 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7-3v6m3-3h-6"
                                            />
                                        </svg>

                                        Manage Account
                                    </a>
                                </li>


                                <li>
                                    <a
                                        href="{{ route('logout') }}"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-red-600 transition hover:bg-red-50"
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
                                                d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5m5 5H3"
                                            />
                                        </svg>

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

        <div class="flex h-full flex-col px-4 pb-5">

            {{-- Sidebar heading --}}
            <div class="mb-5 px-2">

                <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-400">
                    Main Menu
                </p>

            </div>


            {{-- NAVIGATION --}}
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
                                    d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"
                                />
                            </svg>

                        </span>

                        <span>
                            Dashboard
                        </span>

                    </a>

                </li>


                {{-- =================================================
                    ANALYTICS
                ================================================== --}}
                <li>

                    <a
                        href="{{ route('analytics') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('analytics')
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >

                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-lg
                            {{ request()->routeIs('analytics')
                                ? 'bg-blue-600 text-white shadow-sm'
                                : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}"
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
                                    d="M4 19V5m0 14h16M8 16v-5m4 5V7m4 9V4"
                                />
                            </svg>

                        </span>

                        <span>
                            Analytics
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

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="4"
                                    y="4"
                                    width="16"
                                    height="16"
                                    rx="2"
                                    stroke-width="1.8"
                                />

                                <rect
                                    x="9"
                                    y="9"
                                    width="6"
                                    height="6"
                                    stroke-width="1.8"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.8"
                                    d="M15 2v2M9 2v2M15 20v2M9 20v2M20 15h2M20 9h2M2 15h2M2 9h2"
                                />
                            </svg>

                        </span>

                        <span>
                            Device
                        </span>

                    </a>

                </li>


                {{-- =================================================
                    REPORTS
                ================================================== --}}
                <li>

                    <a
                        href="{{ route('reports') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
                        {{ request()->routeIs('reports*')
                            ? 'bg-blue-50 text-blue-600'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >

                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-lg
                            {{ request()->routeIs('reports*')
                                ? 'bg-blue-600 text-white shadow-sm'
                                : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}"
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
                                    d="M6 2h9l5 5v15H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M14 2v6h6M8 13h8M8 17h6M8 9h2"
                                />
                            </svg>

                        </span>

                        <span>
                            Reports
                        </span>

                    </a>

                </li>

            </ul>


            {{-- =====================================================
                SIDEBAR BOTTOM
            ====================================================== --}}
            <div class="mt-auto">

                <div class="mb-3 h-px bg-gray-100"></div>

                <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 p-4">

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-gray-800">
                                OLH Library
                            </p>

                            <p class="mt-0.5 text-[11px] leading-4 text-gray-500">
                                Device and student activity management.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </aside>



    <main class="min-h-screen bg-gray-50 pt-20 sm:ml-64">

        <div class="p-4 sm:p-6 lg:p-8">

            @yield('content')

        </div>


        {{-- GLOBAL MODALS --}}
        <x-success-modal />
        <x-toast-modal />
        <x-error-modal />
        <x-confirm-modal />
        <x-delete-modal />

    </main>

    @stack('modals')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>



</body>

</html>
