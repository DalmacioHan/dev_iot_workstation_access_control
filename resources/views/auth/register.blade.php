<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

<title>Register</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-slate-950">

<section
    class="relative flex min-h-screen items-center justify-center overflow-hidden bg-cover bg-center bg-no-repeat px-4 py-8 sm:px-6"
    style="background-image: url('{{ asset('image/lib_bg.jpg') }}');"
>

    <div class="absolute inset-0 bg-slate-950/65"></div>


    <div class="absolute inset-0 bg-gradient-to-br from-blue-950/40 via-slate-950/20 to-slate-950/70"></div>

    {{-- Main Container --}}
    <div class="relative z-10 w-full max-w-5xl overflow-hidden rounded-[2rem] border border-white/20 bg-white/10 shadow-2xl shadow-black/30 backdrop-blur-md">

        <div class="grid min-h-[600px] grid-cols-1 lg:grid-cols-[1.1fr_0.9fr]">

            {{-- Branding Panel --}}
            <div class="relative flex items-center overflow-hidden px-7 py-12 sm:px-12 lg:px-16">

                {{-- Decorative Glow --}}
                <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-blue-500/20 blur-3xl"></div>
                <div class="absolute -bottom-32 left-1/3 h-72 w-72 rounded-full bg-indigo-500/15 blur-3xl"></div>

                <div class="relative max-w-lg text-white">

                    {{-- Logo --}}
                    <div class="mb-8 flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl border border-white/30 bg-white/10 shadow-lg backdrop-blur-sm">
                            <img
                                src="{{ asset('image/library_logo.jpg') }}"
                                alt="Open Learning Hub Logo"
                                class="h-full w-full object-cover"
                            >
                        </div>

                        <div>
                            <p class="text-lg font-bold tracking-wide">
                                Open Learning Hub
                            </p>
                            <p class="text-xs font-medium text-blue-100/80">
                                Learning Management System
                            </p>
                        </div>
                    </div>

                    {{-- Heading --}}
                    <div class="max-w-md">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.25em] text-blue-200">
                            Administrator Setup
                        </p>

                        <h1 class="text-4xl font-extrabold leading-[1.05] tracking-tight drop-shadow-lg sm:text-5xl lg:text-6xl">
                            Manage. 
                            <br>
                            Monitor.
                            <br>
                            Maintain.
                        </h1>

                        <p class="mt-6 max-w-md text-base leading-relaxed text-white/75 sm:text-lg">
                            Create your account and gain access to your
                            learning resources and activities.
                        </p>
                    </div>

                    {{-- Feature Pills --}}
                    <div class="mt-8 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-2 text-xs font-medium text-white/85 backdrop-blur-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-300"></span>
                            Full System Oversight
                        </span>

                        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-2 text-xs font-medium text-white/85 backdrop-blur-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                            Advanced Analytics
                        </span>
                    </div>
                </div>
            </div>

            {{-- Registration Panel --}}
            <div class="flex items-center justify-center bg-slate-950/20 px-5 py-10 sm:px-10 lg:px-12">

                <div class="w-full max-w-md">

                    {{-- Registration Card --}}
                    <div class="rounded-3xl border border-white/20 bg-white/[0.12] p-6 shadow-2xl backdrop-blur-xl sm:p-8">

                        {{-- Card Header --}}
                        <div class="mb-7">
                            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/20 text-blue-200 ring-1 ring-blue-300/20">
                                <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M18 9v6m3-3h-6M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.25a8.25 8.25 0 0115 0"
                                    />
                                </svg>
                            </div>

                            <h2 class="text-2xl font-bold tracking-tight text-white">
                                Create your account
                            </h2>

                            <p class="mt-1.5 text-sm text-white/65">
                                Fill in your details to get started.
                            </p>
                        </div>

                        {{-- Validation Error --}}
                        @if ($errors->any())
                            <div class="mb-5 flex gap-3 rounded-2xl border border-red-300/30 bg-red-500/15 px-4 py-3.5 text-sm text-red-100">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>

                                <div>
                                    <p class="font-semibold">
                                        Unable to create account
                                    </p>
                                    <p class="mt-0.5 text-xs text-red-100/80">
                                        {{ $errors->first() }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                            @csrf

                            {{-- Username --}}
                            <div>
                                <label
                                    for="name"
                                    class="mb-2 block text-sm font-semibold text-white"
                                >
                                    Username
                                </label>

                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.5 20.25a8.25 8.25 0 0115 0"
                                            />
                                        </svg>
                                    </div>

                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        placeholder="admin12345"
                                        autocomplete="username"
                                        required
                                        autofocus
                                        class="block h-12 w-full rounded-xl border border-white/20 bg-white/90 pl-11 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-400/20"
                                    >
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label
                                    for="email"
                                    class="mb-2 block text-sm font-semibold text-white"
                                >
                                    Email
                                </label>

                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M3 7.5A2.5 2.5 0 015.5 5h13A2.5 2.5 0 0121 7.5v9a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 16.5v-9z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="m3.5 7 8.5 6 8.5-6"
                                            />
                                        </svg>
                                    </div>

                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        placeholder="example@example.com"
                                        autocomplete="email"
                                        required
                                        class="block h-12 w-full rounded-xl border border-white/20 bg-white/90 pl-11 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-400/20"
                                    >
                                </div>
                            </div>

                            {{-- Password --}}
                            <div>
                                <label
                                    for="password"
                                    class="mb-2 block text-sm font-semibold text-white"
                                >
                                    Password
                                </label>

                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M16.5 10.5V7.75a4.5 4.5 0 10-9 0v2.75m-.75 0h10.5A1.75 1.75 0 0119 12.25v6A1.75 1.75 0 0117.25 20H6.75A1.75 1.75 0 015 18.25v-6a1.75 1.75 0 011.75-1.75z"
                                            />
                                        </svg>
                                    </div>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="••••••••"
                                        autocomplete="new-password"
                                        required
                                        class="block h-12 w-full rounded-xl border border-white/20 bg-white/90 pl-11 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-400/20"
                                    >
                                </div>
                            </div>

                            {{-- Submit --}}
                            <button
                                type="submit"
                                class="group flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-bold text-white shadow-lg shadow-blue-900/30 transition hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300/30"
                            >
                                <span>Create Account</span>

                                <svg
                                    class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 12h14m-5-5l5 5-5 5"
                                    />
                                </svg>
                            </button>

                            {{-- Divider --}}
                            <div class="flex items-center gap-4 py-1">
                                <div class="h-px flex-1 bg-white/15"></div>
                                <span class="text-xs font-medium text-white/45">
                                    OR
                                </span>
                                <div class="h-px flex-1 bg-white/15"></div>
                            </div>

                            {{-- Login --}}
                            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3.5 text-center">
                                <p class="text-sm text-white/65">
                                    Already have an account?
                                    <a
                                        href="{{ route('login') }}"
                                        class="ml-1 font-bold text-white transition hover:text-blue-200 hover:underline"
                                    >
                                        Sign in
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>

                    {{-- Footer --}}
                    <p class="mt-5 text-center text-xs text-white/40">
                        Create your secure Open Learning Hub account
                    </p>
                </div>
            </div>

        </div>
    </div>

</section>


</body>
</html>
