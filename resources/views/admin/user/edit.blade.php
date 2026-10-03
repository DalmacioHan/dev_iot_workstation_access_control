
@extends('layout.app')

@section('title', 'Edit User')

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
                Edit User
            </span>

        </div>


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
                Edit User
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Update the account information, role, and security settings for this user.
            </p>

        </div>

    </div>


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}
    @if ($errors->any())

        <div
            class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4"
            role="alert"
        >

            <div class="flex items-start gap-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600"
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
                            d="M12 8v4m0 4h.01M10.3 3.7 2.9 17a2 2 0 0 0 1.7 3h14.8a2 2 0 0 0 1.7-3L13.7 3.7a2 2 0 0 0-3.4 0Z"
                        />
                    </svg>
                </div>

                <div>

                    <p class="text-sm font-semibold text-red-800">
                        Please check the following:
                    </p>

                    <ul class="mt-2 space-y-1 text-sm text-red-700">

                        @foreach ($errors->all() as $error)

                            <li class="flex items-start gap-2">
                                <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-red-500"></span>
                                <span>{{ $error }}</span>
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        EDIT USER FORM
    ========================================================== --}}
    <form
        action="{{ route('user.update', $user->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')


        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- =================================================
                LEFT PROFILE CARD
            ================================================== --}}
            <div class="lg:col-span-1">

                <div
                    class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm"
                >

                    {{-- Cover --}}
                    <div
                        class="h-28 bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700"
                    ></div>


                    <div class="px-6 pb-6">

                        {{-- Profile Picture --}}
                        <div class="-mt-12">

                            <div class="relative mx-auto h-24 w-24">

                                @if ($user->profile_picture)

                                    <img
                                        id="profilePreview"
                                        src="{{ asset('storage/' . $user->profile_picture) }}"
                                        alt="{{ $user->name }}"
                                        class="h-24 w-24 rounded-2xl border-4 border-white object-cover shadow-md"
                                    >

                                @else

                                    <div
                                        id="profileInitial"
                                        class="flex h-24 w-24 items-center justify-center rounded-2xl border-4 border-white bg-blue-50 text-2xl font-bold text-blue-600 shadow-md"
                                    >
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <img
                                        id="profilePreview"
                                        src=""
                                        alt="Profile preview"
                                        class="hidden h-24 w-24 rounded-2xl border-4 border-white object-cover shadow-md"
                                    >

                                @endif


                                <label
                                    for="profile_picture"
                                    class="absolute -bottom-2 -right-2 flex h-9 w-9 cursor-pointer items-center justify-center rounded-xl border-2 border-white bg-blue-600 text-white shadow-sm transition hover:bg-blue-700"
                                    title="Change profile picture"
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
                                            d="M4 16l4.5-4.5a2 2 0 0 1 2.8 0L16 16m-2-2 1.5-1.5a2 2 0 0 1 2.8 0L20 14M14 7h.01M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-4l-1-2H10L9 6H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"
                                        />
                                    </svg>

                                </label>

                            </div>

                        </div>


                        {{-- User Summary --}}
                        <div class="mt-5 text-center">

                            <h2
                                id="profileName"
                                class="truncate text-lg font-bold text-gray-900"
                            >
                                {{ $user->name }}
                            </h2>

                            <p
                                id="profileEmail"
                                class="mt-1 truncate text-sm text-gray-500"
                            >
                                {{ $user->email }}
                            </p>


                            {{-- Current Role Badge --}}
                            <div class="mt-3">

                                <span
                                    id="profileRoleBadge"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600"
                                >

                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>

                                    {{ ucfirst($user->role ?? 'User') }}

                                </span>

                            </div>

                        </div>


                        {{-- Account Information --}}
                        <div class="mt-6 border-t border-gray-100 pt-5">

                            <div class="flex items-center justify-between">

                                <span class="text-xs font-medium text-gray-400">
                                    Member since
                                </span>

                                <span class="text-xs font-semibold text-gray-700">
                                    {{ $user->created_at?->format('M d, Y') }}
                                </span>

                            </div>

                        </div>


                        {{-- Profile Picture Upload --}}
                        <div class="mt-5">

                            <input
                                id="profile_picture"
                                name="profile_picture"
                                type="file"
                                accept="image/*"
                                class="hidden"
                            >

                            <label
                                for="profile_picture"
                                class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
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
                                        d="M12 16V4m0 0L7 9m5-5 5 5M5 20h14"
                                    />
                                </svg>

                                Change Profile Picture

                            </label>

                            <p class="mt-2 text-center text-[11px] text-gray-400">
                                JPG, PNG or WEBP · Maximum 2MB
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Security Notice --}}
                <div
                    class="mt-6 rounded-2xl border border-blue-100 bg-blue-50 p-5"
                >

                    <div class="flex items-start gap-3">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600"
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

                            <p class="text-sm font-semibold text-blue-900">
                                Account Security
                            </p>

                            <p class="mt-1 text-xs leading-5 text-blue-700">
                                Leave the password fields empty if you don't
                                want to change the user's current password.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                RIGHT SIDE
            ================================================== --}}
            <div class="space-y-6 lg:col-span-2">


                {{-- =================================================
                    PERSONAL INFORMATION
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
                                    Personal Information
                                </h2>

                                <p class="mt-0.5 text-xs text-gray-500">
                                    Update the user's basic account details.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="space-y-5 p-6 sm:p-7">

                        {{-- Name --}}
                        <div>

                            <label
                                for="name"
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                Full Name
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">

                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
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

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    autocomplete="name"
                                    oninput="updateProfileName(this.value)"
                                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50 @error('name') border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-50 @enderror"
                                    placeholder="Enter full name"
                                >

                            </div>

                            @error('name')
                                <p class="mt-1.5 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                Email Address
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">

                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
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
                                            d="M4 6h16v12H4z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="m4 7 8 6 8-6"
                                        />
                                    </svg>

                                </div>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    autocomplete="email"
                                    oninput="updateProfileEmail(this.value)"
                                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50 @error('email') border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-50 @enderror"
                                    placeholder="name@example.com"
                                >

                            </div>

                            @error('email')
                                <p class="mt-1.5 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- =================================================
                            USER ROLE
                        ================================================== --}}
                        <div>
                            <label
                                for="role"
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                User Role
                                <span class="text-red-500">*</span>
                            </label>

                            <div class="relative">
                                {{-- Shield Icon --}}
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-4"
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

                                {{-- Role Select --}}
                                <select
                                    id="role"
                                    name="role"
                                    required
                                    onchange="updateRoleBadge(this.value)"
                                    class="block w-full appearance-none rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-11 pr-10 text-sm font-medium text-gray-900 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50 @error('role') border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-50 @enderror [webkit-appearance:none] [moz-appearance:none]"
                                >
                                    <option
                                        value="super admin"
                                        {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                                    >
                                        Super Admin
                                    </option>

                                    <option
                                        value="admin"
                                        {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                                        
                                    >
                                        Admin
                                    </option>


                                </select>
                            </div>

                            <p class="mt-2 text-xs text-gray-400">
                                The role determines what parts of the system this user can access.
                            </p>

                            @error('role')
                                <p class="mt-1.5 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>



                    </div>

                </div>


                {{-- =================================================
                    PASSWORD SECTION
                ================================================== --}}
                <div
                    class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm"
                >

                    <div class="border-b border-gray-100 px-6 py-5 sm:px-7">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600"
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
                                        d="M15 11V8a3 3 0 1 0-6 0v3"
                                    />

                                    <rect
                                        x="5"
                                        y="11"
                                        width="14"
                                        height="10"
                                        rx="2"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 15v2"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h2 class="text-base font-bold text-gray-900">
                                    Change Password
                                </h2>

                                <p class="mt-0.5 text-xs text-gray-500">
                                    Optional. Leave blank to keep the current password.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="space-y-5 bg-gray-50/50 px-6 py-6 sm:px-7">

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            {{-- Password --}}
                            <div>

                                <label
                                    for="password"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    New Password
                                </label>

                                <div class="relative">

                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="new-password"
                                        class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 pr-11 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50 @error('password') border-red-300 focus:border-red-500 focus:ring-red-50 @enderror"
                                        placeholder="Enter new password"
                                    >

                                    <button
                                        type="button"
                                        onclick="togglePassword('password', 'passwordIcon')"
                                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-gray-600"
                                    >

                                        <svg
                                            id="passwordIcon"
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="3"
                                                stroke-width="1.8"
                                            />
                                        </svg>

                                    </button>

                                </div>

                                @error('password')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Confirm --}}
                            <div>

                                <label
                                    for="password_confirmation"
                                    class="mb-2 block text-sm font-semibold text-gray-700"
                                >
                                    Confirm New Password
                                </label>

                                <div class="relative">

                                    <input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        autocomplete="new-password"
                                        class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 pr-11 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50"
                                        placeholder="Confirm new password"
                                    >

                                    <button
                                        type="button"
                                        onclick="togglePassword('password_confirmation', 'confirmPasswordIcon')"
                                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-gray-600"
                                    >

                                        <svg
                                            id="confirmPasswordIcon"
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="3"
                                                stroke-width="1.8"
                                            />
                                        </svg>

                                    </button>

                                </div>

                            </div>

                        </div>


                        {{-- Password Requirements --}}
                        <div
                            class="rounded-xl border border-gray-200 bg-white p-4"
                        >

                            <p class="text-xs font-semibold text-gray-700">
                                Password requirements
                            </p>

                            <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">

                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300"></span>
                                    At least 8 characters
                                </div>

                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-300"></span>
                                    Mix letters and numbers
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    FORM ACTIONS
                ================================================== --}}
                <div
                    class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
                >

                    <a
                        href="{{ route('user') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-100"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
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
                                d="M5 12.5 9.5 17 19 7.5"
                            />
                        </svg>

                        Save Changes

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- =========================================================
    PAGE JAVASCRIPT
