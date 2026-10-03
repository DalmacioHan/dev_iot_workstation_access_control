
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

    <title>Reset Password</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-slate-950">


    {{-- =========================================================
        PAGE BACKGROUND
    ========================================================== --}}

    <section
        class="relative flex min-h-screen items-center justify-center overflow-hidden bg-cover bg-center bg-no-repeat px-4 py-10 sm:px-6"
        style="background-image: url('{{ asset('image/library_bg.jpg') }}');"
    >

        {{-- Dark Overlay --}}
        <div class="absolute inset-0 bg-slate-950/65"></div>


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
            SINGLE RESET PASSWORD CARD
        ====================================================== --}}

        <div class="relative z-10 w-full max-w-md">


            <div
                class="rounded-[2rem] border border-white/20 bg-white/[0.12] p-6 shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-8"
            >


                {{-- =================================================
                    LOGO / BRAND
                ================================================== --}}

                <div class="mb-7 text-center">


                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border border-white/30 bg-white/10 shadow-lg backdrop-blur-sm"
                    >

                        <img
                            src="{{ asset('image/library_logo.jpg') }}"
                            alt="Open Learning Hub Logo"
                            class="h-full w-full object-cover"
                        >

                    </div>


                    <p
                        class="mt-4 text-sm font-bold tracking-wide text-white"
                    >
                        Open Learning Hub
                    </p>


                    <p
                        class="mt-1 text-xs font-medium text-blue-100/70"
                    >
                        Digital Access Portal
                    </p>


                </div>



                {{-- =================================================
                    HEADER
                ================================================== --}}

                <div class="mb-7 text-center">


                    <div
                        class="mx-auto mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-blue-300/20 bg-blue-500/15 text-blue-200"
                    >

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2Zm10-9V7a4 4 0 10-8 0v3h8Z"
                            />

                        </svg>

                    </div>


                    <h1
                        class="text-2xl font-bold tracking-tight text-white"
                    >
                        Reset your password
                    </h1>


                    <p
                        class="mx-auto mt-2 max-w-sm text-sm leading-6 text-white/65"
                    >
                        Create a new password for your account to continue
                        accessing Open Learning Hub.
                    </p>


                </div>



                {{-- =================================================
                    ERROR MESSAGE
                ================================================== --}}

                @if ($errors->any())

                    <div
                        class="mb-5 flex gap-3 rounded-2xl border border-red-300/30 bg-red-500/15 px-4 py-3.5 text-sm text-red-100"
                        role="alert"
                    >

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-red-300"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 9v3m0 4h.01M10.29 3.86l-7.82 13.5A1 1 0 003.33 19h17.34a1 1 0 00.86-1.64l-7.82-13.5a1 1 0 00-1.72 0Z"
                            />

                        </svg>


                        <div class="min-w-0">

                            <p class="font-semibold">
                                Unable to reset password
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



                {{-- =================================================
                    RESET PASSWORD FORM
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route('password.update') }}"
                    class="space-y-5"
                >

                    @csrf



                    {{-- Reset Token --}}
                    <input
                        type="hidden"
                        name="token"
                        value="{{ $token }}"
                    >



                    {{-- =================================================
                        EMAIL
                    ================================================== --}}

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

                                <svg
                                    class="h-5 w-5 text-slate-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
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
                                value="{{ old('email', $email) }}"
                                required
                                autocomplete="email"
                                class="block h-12 w-full rounded-xl border border-white/20 bg-white/90 pl-11 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-400/20 @error('email') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                            >

                        </div>


                        @error('email')

                            <p class="mt-2 text-xs font-medium text-red-200">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- =================================================
                        NEW PASSWORD
                    ================================================== --}}

                    <div>

                        <label
                            for="password"
                            class="mb-2 block text-sm font-semibold text-white"
                        >
                            New Password
                        </label>


                        <div class="relative">


                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                            >

                                <svg
                                    class="h-5 w-5 text-slate-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

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
                                id="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Enter your new password"
                                class="block h-12 w-full rounded-xl border border-white/20 bg-white/90 pl-11 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-400/20 @error('password') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                            >

                        </div>


                        @error('password')

                            <p class="mt-2 text-xs font-medium text-red-200">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- =================================================
                        CONFIRM PASSWORD
                    ================================================== --}}

                    <div>

                        <label
                            for="password_confirmation"
                            class="mb-2 block text-sm font-semibold text-white"
                        >
                            Confirm New Password
                        </label>


                        <div class="relative">


                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                            >

                                <svg
                                    class="h-5 w-5 text-slate-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M9 12.75 11.25 15 15 9.75M12 3l7.5 3v5.25c0 4.695-3.177 8.927-7.5 9.75-4.323-.823-7.5-5.055-7.5-9.75V6L12 3Z"
                                    />

                                </svg>

                            </div>


                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm your new password"
                                class="block h-12 w-full rounded-xl border border-white/20 bg-white/90 pl-11 pr-4 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-400/20"
                            >

                        </div>

                    </div>



                    {{-- =================================================
                        RESET BUTTON
                    ================================================== --}}

                    <button
                        type="submit"
                        class="group flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-bold text-white shadow-lg shadow-blue-900/30 transition hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300/30"
                    >

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2Zm10-9V7a4 4 0 10-8 0v3h8Z"
                            />

                        </svg>


                        <span>
                            Reset Password
                        </span>

                    </button>



                    {{-- =================================================
                        DIVIDER
                    ================================================== --}}

                    <div class="flex items-center gap-4 py-1">

                        <div class="h-px flex-1 bg-white/15"></div>

                        <span
                            class="text-xs font-medium text-white/40"
                        >
                            OR
                        </span>

                        <div class="h-px flex-1 bg-white/15"></div>

                    </div>



                    {{-- =================================================
                        BACK TO LOGIN
                    ================================================== --}}

                    <a
                        href="{{ route('login') }}"
                        class="group flex h-12 w-full items-center justify-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 text-sm font-semibold text-white transition hover:border-white/25 hover:bg-white/10"
                    >

                        <svg
                            class="h-4 w-4 transition-transform group-hover:-translate-x-0.5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M15 19l-7-7 7-7"
                            />

                        </svg>

                        Back to Sign In

                    </a>


                </form>

            </div>



            {{-- Footer --}}
            <p
                class="mt-5 text-center text-xs text-white/40"
            >
                Secure password reset for Open Learning Hub
            </p>


        </div>

    </section>


</body>

</html>
