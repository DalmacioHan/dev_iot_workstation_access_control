@extends('layout.app')

@section('title', 'Account')

@section('content')

<div class="min-h-[calc(100vh-5rem)] bg-slate-50/70 px-4 py-6 sm:px-6 lg:px-8">


{{-- Page Header --}}
<div class="mx-auto mb-6 max-w-7xl">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                    </svg>
                </span>
                <span class="text-xs font-bold uppercase tracking-[0.18em] text-blue-700">
                    Account Settings
                </span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                Your Account
            </h1>

            <p class="mt-1 max-w-2xl text-sm text-slate-500">
                Manage your profile information, security settings, and account preferences.
            </p>
        </div>
    </div>
</div>

<form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data" class="mx-auto max-w-7xl">
    @csrf
    @method('PUT')

    <input type="hidden" name="verification_code" id="verification_code">

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        {{-- ========================================================= --}}
        {{-- LEFT: PROFILE CARD --}}
        {{-- ========================================================= --}}
        <div class="lg:col-span-4 xl:col-span-3">

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm lg:sticky lg:top-24">

                {{-- Profile Cover --}}
                <div class="relative h-28 overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-600">
                    <div class="absolute -right-8 -top-12 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-16 -left-8 h-36 w-36 rounded-full bg-white/10"></div>

                    <div class="absolute bottom-4 left-5">
                        <span class="inline-flex items-center rounded-full border border-white/20 bg-white/15 px-3 py-1 text-[11px] font-semibold text-white backdrop-blur-sm">
                            Account Profile
                        </span>
                    </div>
                </div>

                <div class="px-5 pb-5 sm:px-6">

                    {{-- Avatar --}}
                    <div class="-mt-12 mb-5">
                        <label for="profile_image"
                               class="group relative block h-24 w-24 cursor-pointer overflow-hidden rounded-2xl border-4 border-white bg-slate-100 shadow-lg">

                            <img id="image_preview"
                                 src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : '' }}"
                                 alt="Profile picture"
                                 class="absolute inset-0 h-full w-full object-cover {{ $user->profile_picture ? '' : 'hidden' }}">

                            <div id="upload_placeholder"
                                 class="flex h-full w-full flex-col items-center justify-center {{ $user->profile_picture ? 'hidden' : '' }}">
                                <svg class="mb-1 h-8 w-8 text-slate-400 transition group-hover:text-blue-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                </svg>
                            </div>

                            <div class="absolute inset-0 flex items-center justify-center bg-slate-950/50 opacity-0 transition group-hover:opacity-100">
                                <div class="text-center text-white">
                                    <svg class="mx-auto h-5 w-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 16.5 7.5 12l3 3 4.5-4.5L21 16.5M5 19.5h14a2 2 0 0 0 2-2V6.5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2Z" />
                                    </svg>
                                    <span class="mt-1 block text-[10px] font-semibold">
                                        Change
                                    </span>
                                </div>
                            </div>

                            <input type="file"
                                   name="profile_picture"
                                   id="profile_image"
                                   class="hidden"
                                   accept="image/*"
                                   onchange="previewImage(event)">
                        </label>
                    </div>

                    {{-- User Identity --}}
                    <div class="mb-6">
                        <h2 class="truncate text-xl font-bold text-slate-950">
                            {{ $user->name }}
                        </h2>

                        <p class="mt-1 truncate text-sm text-slate-500">
                            {{ $user->email }}
                        </p>
                    </div>

                    {{-- Account Meta --}}
                    <div class="divide-y divide-slate-100 rounded-2xl border border-slate-200 bg-slate-50/70">

                        <div class="flex items-center justify-between gap-4 p-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5a1.5 1.5 0 0 1 1.5 1.5v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </span>

                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                                        Member Since
                                    </p>
                                    <p class="mt-0.5 text-sm font-semibold text-slate-800">
                                        {{ $user->created_at->format('F j, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4 p-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.023 9.348h4.992V4.356M20.66 9.348a8.25 8.25 0 1 0-2.445 7.255" />
                                    </svg>
                                </span>

                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                                        Last Updated
                                    </p>
                                    <p class="mt-0.5 text-sm font-semibold text-slate-800">
                                        {{ $user->updated_at->format('F j, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Upload Hint --}}
                    <div class="mt-4 flex items-start gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 p-4">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-blue-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M11.25 11.25 12 12m0 0 .75.75M12 12l.75-.75M12 12l-.75.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        <p class="text-xs leading-5 text-blue-800">
                            Use a JPG or PNG image up to 2MB for your profile picture.
                        </p>
                    </div>

                    {{-- Delete Account --}}
                    <button type="button"
                            onclick="confirmDelete()"
                            class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-100">
                        <svg class="h-4 w-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M6 7h12m-9 0v10m6-10v10M9 7V4.75A.75.75 0 0 1 9.75 4h4.5a.75.75 0 0 1 .75.75V7m3 0-.75 13.25a1.5 1.5 0 0 1-1.497 1.415H7.497A1.5 1.5 0 0 1 6 20.25L5.25 7" />
                        </svg>
                        Delete Account
                    </button>

                </div>
            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- RIGHT: SETTINGS --}}
        {{-- ========================================================= --}}
        <div class="space-y-6 lg:col-span-8 xl:col-span-9">

            {{-- Personal Information --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-5 sm:px-7">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                            <svg class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base font-bold text-slate-950">
                                Personal Information
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Update the information associated with your account.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-7">

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- Username --}}
                        <div>
                            <label for="username"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Username
                            </label>

                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                                    </svg>
                                </span>

                                <input type="text"
                                       name="username"
                                       id="username"
                                       value="{{ $user->name }}"
                                       placeholder="Your username"
                                       class="block h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Email Address
                            </label>

                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M21.75 7.5v9a2.25 2.25 0 0 1-2.25 2.25H4.5a2.25 2.25 0 0 1-2.25-2.25v-9A2.25 2.25 0 0 1 4.5 5.25h15a2.25 2.25 0 0 1 2.25 2.25ZM3 7.5l8.11 5.407a1.6 1.6 0 0 0 1.78 0L21 7.5" />
                                    </svg>
                                </span>

                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ $user->email }}"
                                       placeholder="you@example.com"
                                       class="block h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
                            </div>

                            <p class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                                <svg class="h-3.5 w-3.5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 9v3.75m0 3h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Used for login and account notifications.
                            </p>
                        </div>

                    </div>
                </div>
            </section>


            {{-- Security --}}
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-5 sm:px-7">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-violet-100 text-violet-700">
                            <svg class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16.5 10.5V7.875a4.5 4.5 0 0 0-9 0V10.5m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v7.5A1.5 1.5 0 0 1 17.25 21H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-base font-bold text-slate-950">
                                Security Settings
                            </h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Keep your account secure by updating your password.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-7">

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- New Password --}}
                        <div>
                            <label for="new_password"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                New Password
                            </label>

                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M16.5 10.5V7.875a4.5 4.5 0 0 0-9 0V10.5m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v7.5A1.5 1.5 0 0 1 17.25 21H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </span>

                                <input type="password"
                                       name="password"
                                       id="new_password"
                                       placeholder="••••••••"
                                       class="block h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-100">
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="confirm_password"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Confirm Password
                            </label>

                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M16.5 10.5V7.875a4.5 4.5 0 0 0-9 0V10.5m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v7.5A1.5 1.5 0 0 1 17.25 21H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </span>

                                <input type="password"
                                       name="password_confirmation"
                                       id="confirm_password"
                                       placeholder="••••••••"
                                       class="block h-11 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-violet-500 focus:bg-white focus:ring-4 focus:ring-violet-100">
                            </div>
                        </div>

                    </div>

                    {{-- Password Requirements --}}
                    <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5">

                        <div class="mb-4 flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-violet-600 shadow-sm ring-1 ring-slate-200">
                                <svg class="h-4 w-4"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-sm font-bold text-slate-800">
                                    Password requirements
                                </p>
                                <p class="text-xs text-slate-400">
                                    Make sure your new password meets these requirements.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-3">

                            <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-2.5 ring-1 ring-slate-200">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                                    <svg class="h-3 w-3"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m5 12 4 4L19 6" />
                                    </svg>
                                </span>
                                <span class="text-xs font-medium text-slate-600">
                                    At least 8 characters
                                </span>
                            </div>

                            <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-2.5 ring-1 ring-slate-200">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                                    <svg class="h-3 w-3"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m5 12 4 4L19 6" />
                                    </svg>
                                </span>
                                <span class="text-xs font-medium text-slate-600">
                                    Uppercase letter
                                </span>
                            </div>

                            <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-2.5 ring-1 ring-slate-200">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                                    <svg class="h-3 w-3"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m5 12 4 4L19 6" />
                                    </svg>
                                </span>
                                <span class="text-xs font-medium text-slate-600">
                                    Number
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </section>


            {{-- Bottom Actions --}}
            <div class="flex flex-col-reverse gap-3 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-end">

                <button type="button"
                        onclick="goBack()"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">
                    Cancel
                </button>

                <button id="save-changes-button"
                        type="submit"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:opacity-60">
                    <svg class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 12.75 9.5 17 19 7" />
                    </svg>
                    Save Changes
                </button>

            </div>

        </div>
    </div>
