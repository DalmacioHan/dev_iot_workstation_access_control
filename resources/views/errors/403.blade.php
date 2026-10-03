<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>403 - Access Denied</title>

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

    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6">

        {{-- =========================================================
            BACKGROUND DECORATION
        ========================================================== --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            <div
                class="absolute -left-40 -top-40 h-[28rem] w-[28rem] rounded-full bg-blue-200/30 blur-3xl"
            ></div>

            <div
                class="absolute -bottom-40 -right-40 h-[30rem] w-[30rem] rounded-full bg-indigo-200/30 blur-3xl"
            ></div>

            <div
                class="absolute left-1/2 top-1/2 h-80 w-80 -translate-x-1/2 -translate-y-1/2 rounded-full bg-blue-100/30 blur-3xl"
            ></div>

        </div>


        {{-- =========================================================
            ERROR CARD
        ========================================================== --}}
        <div class="relative z-10 w-full max-w-4xl">

            <div
                class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60"
            >

                <div class="grid grid-cols-1 lg:grid-cols-2">

                    {{-- =================================================
                        LEFT PANEL
                    ================================================== --}}
                    <div
                        class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 p-8 text-white sm:p-10 lg:p-12"
                    >

                        {{-- Decorative circles --}}
                        <div
                            class="absolute -right-20 -top-20 h-56 w-56 rounded-full bg-white/10"
                        ></div>

                        <div
                            class="absolute -bottom-20 -left-20 h-60 w-60 rounded-full bg-white/5"
                        ></div>


                        <div class="relative">

                            {{-- Lock / Shield Icon --}}
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur"
                            >

                                <svg
                                    class="h-8 w-8"
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
                                        d="M9 11V9a3 3 0 0 1 6 0v2"
                                    />

                                    <rect
                                        x="8"
                                        y="11"
                                        width="8"
                                        height="6"
                                        rx="1.5"
                                        stroke-width="1.8"
                                    />
                                </svg>

                            </div>


                            <p class="mt-8 text-sm font-semibold uppercase tracking-[0.25em] text-blue-100">
                                Error 403
                            </p>


                            <h1 class="mt-3 text-4xl font-bold tracking-tight sm:text-5xl">
                                Access denied
                            </h1>


                            <p class="mt-4 max-w-sm text-sm leading-7 text-blue-100 sm:text-base">
                                You don't have permission to access this page
                                or perform this action.
                            </p>


                            {{-- Security Notice --}}
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
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                            stroke-width="1.8"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.8"
                                            d="M12 8v4"
                                        />

                                        <circle
                                            cx="12"
                                            cy="16"
                                            r=".8"
                                            fill="currentColor"
                                            stroke="none"
                                        />
                                    </svg>


                                    <div>

                                        <p class="text-sm font-semibold">
                                            Restricted area
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-blue-100">
                                            Your account may not have the required
                                            role or permissions to view this resource.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        RIGHT PANEL
                    ================================================== --}}
                    <div class="flex items-center p-8 sm:p-10 lg:p-12">

                        <div class="w-full">

                            {{-- Error Number --}}
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600"
                            >
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>

                                Permission Required
                            </div>


                            <div class="mt-6">

                                <p class="text-7xl font-black tracking-tight text-slate-100 sm:text-8xl">
                                    403
                                </p>

                                <h2 class="-mt-3 text-2xl font-bold tracking-tight text-slate-900">
                                    You can't access this page
                                </h2>

                                <p class="mt-3 text-sm leading-6 text-slate-500">
                                    The page you're trying to open is protected.
                                    If you believe you should have access, contact
                                    your system administrator.
                                </p>

                            </div>


                            {{-- =================================================
                                ACTION BUTTONS
                            ================================================== --}}
                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                                {{-- Dashboard --}}
                                <a
                                    href="{{ route('dashboard') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
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
                                            d="M3 11.5 12 4l9 7.5"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M5 10v10h14V10"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M9 20v-6h6v6"
                                        />
                                    </svg>

                                    Back to Dashboard

                                </a>


                                {{-- Previous Page --}}
                                <button
                                    type="button"
                                    onclick="window.history.back()"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100"
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
                                            d="M19 12H5m7-7-7 7 7 7"
                                        />
                                    </svg>

                                    Go Back

                                </button>

                            </div>


                            {{-- Help text --}}
                            <div class="mt-8 border-t border-slate-100 pt-6">

                                <div class="flex items-start gap-3">

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                                stroke-width="1.8"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M9.5 9a2.5 2.5 0 0 1 4.7 1.2c0 1.8-2.2 2.1-2.2 3.8"
                                            />

                                            <circle
                                                cx="12"
                                                cy="17"
                                                r=".8"
                                                fill="currentColor"
                                                stroke="none"
                                            />
                                        </svg>
                                    </div>


                                    <div>

                                        <p class="text-sm font-semibold text-slate-800">
                                            Need access?
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-500">
                                            Ask an administrator to verify your
                                            account role and permissions.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <p class="mt-6 text-center text-xs text-slate-400">
                {{ config('app.name') }} · Secure access management
            </p>

        </div>

    </div>


    {{-- Flowbite JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>

</body>

</html>
