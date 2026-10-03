
@extends('layout.app')

@section('title', 'User Details')

@section('content')

<div class="mx-auto max-w-5xl">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="mb-8">

        <div class="mb-3 flex items-center gap-2">

            <a
                href="{{ route('user') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 transition hover:text-gray-900"
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
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Users
            </a>

            <span class="text-gray-300">/</span>

            <span class="text-sm font-medium text-gray-400">
                User Details
            </span>

        </div>


        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="mb-2 flex items-center gap-2">

                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                        User Management
                    </span>

                </div>

                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                    User Details
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    View account information and access details.
                </p>

            </div>


            {{-- Header Actions --}}
            <div class="flex items-center gap-2">

                <a
                    href="{{ route('user') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-gray-900"
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Back

                </a>


                <a
                    href="{{ route('user.edit', $user->id) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
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
                            d="m16.5 3.5 4 4M4 20l3.5-.8L19.8 6.9a2.8 2.8 0 0 0-4-4L3.5 15.2 4 20Z"
                        />
                    </svg>

                    Edit User

                </a>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN GRID
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


        {{-- =====================================================
            PROFILE CARD
        ====================================================== --}}
        <div class="lg:col-span-1">

            <div
                class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm"
            >

                {{-- Cover --}}
                <div
                    class="h-32 bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700"
                ></div>


                <div class="px-6 pb-6">

                    {{-- Profile Picture --}}
                    <div class="-mt-14">

                        @if ($user->profile_picture)

                            <img
                                src="{{ asset('storage/' . $user->profile_picture) }}"
                                alt="{{ $user->name }}"
                                class="mx-auto h-28 w-28 rounded-3xl border-4 border-white object-cover shadow-lg"
                            >

                        @else

                            <div
                                class="mx-auto flex h-28 w-28 items-center justify-center rounded-3xl border-4 border-white bg-blue-50 text-3xl font-bold text-blue-600 shadow-lg"
                            >
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                        @endif

                    </div>


                    {{-- User Name --}}
                    <div class="mt-5 text-center">

                        <h2 class="truncate text-xl font-bold text-gray-900">
                            {{ $user->name }}
                        </h2>

                        <p class="mt-1 truncate text-sm text-gray-500">
                            {{ $user->email }}
                        </p>


                        {{-- Role --}}
                        @php
                            $role = strtolower($user->role ?? 'user');

                            $roleClasses = match ($role) {
                                'admin' => 'bg-purple-50 text-purple-600',
                                'librarian' => 'bg-emerald-50 text-emerald-600',
                                default => 'bg-blue-50 text-blue-600',
                            };
                        @endphp

                        <div class="mt-4">

                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $roleClasses }}"
                            >

                                <span
                                    class="h-1.5 w-1.5 rounded-full
                                    {{ $role === 'admin'
                                        ? 'bg-purple-500'
                                        : ($role === 'librarian'
                                            ? 'bg-emerald-500'
                                            : 'bg-blue-500') }}"
                                ></span>

                                {{ ucfirst($role) }}

                            </span>

                        </div>

                    </div>


                    {{-- Divider --}}
                    <div class="my-6 border-t border-gray-100"></div>


                    {{-- Account Status --}}
                    <div
                        class="flex items-center justify-between rounded-2xl bg-emerald-50 px-4 py-3"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"
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
                                        d="M5 12.5 9.5 17 19 7.5"
                                    />
                                </svg>

                            </div>

                            <div>

                                <p class="text-xs font-medium text-emerald-700">
                                    Account Status
                                </p>

                                <p class="text-sm font-bold text-emerald-800">
                                    Active
                                </p>

                            </div>

                        </div>

                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                    </div>


                    {{-- Member Since --}}
                    <div class="mt-4 flex items-center justify-between">

                        <span class="text-xs font-medium text-gray-400">
                            Member since
                        </span>

                        <span class="text-xs font-semibold text-gray-700">
                            {{ $user->created_at?->format('M d, Y') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            RIGHT CONTENT
        ====================================================== --}}
        <div class="space-y-6 lg:col-span-2">


            {{-- =================================================
                ACCOUNT INFORMATION
            ================================================== --}}
            <div
                class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm"
            >

                <div class="border-b border-gray-100 px-6 py-5 sm:px-7">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
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
                                    d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                />

                                <circle
                                    cx="9"
                                    cy="7"
                                    r="4"
                                    stroke-width="1.8"
                                />
                            </svg>

                        </div>

                        <div>

                            <h2 class="text-base font-bold text-gray-900">
                                Account Information
                            </h2>

                            <p class="mt-0.5 text-xs text-gray-500">
                                Basic information associated with this account.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2 sm:p-7">


                    {{-- Full Name --}}
                    <div
                        class="rounded-2xl border border-gray-100 bg-gray-50 p-4"
                    >

                        <div class="mb-3 flex items-center gap-2">

                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                />

                                <circle
                                    cx="9"
                                    cy="7"
                                    r="4"
                                    stroke-width="1.8"
                                />
                            </svg>

                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Full Name
                            </span>

                        </div>

                        <p class="break-words text-sm font-semibold text-gray-900">
                            {{ $user->name }}
                        </p>

                    </div>


                    {{-- Email --}}
                    <div
                        class="rounded-2xl border border-gray-100 bg-gray-50 p-4"
                    >

                        <div class="mb-3 flex items-center gap-2">

                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M4 6h16v12H4z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="m4 7 8 6 8-6"
                                />
                            </svg>

                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Email Address
                            </span>

                        </div>

                        <p class="break-all text-sm font-semibold text-gray-900">
                            {{ $user->email }}
                        </p>

                    </div>


                    {{-- Role --}}
                    <div
                        class="rounded-2xl border border-gray-100 bg-gray-50 p-4"
                    >

                        <div class="mb-3 flex items-center gap-2">

                            <svg
                                class="h-4 w-4 text-gray-400"
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
                                    d="M9.5 12 11 13.5l3.5-3.5"
                                />
                            </svg>

                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Role
                            </span>

                        </div>

                        <p class="text-sm font-semibold text-gray-900">
                            {{ ucfirst($role) }}
                        </p>

                    </div>


                    {{-- User ID --}}
                    <div
                        class="rounded-2xl border border-gray-100 bg-gray-50 p-4"
                    >

                        <div class="mb-3 flex items-center gap-2">

                            <svg
                                class="h-4 w-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m-9 4h10M6 7h12a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z"
                                />
                            </svg>

                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                User ID
                            </span>

                        </div>

                        <p class="text-sm font-semibold text-gray-900">
                            #{{ $user->id }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                ACCOUNT TIMELINE
            ================================================== --}}
            <div
                class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm"
            >

                <div class="border-b border-gray-100 px-6 py-5 sm:px-7">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600"
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
                                    d="M12 8v4l2.5 2.5"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke-width="1.8"
                                />
                            </svg>

                        </div>

                        <div>

                            <h2 class="text-base font-bold text-gray-900">
                                Account Timeline
                            </h2>

                            <p class="mt-0.5 text-xs text-gray-500">
                                Important dates related to this account.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="p-6 sm:p-7">

                    <div class="space-y-6">


                        {{-- Created --}}
                        <div class="flex gap-4">

                            <div class="flex flex-col items-center">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600"
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
                                            d="M12 6v6l4 2"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                            stroke-width="1.8"
                                        />
                                    </svg>

                                </div>

                            </div>


                            <div class="pt-1">

                                <p class="text-sm font-semibold text-gray-900">
                                    Account Created
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $user->created_at?->format('F d, Y \a\t h:i A') }}
                                </p>

                            </div>

                        </div>


                        {{-- Updated --}}
                        <div class="flex gap-4">

                            <div class="flex flex-col items-center">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-purple-50 text-purple-600"
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
                                            d="m16.5 3.5 4 4M4 20l3.5-.8L19.8 6.9a2.8 2.8 0 0 0-4-4L3.5 15.2 4 20Z"
                                        />
                                    </svg>

                                </div>

                            </div>


                            <div class="pt-1">

                                <p class="text-sm font-semibold text-gray-900">
                                    Last Updated
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $user->updated_at?->format('F d, Y \a\t h:i A') }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                SECURITY / ROLE CARD
            ================================================== --}}
            <div
                class="rounded-3xl border border-blue-100 bg-blue-50 p-5 sm:p-6"
            >

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600"
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
                                d="M12 3 5 6v5c0 4.7 2.9 8.6 7 10 4.1-1.4 7-5.3 7-10V6l-7-3Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9.5 12 11 13.5l3.5-3.5"
                            />
                        </svg>

                    </div>


                    <div>

                        <h3 class="text-sm font-bold text-blue-900">
                            Access & Permissions
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-blue-700">
                            This account is assigned the
                            <span class="font-bold">
                                {{ ucfirst($role) }}
                            </span>
                            role. The assigned role determines which parts
                            of the system the user can access.
                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                ACTIONS
            ================================================== --}}
            <div
                class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
            >

                <a
                    href="{{ route('user') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-gray-900"
                >
                    Back to Users
                </a>


                <a
                    href="{{ route('user.edit', $user->id) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
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
                            d="m16.5 3.5 4 4M4 20l3.5-.8L19.8 6.9a2.8 2.8 0 0 0-4-4L3.5 15.2 4 20Z"
                        />
                    </svg>

                    Edit User

                </a>

            </div>

        </div>

    </div>

</div>

@endsection