</form>


{{-- Delete Account Form --}}
<form id="delete-account-form"
      action="{{ route('account.delete') }}"
      method="POST"
      class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- Global Shared Component Layer --}}
<x-verification-modal />


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}
<script>
    const accountForm = document.querySelector('form[action="{{ route('account.update') }}"]');
    const saveButton = document.getElementById('save-changes-button');
    const passwordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const verificationHiddenInput = document.getElementById('verification_code');

    let bypassVerification = false;

    function goBack() {
        window.history.back();
    }

    function confirmDelete() {
        if (confirm('Are you sure you want to delete your account? This cannot be undone.')) {
            document.getElementById('delete-account-form').submit();
        }
    }

    function previewImage(event) {
        const file = event.target.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();
        const preview = document.getElementById('image_preview');
        const placeholder = document.getElementById('upload_placeholder');

        reader.onload = function () {
            preview.src = reader.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };

        reader.readAsDataURL(file);
    }

    async function sendVerificationCode() {
        const emailValue = document.getElementById('email').value.trim();

        saveButton.disabled = true;
        saveButton.innerHTML = `
            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" class="opacity-25"></circle>
                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M21 12a9 9 0 0 0-9-9"></path>
            </svg>
            Sending Code...
        `;

        try {
            const response = await fetch("{{ route('account.send-code') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: emailValue
                }),
            });

            const payload = await response.json();

            if (!response.ok) {
                throw new Error(payload.message || 'Unable to send verification code.');
            }

            openVerificationModal();

        } catch (error) {
            openGlobalErrorModal(error.message, 'Verification Failed');

        } finally {
            saveButton.disabled = false;
            saveButton.innerHTML = `
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.75 9.5 17 19 7" />
                </svg>
                Save Changes
            `;
        }
    }

    accountForm.addEventListener('submit', function (event) {

        if (bypassVerification) {
            return;
        }

        if (passwordInput.value.trim() !== '') {

            event.preventDefault();

            if (passwordInput.value !== confirmPasswordInput.value) {
                openGlobalErrorModal(
                    'Your new password and confirmation password fields do not match.',
                    'Password Mismatch'
                );

                return;
            }

            sendVerificationCode();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {

        const confirmBtn = document.getElementById('confirm-save-button');
        const modalInput = document.getElementById('verification_code_input');

        if (confirmBtn) {

            confirmBtn.addEventListener('click', function () {

                const code = modalInput.value.trim();

                if (code.length !== 6) {

                    const feedbackBox = document.getElementById('send-code-feedback');

                    if (feedbackBox) {
                        feedbackBox.textContent =
                            'Enter the complete 6-digit verification code.';

                        feedbackBox.classList.remove('hidden');
                    }

                    return;
                }

                verificationHiddenInput.value = code;
                bypassVerification = true;

                if (typeof closeVerificationModal === "function") {
                    closeVerificationModal();
                }

                accountForm.requestSubmit();
            });
        }
    });
</script>


@if($errors->has('verification_code'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const codeError = "{{ $errors->first('verification_code') }}";

            openGlobalErrorModal(codeError, 'Invalid Code');
        });
    </script>
@endif


</div>

@endsection
