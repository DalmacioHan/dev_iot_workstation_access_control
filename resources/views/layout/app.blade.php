<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body>

<!-- TOP NAVBAR - Always visible -->
<nav class="fixed top-0 z-50 w-full bg-neutral-primary-soft border-b border-default">
<div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
        <!-- HAMBURGER BUTTON - Only visible on mobile -->
        <button
            data-drawer-target="logo-sidebar"
            data-drawer-toggle="logo-sidebar"
            aria-controls="logo-sidebar"
            type="button"
            class="inline-flex items-center p-2 text-sm text-heading rounded-lg sm:hidden hover:bg-neutral-secondary-medium focus:outline-none focus:ring-2 focus:ring-neutral-tertiary">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>

        <!-- LOGO - Always visible in navbar -->
        <a href="{{route('dashboard')}}" class="flex ms-2 md:me-24">
        <img src="{{ asset('image/library_logo.jpg') }}" class="h-8 w-8 me-3 rounded-full object-cover" alt="OLH Logo" />
        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">OLH</span>
        </a>
        </div>

        <!-- USER MENU -->
        <div class="flex items-center">
        <div class="flex items-center ms-3">
            <div>
            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full object-cover"
                    src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('image/default_user.png') }}"
                    alt="user photo">
            </button>
            </div>
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" id="dropdown-user">
            <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900" role="none">{{ Auth::user()->name }}</p>
                <p class="text-sm font-medium text-gray-900 truncate" role="none">{{ Auth::user()->email }}</p>
            </div>
            <ul class="py-1" role="none">
                <li><a href="{{route('dashboard')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a></li>
                <li><a href="{{route('account')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Manage Account</a></li>
                <li><a href="{{route('logout')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a></li>
            </ul>
            </div>
        </div>
        </div>
    </div>
</div>
</nav>

<!-- SIDEBAR - Hidden on mobile, slides in when toggled -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0" aria-label="Sidebar">
<div class="h-full px-3 pb-4 overflow-y-auto bg-neutral-primary-soft">
    <ul class="space-y-2">
        <li>
        <a href="{{route('dashboard')}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
            <!-- Dashboard icon (stroke, blue on hover) -->
            <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <span class="ms-3">Dashboard</span>
        </a>
        </li>
        <li>
        <a href="{{route('analytics')}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
            <!-- Analytics icon (stroke, blue on hover) -->
            <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 21" stroke="currentColor">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M7.24 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Analytics</span>
        </a>
        </li>
        <li>
        <a href="{{route('workstation')}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
            <!-- Workstation icon (stroke, blue on hover) -->
            <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9M9 7h6m-7 3h8"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">WorkStation</span>
        </a>
        </li>
        <li>
        <a href="{{route('device')}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
            <!-- Device icon (stroke, blue on hover) -->
            <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="4" y="4" width="16" height="16" rx="2" />
                <rect x="9" y="9" width="6" height="6" />
                <path d="M15 2v2M9 2v2M15 20v2M9 20v2M20 15h2M20 9h2M2 15h2M2 9h2" />
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Device</span>
        </a>
        </li>
        <li>
        <a href="{{route('reports')}}" class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M18 2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2ZM2 18V7h6.7l.4-.409A4.309 4.309 0 0 1 15.753 7H18v11H2Z"/>
            <path d="M8.139 10.411 5.289 13.3A1 1 0 0 0 5 14v2a1 1 0 0 0 1 1h2a1 1 0 0 0 .7-.288l2.886-2.851-3.447-3.45ZM14 8a2.463 2.463 0 0 0-3.484 0l-.971.983 3.468 3.468.987-.971A2.463 2.463 0 0 0 14 8Z"/>
            </svg>
            <span class="flex-1 ms-3 whitespace-nowrap">Reports</span>
        </a>
        </li>
    </ul>
</div>
</aside>

<!-- MAIN CONTENT -->
<div class="p-4 sm:ml-64 mt-14">
@yield('content')
<x-success-modal />
<x-toast-modal />
<x-error-modal />
<x-confirm-modal />
</div>
@stack('modals')
<!-- FLOWBITE JS -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
</body>
</html>
