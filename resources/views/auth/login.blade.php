<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

<title>Login</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-slate-950">


<section
    class="relative flex min-h-screen items-center justify-center overflow-hidden bg-cover bg-center bg-no-repeat px-4 py-8 sm:px-6"
    style="background-image: url('{{ asset('image/library_bg.jpg') }}');"
>

    {{-- Background Overlay --}}
    <div class="absolute inset-0 bg-slate-950/65"></div>

    {{-- Subtle Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-blue-950/40 via-slate-950/20 to-slate-950/70"></div>

    {{-- Main Container --}}
    <div class="relative z-10 w-full max-w-5xl overflow-hidden rounded-[2rem] border border-white/20 bg-white/10 shadow-2xl shadow-black/30 backdrop-blur-md">

        <div class="grid min-h-[560px] grid-cols-1 lg:grid-cols-[1.1fr_0.9fr]">

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
                                Digital Access Portal
                            </p>
                        </div>
                    </div>

                    {{-- Heading --}}
                    <div class="max-w-md">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.25em] text-blue-200">
                            Welcome Back
                        </p>

                        <h1 class="text-4xl font-extrabold leading-[1.05] tracking-tight drop-shadow-lg sm:text-5xl lg:text-6xl">
                            Access.
                            <br>
                            Study.
                            <br>
                            Excel.
                        </h1>

                        <p class="mt-6 max-w-md text-base leading-relaxed text-white/75 sm:text-lg">
                            Securely access library computers, track your digital resource usage, 
                            and connect to your course materials from one central hub.
                        </p>
                    </div>


                </div>
            </div>

            {{-- Login Panel --}}
            <div class="flex items-center justify-center bg-slate-950/20 px-5 py-10 sm:px-10 lg:px-12">

                <div class="w-full max-w-md">

                    {{-- Login Card --}}
                    <div class="rounded-3xl border border-white/20 bg-white/[0.12] p-6 shadow-2xl backdrop-blur-xl sm:p-8">

                        {{-- Card Header --}}
                        <div class="mb-7">
                            

                            <h2 class="text-2xl font-bold tracking-tight text-white">
                                Welcome back
                            </h2>

                            <p class="mt-1.5 text-sm text-white/65">
                                Sign in to continue to your account.
                            </p>
                        </div>

                        {{-- Validation Error --}}
                        @if ($errors->any())
                            <div class="mb-5 flex gap-3 rounded-2xl border border-red-300/30 bg-red-500/15 px-4 py-3.5 text-sm text-red-100">
                                <x-icon name="exclamation-triangle" class="mt-0.5 h-5 w-5 shrink-0 text-red-300" />

                                <div>
                                    <p class="font-semibold">
                                        Unable to sign in
                                    </p>
                                    <p class="mt-0.5 text-xs text-red-100/80">
                                        {{ $errors->first() }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
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
                                        <x-icon name="user" class="h-5 w-5 text-slate-400" />
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

                            {{-- Password --}}
                            <div>
                                <div class="mb-2 flex items-center justify-between">
                                    <label
                                        for="password"
                                        class="block text-sm font-semibold text-white"
                                    >
                                        Password
                                    </label>

                                    <a
                                        href="{{route('password.request')}}"
                                        class="text-xs font-medium text-blue-200 transition hover:text-white hover:underline"
                                    >
                                        Forgot password?
                                    </a>
                                </div>

                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <x-icon name="lock" class="h-5 w-5 text-slate-400" />
                                    </div>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="••••••••"
                                        autocomplete="current-password"
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
                                <span>Sign In</span>

                                <x-icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" />
                            </button>



                        </form>
                    </div>

                    {{-- Footer --}}
                    <p class="mt-5 text-center text-xs text-white/40">
                        Secure access to Open Learning Hub
                    </p>
                </div>
            </div>

        </div>
    </div>

</section>


</body>
</html>