========================================================= --}}
<script>

    /*
    |--------------------------------------------------------------------------
    | Profile Picture Preview
    |--------------------------------------------------------------------------
    */
    document.getElementById('profile_picture')?.addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (!file) {
            return;
        }

        const preview = document.getElementById('profilePreview');
        const initial = document.getElementById('profileInitial');

        if (preview) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }

        if (initial) {
            initial.classList.add('hidden');
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Profile Name Preview
    |--------------------------------------------------------------------------
    */
    function updateProfileName(value) {

        const name = value.trim();

        const profileName = document.getElementById('profileName');

        if (profileName) {
            profileName.textContent = name || 'User Name';
        }

        const initial = document.getElementById('profileInitial');

        if (initial && name) {
            initial.textContent = name.charAt(0).toUpperCase();
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Profile Email Preview
    |--------------------------------------------------------------------------
    */
    function updateProfileEmail(value) {

        const profileEmail = document.getElementById('profileEmail');

        if (profileEmail) {
            profileEmail.textContent = value || 'user@example.com';
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Update Role Badge
    |--------------------------------------------------------------------------
    */
    function updateRoleBadge(value) {

        const badge = document.getElementById('profileRoleBadge');

        if (!badge) {
            return;
        }

        const role = value
            ? value.charAt(0).toUpperCase() + value.slice(1)
            : 'User';

        badge.innerHTML = `
            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
            ${role}
        `;

        /*
        |--------------------------------------------------------------------------
        | Badge Colors
        |--------------------------------------------------------------------------
        */
        badge.classList.remove(
            'bg-blue-50',
            'text-blue-600',
            'bg-purple-50',
            'text-purple-600',
            'bg-emerald-50',
            'text-emerald-600'
        );

        if (value === 'admin') {

            badge.classList.add(
                'bg-purple-50',
                'text-purple-600'
            );

        } else if (value === 'librarian') {

            badge.classList.add(
                'bg-emerald-50',
                'text-emerald-600'
            );

        } else {

            badge.classList.add(
                'bg-blue-50',
                'text-blue-600'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Password
    |--------------------------------------------------------------------------
    */
    function togglePassword(inputId, iconId) {

        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (!input) {
            return;
        }

        if (input.type === 'password') {

            input.type = 'text';

            if (icon) {
                icon.innerHTML = `
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M3 3l18 18"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M10.6 10.6a2 2 0 0 0 2.8 2.8"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M9.9 4.2A10.8 10.8 0 0 1 12 4c6.5 0 10 8 10 8a18.5 18.5 0 0 1-3.1 4.2M6.6 6.6C3.5 8.7 2 12 2 12s3.5 8 10 8c1.7 0 3.2-.4 4.5-1"
                    />
                `;
            }

        } else {

            input.type = 'password';

            if (icon) {
                icon.innerHTML = `
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                        stroke-width="1.8"
                    />
                `;
            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Initialize Role Badge
    |--------------------------------------------------------------------------
    */
    document.addEventListener('DOMContentLoaded', function () {

        const roleSelect = document.getElementById('role');

        if (roleSelect) {
            updateRoleBadge(roleSelect.value);
        }

    });

</script>

@endsection

