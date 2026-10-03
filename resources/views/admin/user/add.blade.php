
@extends('layout.app')

@section('title', 'Add User')

@section('content')

<div class="mx-auto max-w-6xl">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

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
                Add User
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Create a new user account for the OLH Library system.
            </p>
        </div>

        <a
            href="{{ route('dashboard') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-100"
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
                    d="M19 12H5m7 7-7-7 7-7"
                />
            </svg>

            Back
        </a>

    </div>


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
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 9v4m0 4h.01M10.3 3.8 2.7 17a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z"
                        />
                    </svg>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-red-800">
                        Please check the form
                    </h3>

                    <ul class="mt-1 list-inside list-disc text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    @endif


    {{-- =========================================================
        MAIN BENTO GRID
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

        {{-- =====================================================
            LEFT INFORMATION CARD
        ====================================================== --}}
        <div class="lg:col-span-2">

            <div
                class="relative h-full overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 p-6 text-white shadow-lg shadow-blue-100 sm:p-8"
            >

                {{-- Decorative shapes --}}
                <div
                    class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-white/10"
                ></div>

                <div
                    class="absolute -bottom-20 -left-16 h-48 w-48 rounded-full bg-white/5"
                ></div>


                <div class="relative">

                    {{-- Icon --}}
                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur"
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
                                d="M15 19a4 4 0 0 0-8 0"
                            />

                            <circle
                                cx="11"
                                cy="7"
                                r="4"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M19 8v6M22 11h-6"
                            />
                        </svg>
                    </div>


                    <h2 class="text-2xl font-bold tracking-tight">
                        Create a new user
                    </h2>

                    <p class="mt-3 max-w-sm text-sm leading-6 text-blue-100">
                        Add a user to the OLH Library Management System.
                        Their account can be used to access the system
                        according to the permissions assigned to them.
                    </p>


                    {{-- Steps --}}
                    <div class="mt-8 space-y-5">

                        {{-- Step 1 --}}
                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-sm font-bold text-blue-600"
                            >
                                1
                            </div>

                            <div>
                                <p class="text-sm font-semibold">
                                    Enter user information
                                </p>

                                <p class="mt-0.5 text-xs leading-5 text-blue-100">
                                    Provide the user's name and email address.
                                </p>
                            </div>

                        </div>


                        {{-- Step 2 --}}
                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/15 text-sm font-bold ring-1 ring-white/20"
                            >
                                2
                            </div>

                            <div>
                                <p class="text-sm font-semibold">
                                    Set a password
                                </p>

                                <p class="mt-0.5 text-xs leading-5 text-blue-100">
                                    Create a secure password for the account.
                                </p>
                            </div>

                        </div>


                        {{-- Step 3 --}}
                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/15 text-sm font-bold ring-1 ring-white/20"
                            >
                                3
                            </div>

                            <div>
                                <p class="text-sm font-semibold">
                                    Create account
                                </p>

                                <p class="mt-0.5 text-xs leading-5 text-blue-100">
                                    Save the account and make it available.
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- Security notice --}}
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
                                    Keep account credentials secure
                                </p>

                                <p class="mt-1 text-[11px] leading-4 text-blue-100">
                                    Never share passwords or account credentials
                                    with unauthorized users.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            RIGHT FORM CARD
        ====================================================== --}}
        <div class="lg:col-span-3">

            <div
                class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8"
            >

                {{-- Card Header --}}
                <div class="mb-7 flex items-center gap-4">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
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
                                d="M15 19a4 4 0 0 0-8 0"
                            />

                            <circle
                                cx="11"
                                cy="7"
                                r="4"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M19 8v6M22 11h-6"
                            />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            User Information
                        </h2>

                        <p class="text-sm text-gray-500">
                            Enter the details for the new account.
                        </p>
                    </div>

                </div>


                {{-- FORM --}}
                <form
                    action="{{ route('user.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >

                    @csrf


                    {{-- Profile Picture --}}
                    <div>

                        <label
                            for="profile_picture"
                            class="mb-2 block text-sm font-semibold text-gray-900"
                        >
                            Profile Picture
                            <span class="font-normal text-gray-400">
                                (Optional)
                            </span>
                        </label>

                        <div class="flex items-center gap-4">

                            <div
                                id="avatar-preview"
                                class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gray-100 text-gray-400 ring-1 ring-gray-200"
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
                                        d="M15 19a4 4 0 0 0-8 0"
                                    />

                                    <circle
                                        cx="11"
                                        cy="7"
                                        r="4"
                                        stroke-width="1.8"
                                    />
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">

                                <input
                                    type="file"
                                    id="profile_picture"
                                    name="profile_picture"
                                    accept="image/png,image/jpeg,image/jpg,image/webp"
                                    class="block w-full cursor-pointer rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-blue-600 hover:file:bg-blue-100 focus:outline-none"
                                >

                                <p class="mt-1.5 text-xs text-gray-400">
                                    PNG, JPG or WEBP. Recommended square image.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Name --}}
                    <div>

                        <label
                            for="name"
                            class="mb-2 block text-sm font-semibold text-gray-900"
                        >
                            Full Name
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
                                        d="M15 19a4 4 0 0 0-8 0"
                                    />

                                    <circle
                                        cx="11"
                                        cy="7"
                                        r="4"
                                        stroke-width="1.8"
                                    />
                                </svg>
                            </div>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                                placeholder="Enter full name"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
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
                            class="mb-2 block text-sm font-semibold text-gray-900"
                        >
                            Email Address
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
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                placeholder="user@example.com"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                            >

                        </div>

                        @error('email')
                            <p class="mt-1.5 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Password Grid --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Password --}}
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-semibold text-gray-900"
                            >
                                Password
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
                                            d="M7 10V7a5 5 0 0 1 10 0v3"
                                        />

                                        <rect
                                            x="4"
                                            y="10"
                                            width="16"
                                            height="11"
                                            rx="2"
                                            stroke-width="1.8"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.8"
                                            d="M12 15v2"
                                        />
                                    </svg>
                                </div>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                                >

                            </div>

                            @error('password')
                                <p class="mt-1.5 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Confirm Password --}}
                        <div>

                            <label
                                for="password_confirmation"
                                class="mb-2 block text-sm font-semibold text-gray-900"
                            >
                                Confirm Password
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
                                            d="M7 10V7a5 5 0 0 1 10 0v3"
                                        />

                                        <rect
                                            x="4"
                                            y="10"
                                            width="16"
                                            height="11"
                                            rx="2"
                                            stroke-width="1.8"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.8"
                                            d="m9 16 2 2 4-4"
                                        />
                                    </svg>
                                </div>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-50"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- Password Requirements --}}
                    <div
                        class="rounded-2xl border border-gray-100 bg-gray-50 p-4"
                    >

                        <div class="flex gap-3">

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-blue-600 shadow-sm ring-1 ring-gray-100"
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
                                </svg>
                            </div>

                            <div>

                                <p class="text-xs font-semibold text-gray-800">
                                    Password security
                                </p>

                                <p class="mt-1 text-xs leading-5 text-gray-500">
                                    Use a strong password with a combination of
                                    uppercase letters, lowercase letters,
                                    numbers, and symbols.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div
                        class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end"
                    >

                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-100"
                        >
                            Cancel
                        </a>

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
                                    d="M12 5v14M5 12h14"
                                />
                            </svg>

                            Create User
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    PROFILE IMAGE PREVIEW
========================================================== --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const input = document.getElementById('profile_picture');
        const preview = document.getElementById('avatar-preview');

        if (!input || !preview) return;

        input.addEventListener('change', function (event) {

            const file = event.target.files[0];

            if (!file) return;

            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();

            reader.onload = function (e) {

                preview.innerHTML = `
                    <img
                        src="${e.target.result}"
                        alt="Profile preview"
                        class="h-full w-full object-cover"
                    >
                `;

            };

            reader.readAsDataURL(file);

        });

    });
</script>
@endpush

@endsection
```
