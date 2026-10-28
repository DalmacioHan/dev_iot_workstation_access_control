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

    <meta
        name="robots"
        content="noindex, nofollow"
    >

    <title>404 | Page Not Found</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-slate-50 font-sans text-slate-900">


    {{-- =========================================================
        PAGE BACKGROUND
    ========================================================== --}}

    <section
        class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6 lg:px-8"
    >

        {{-- Decorative Background --}}
        <div class="pointer-events-none absolute inset-0">

            <div
                class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-blue-200/40 blur-3xl"
            ></div>

            <div
                class="absolute -bottom-40 -right-32 h-[30rem] w-[30rem] rounded-full bg-indigo-200/35 blur-3xl"
            ></div>

            <div
                class="absolute left-1/2 top-1/2 h-80 w-80 -translate-x-1/2 -translate-y-1/2 rounded-full bg-blue-100/30 blur-3xl"
            ></div>

        </div>



        {{-- =====================================================
            WRAPPER
        ====================================================== --}}

        <div class="relative z-10 w-full max-w-6xl">


            {{-- Main Error Container --}}
            <div
                class="overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white shadow-2xl shadow-slate-200/70"
            >

                <div
                    class="grid min-h-[620px] grid-cols-1 lg:grid-cols-2"
                >


                    {{-- =================================================
                        LEFT ERROR PANEL
                    ================================================== --}}

                    <div
                        class="relative flex items-center overflow-hidden bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 px-8 py-12 text-white sm:px-12 lg:px-16"
                    >

                        {{-- Decorative Shapes --}}
                        <div
                            class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10"
                        ></div>

                        <div
                            class="absolute -bottom-28 -left-24 h-72 w-72 rounded-full bg-blue-400/20"
                        ></div>


                        <div class="relative w-full max-w-lg">


                            {{-- Icon --}}
                            <div
                                class="mb-10 flex h-16 w-16 items-center justify-center rounded-2xl border border-white/15 bg-white/15 shadow-lg backdrop-blur-sm"
                            >

                                <svg
                                    class="h-8 w-8"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <circle
                                        cx="11"
                                        cy="11"
                                        r="6"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.8"
                                        d="m16 16 4 4"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.8"
                                        d="M9 9h4M9 12h2"
                                    />

                                </svg>

                            </div>



                            {{-- Error Code --}}
                            <p
                                class="text-sm font-semibold uppercase tracking-[0.35em] text-blue-100"
                            >
                                Error 404
                            </p>



                            {{-- Heading --}}
                            <h1
                                class="mt-5 text-4xl font-extrabold tracking-tight sm:text-5xl"
                            >
                                Page not found
                            </h1>



                            {{-- Description --}}
                            <p
                                class="mt-5 max-w-md text-base leading-8 text-blue-50/85 sm:text-lg"
                            >
                                We couldn't find the page you're looking for.
                                It may have been moved, deleted, or the address
                                may be incorrect.
                            </p>



                            {{-- Info Card --}}
                            <div
                                class="mt-10 rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur-sm"
                            >

                                <div class="flex items-start gap-4">

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10"
                                    >

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
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

                                            <path
                                                stroke-linecap="round"
                                                stroke-width="2"
                                                d="M12 16h.01"
                                            />

                                        </svg>

                                    </div>


                                    <div>

                                        <p class="text-sm font-semibold text-white">
                                            Page unavailable
                                        </p>

                                        <p
                                            class="mt-1 text-sm leading-6 text-blue-100/80"
                                        >
                                            Check the URL for mistakes or return
                                            to a valid page in Open Learning Hub.
                                        </p>

                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>



                    {{-- =================================================
                        RIGHT DETAILS PANEL
                    ================================================== --}}

                    <div
                        class="flex items-center bg-white px-8 py-12 sm:px-12 lg:px-16"
                    >

                        <div class="w-full">


                            {{-- Status Badge --}}
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2"
                            >

                                <span
                                    class="h-2.5 w-2.5 rounded-full bg-blue-500"
                                ></span>

                                <span
                                    class="text-sm font-semibold text-blue-700"
                                >
                                    Page Not Found
                                </span>

                            </div>



                            {{-- Large Error Number --}}
                            <div class="relative mt-10">

                                <p
                                    class="select-none text-8xl font-black leading-none tracking-tight text-slate-100 sm:text-9xl"
                                >
                                    404
                                </p>


                                <h2
                                    class="-mt-3 text-2xl font-extrabold tracking-tight text-slate-950 sm:text-3xl"
                                >
                                    We couldn't find this page
                                </h2>

                            </div>



                            {{-- Description --}}
                            <p
                                class="mt-5 max-w-md text-base leading-7 text-slate-500"
                            >
                                The page you're trying to open doesn't exist,
                                may have been moved, or is no longer available.
                            </p>



                            {{-- Actions --}}
                            <div
                                class="mt-8 flex flex-col gap-3 sm:flex-row"
                            >

                                <a
                                    href="{{ url('/') }}"
                                    class="group inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-bold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
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
                                            d="M3 11.25 12 4l9 7.25"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M5.25 9.75V20h13.5V9.75"
                                        />

                                    </svg>

                                    Back to Home

                                </a>


                                <button
                                    type="button"
                                    onclick="history.back()"
                                    class="group inline-flex h-12 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-6 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100"
                                >

                                    <svg
                                        class="h-5 w-5 transition-transform group-hover:-translate-x-0.5"
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

                                    Go Back

                                </button>

                            </div>



                            {{-- Divider --}}
                            <div
                                class="my-9 h-px w-full bg-slate-100"
                            ></div>



                            {{-- Help --}}
                            <div class="flex items-start gap-4 mt-5">

                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-500"
                                >

                                    <svg
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
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
                                            d="M9.75 9a2.25 2.25 0 1 1 3.805 1.628c-.76.72-1.555 1.122-1.555 2.372"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="2"
                                            d="M12 16h.01"
                                        />

                                    </svg>

                                </div>


                                <div>

                                    <p
                                        class="font-semibold text-slate-900"
                                    >
                                        Looking for something?
                                    </p>

                                    <p
                                        class="mt-1 max-w-sm text-sm leading-6 text-slate-500"
                                    >
                                        Return to the home page and continue
                                        navigating from there.
                                    </p>

                                </div>

                            </div>


                        </div>

                    </div>


                </div>

            </div>



            {{-- Footer --}}
            <p
                class="mt-7 text-center text-xs text-slate-400"
            >
                IoTWorkstationAccessControl · Secure access management
            </p>


        </div>

    </section>


</body>

</html>
