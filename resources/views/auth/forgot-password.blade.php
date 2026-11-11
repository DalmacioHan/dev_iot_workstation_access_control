<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >

    <title>Forgot Password</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-slate-950">


    {{-- =========================================================
        PAGE BACKGROUND
    ========================================================== --}}

    <section
        class="relative flex min-h-screen items-center justify-center overflow-hidden bg-cover bg-center bg-no-repeat px-4 py-8 sm:px-6"
        style="background-image: url('{{ asset('image/library_bg.jpg') }}');"
    >

        {{-- Dark Background Overlay --}}
        <div
            class="absolute inset-0 bg-slate-950/65"
        ></div>


        {{-- Blue / Slate Gradient --}}
        <div
            class="absolute inset-0 bg-gradient-to-br from-blue-950/40 via-slate-950/20 to-slate-950/70"
        ></div>


        {{-- Decorative Blue Glow --}}
        <div
            class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-blue-500/20 blur-3xl"
        ></div>


        {{-- Decorative Indigo Glow --}}
        <div
            class="pointer-events-none absolute -bottom-32 right-1/4 h-72 w-72 rounded-full bg-indigo-500/15 blur-3xl"
        ></div>



        {{-- =====================================================
            MAIN CONTAINER
        ====================================================== --}}

        <div
            class="relative z-10 w-full max-w-5xl overflow-hidden rounded-[2rem] border border-white/20 bg-white/10 shadow-2xl shadow-black/30 backdrop-blur-md"
        >

            <div
                class="grid min-h-[560px] grid-cols-1 lg:grid-cols-[1.1fr_0.9fr]"
            >


                {{-- =================================================
                    LEFT BRANDING PANEL
                ================================================== --}}

                <div
                    class="relative flex items-center overflow-hidden px-7 py-12 sm:px-12 lg:px-16"
                >


                    {{-- Decorative Glows --}}

                    <div
                        class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-blue-500/20 blur-3xl"
                    ></div>

                    <div
                        class="absolute -bottom-32 left-1/3 h-72 w-72 rounded-full bg-indigo-500/15 blur-3xl"
                    ></div>



                    <div class="relative max-w-lg text-white">


                        {{-- =============================================
                            LOGO
                        ============================================== --}}

                        <a
                            href="{{ route('login') }}"
                            class="mb-8 flex items-center gap-3"
                        >

                            <div
                                class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl border border-white/30 bg-white/10 shadow-lg backdrop-blur-sm"
                            >

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

                                <p
                                    class="text-xs font-medium text-blue-100/80"
                                >
                                    Digital Access Portal
                                </p>

                            </div>

                        </a>



                        {{-- =============================================
                            BRANDING CONTENT
                        ============================================== --}}

                        <div class="max-w-md">

                            <p
                                class="mb-3 text-xs font-bold uppercase tracking-[0.25em] text-blue-200"
                            >
                                Account Recovery
                            </p>


                            <h1
                                class="text-4xl font-extrabold leading-[1.05] tracking-tight drop-shadow-lg sm:text-5xl lg:text-6xl"
                            >
                                Recover.

                                <br>

                                Reset.

                                <br>

                                Continue.
                            </h1>


                            <p
                                class="mt-6 max-w-md text-base leading-relaxed text-white/75 sm:text-lg"
                            >
                                Reset your password securely and regain access
                                to Open Learning Hub and your authorized
                                workstation resources.
                            </p>

                        </div>



                        {{-- =============================================
                            SECURITY INFORMATION
                        ============================================== --}}

                        <div
                            class="mt-8 flex max-w-md items-start gap-3 rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm"
                        >

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-500/15 text-blue-200"
                            >

                                <x-icon name="check-circle" class="h-5 w-5" />

                            </div>


                            <div>

                                <p
                                    class="text-sm font-semibold text-white"
                                >
                                    Secure password recovery
                                </p>

                                <p
                                    class="mt-1 text-xs leading-5 text-white/55"
                                >
                                    A password reset link will only be sent to
                                    the email address associated with your account.
                                </p>

                            </div>

                        </div>


                    </div>

                </div>



                {{-- =================================================
                    RIGHT PASSWORD RESET PANEL
                ================================================== --}}

                <div
                    class="flex items-center justify-center border-t border-white/10 bg-slate-950/20 px-5 py-10 sm:px-10 lg:border-l lg:border-t-0 lg:px-12"
                >

                    <div class="w-full max-w-md">


                        {{-- =============================================
                            RESET CARD
                        ============================================== --}}

                        <div
                            class="rounded-3xl border border-white/20 bg-white/[0.12] p-6 shadow-2xl backdrop-blur-xl sm:p-8"
                        >


                            {{-- =========================================
                                CARD HEADER
                            ========================================== --}}

                            <div class="mb-7">


                                {{-- Lock Icon --}}
                                <div
                                    class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-blue-300/20 bg-blue-500/15 text-blue-200"
                                >

                                    <x-icon name="key" class="h-6 w-6" aria-hidden="true" />

                                </div>


                                <h2
                                    class="text-2xl font-bold tracking-tight text-white"
                                >
                                    Forgot your password?
                                </h2>


                                <p
                                    class="mt-1.5 text-sm leading-6 text-white/65"
                                >
                                    Enter your email address and we'll send you
                                    a secure link to reset your password.
                                </p>

                            </div>



                            {{-- =========================================
                                SUCCESS MESSAGE
                            ========================================== --}}

                            @if (session('status'))

                                <div
                                    class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-300/25 bg-emerald-500/15 px-4 py-3.5 text-sm text-emerald-100"
                                    role="alert"
                                >

                                    <x-icon name="check" class="mt-0.5 h-5 w-5 shrink-0 text-emerald-300" />


                                    <div>

                                        <p
                                            class="font-semibold text-emerald-100"
                                        >
                                            Reset link sent
                                        </p>

                                        <p
                                            class="mt-0.5 text-xs leading-5 text-emerald-100/80"
                                        >
                                            {{ session('status') }}
                                        </p>

                                    </div>

                                </div>

                            @endif



                            {{-- =========================================
                                ERROR MESSAGE
                            ========================================== --}}

                            @if ($errors->any())

                                <div
                                    class="mb-5 flex gap-3 rounded-2xl border border-red-300/30 bg-red-500/15 px-4 py-3.5 text-sm text-red-100"
                                    role="alert"
                                >

                                    <x-icon name="exclamation-triangle" class="mt-0.5 h-5 w-5 shrink-0 text-red-300" />


                                    <div class="min-w-0">

                                        <p
                                            class="font-semibold text-red-100"
                                        >
                                            Unable to continue
                                        </p>


                                        <ul
                                            class="mt-1 list-inside list-disc text-xs leading-5 text-red-100/80"
                                        >

                                            @foreach ($errors->all() as $error)

                                                <li>
                                                    {{ $error }}
                                                </li>

                                            @endforeach

                                        </ul>

                                    </div>

                                </div>

                            @endif



                            {{-- =========================================
                                FORM
                            ========================================== --}}

                            <form
                                method="POST"
                                action="{{ route('password.email') }}"
                                class="space-y-5"
                            >

                                @csrf



                                {{-- =====================================
                                    EMAIL
                                ====================================== --}}

                                <div>

                                    <label
                                        for="email"
                                        class="mb-2 block text-sm font-semibold text-white"
                                    >
                                        Email Address
                                    </label>


                                    <div class="relative">

                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                                        >

                                            <x-icon name="mail" class="h-5 w-5 text-slate-400" />

                                        </div>


                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            autocomplete="email"
                                            required
                                            autofocus
                                            placeholder="you@example.com"
                                            class="block h-12 w-full rounded-xl border border-white/20 bg-white/90 pl-11 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-400/20 @error('email') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                                        >

                                    </div>


                                    @error('email')

                                        <p
                                            class="mt-2 text-xs font-medium text-red-200"
                                        >
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>



                                {{-- =====================================
                                    SUBMIT BUTTON
                                ====================================== --}}

                                <button
                                    type="submit"
                                    class="group flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-bold text-white shadow-lg shadow-blue-900/30 transition hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300/30"
                                >

                                    <x-icon name="mail" class="h-5 w-5 transition-transform group-hover:translate-x-0.5" />


                                    <span>
                                        Send Password Reset Link
                                    </span>

                                </button>



                                {{-- =====================================
                                    DIVIDER
                                ====================================== --}}

                                <div
                                    class="flex items-center gap-4 py-1"
                                >

                                    <div
                                        class="h-px flex-1 bg-white/15"
                                    ></div>

                                    <span
                                        class="text-xs font-medium text-white/40"
                                    >
                                        OR
                                    </span>

                                    <div
                                        class="h-px flex-1 bg-white/15"
                                    ></div>

                                </div>



                                {{-- =====================================
                                    BACK TO LOGIN
                                ====================================== --}}

                                <a
                                    href="{{ route('login') }}"
                                    class="group flex h-12 w-full items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 text-sm font-semibold text-white transition hover:border-white/25 hover:bg-white/10"
                                >

                                    <x-icon name="arrow-left" class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" />

                                    Back to Sign In

                                </a>


                            </form>

                        </div>



                        {{-- =============================================
                            FOOTER
                        ============================================== --}}

                        <p
                            class="mt-5 text-center text-xs text-white/40"
                        >
                            Secure account recovery for Open Learning Hub
                        </p>

                    </div>

                </div>


            </div>

        </div>


    </section>


</body>

</html>