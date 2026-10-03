
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Forgot Password</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Flowbite --}}
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.css"
        rel="stylesheet"
    >

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>

</head>


<body class="min-h-screen bg-slate-50 font-sans text-slate-900">

    {{-- =========================================================
        BACKGROUND
    ========================================================== --}}
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6">

        {{-- Decorative Background --}}
        <div class="pointer-events-none absolute inset-0">

            <div
                class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-blue-200/30 blur-3xl"
            ></div>

            <div
                class="absolute -bottom-40 -right-32 h-[28rem] w-[28rem] rounded-full bg-indigo-200/30 blur-3xl"
            ></div>

            <div
                class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-blue-100/20 blur-3xl"
            ></div>

        </div>


        {{-- =====================================================
            FORGOT PASSWORD CARD
        ====================================================== --}}
        <div class="relative z-10 w-full max-w-md">

            <div
                class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/90 shadow-xl shadow-slate-200/60 backdrop-blur-xl"
            >

                {{-- =================================================
                    CARD HEADER
                ================================================== --}}
                <div class="px-6 pb-2 pt-8 text-center sm:px-8 sm:pt-10">

                    
                    {{-- Logo / Lock Icon --}}
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-200"
                    >
                        <svg
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            {{-- Lock body --}}
                            <rect
                                x="4"
                                y="10"
                                width="16"
                                height="11"
                                rx="2"
                                stroke-width="1.8"
                            />

                            {{-- Lock shackle --}}
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 10V7a4 4 0 0 1 8 0v3"
                            />

                            {{-- Keyhole --}}
                            <circle
                                cx="12"
                                cy="15"
                                r="1.2"
                                fill="currentColor"
                                stroke="none"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M12 16.2v2"
                            />
                        </svg>
                    </div>




                    <h1 class="mt-6 text-2xl font-bold tracking-tight text-slate-900">
                        Forgot your password?
                    </h1>

                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                        No problem. Enter your email address below and we'll
                        send you a link to reset your password.
                    </p>

                </div>


                {{-- =================================================
                    FORM
                ================================================== --}}
                <div class="px-6 pb-8 pt-7 sm:px-8 sm:pb-10">


                    {{-- Success Message --}}
                    @if (session('status'))

                        <div
                            class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700"
                            role="alert"
                        >

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            <div>
                                {{ session('status') }}
                            </div>

                        </div>

                    @endif


                    {{-- Error Message --}}
                    @if ($errors->any())

                        <div
                            class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4"
                            role="alert"
                        >

                            <div class="flex gap-3">

                                <svg
                                    class="mt-0.5 h-5 w-5 shrink-0 text-red-500"
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

                                    <p class="text-sm font-semibold text-red-800">
                                        Please check the following:
                                    </p>

                                    <ul class="mt-1.5 list-inside list-disc text-xs text-red-700">

                                        @foreach ($errors->all() as $error)

                                            <li>
                                                {{ $error }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif


                    <form
                        method="POST"
                        action="{{ route('password.email') }}"
                        class="space-y-5"
                    >

                        @csrf


                        {{-- Email --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-semibold text-slate-800"
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
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                    autofocus
                                    placeholder="you@example.com"
                                    class="block h-13 w-full rounded-xl border border-slate-200 bg-slate-50/70 py-3.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 @error('email') border-red-300 bg-red-50/30 focus:border-red-500 focus:ring-red-100 @enderror"
                                />

                            </div>


                            @error('email')

                                <p class="mt-2 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="group inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                        >

                            <svg
                                class="h-5 w-5 transition-transform group-hover:translate-x-0.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M22 2 11 13"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="m22 2-7 20-4-9-9-4 20-7Z"
                                />
                            </svg>

                            Send Password Reset Link

                        </button>

                    </form>


                    {{-- =================================================
                        BACK TO LOGIN
                    ================================================== --}}
                    <div class="mt-7 text-center">

                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                        >

                            <svg
                                class="h-4 w-4"
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

                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <p class="mt-6 text-center text-xs text-slate-400">
                Secure account recovery
            </p>

        </div>

    </div>


    {{-- Flowbite JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>

</body>

</html>
