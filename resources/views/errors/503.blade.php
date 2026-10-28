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

    <title>503 | Under Maintenance</title>

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
                        LEFT MAINTENANCE PANEL
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

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M11.42 15.17 17.25 21a2.121 2.121 0 0 0 3-3l-5.84-5.84"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M14.83 8.58 17.4 6A4.5 4.5 0 0 0 11 2.6L8.42 5.17"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M5.17 8.42 2.59 11.01A4.5 4.5 0 0 0 9 17.4l2.58-2.57"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.8"
                                        d="m8.5 8.5 7 7"
                                    />

                                </svg>

                            </div>



                            {{-- Error Code --}}
                            <p
                                class="text-sm font-semibold uppercase tracking-[0.35em] text-blue-100"
                            >
                                Service 503
                            </p>



                            {{-- Heading --}}
                            <h1
                                class="mt-5 text-4xl font-extrabold tracking-tight sm:text-5xl"
                            >
                                Under maintenance
                            </h1>



                            {{-- Description --}}
                            <p
                                class="mt-5 max-w-md text-base leading-8 text-blue-50/85 sm:text-lg"
                            >
                                Open Learning Hub is temporarily unavailable
                                while we perform system maintenance and updates.
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
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M12 7.5V12l3 2"
                                            />

                                        </svg>

                                    </div>


                                    <div>

                                        <p class="text-sm font-semibold text-white">
                                            Maintenance in progress
                                        </p>

                                        <p
                                            class="mt-1 text-sm leading-6 text-blue-100/80"
                                        >
                                            Workstation access and account services
                                            are temporarily unavailable.
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
                                class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-4 py-2"
                            >

                                <span class="relative flex h-2.5 w-2.5">

                                    <span
                                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-amber-400 opacity-60"
                                    ></span>

                                    <span
                                        class="relative inline-flex h-2.5 w-2.5 rounded-full bg-amber-500"
                                    ></span>

                                </span>

                                <span
                                    class="text-sm font-semibold text-amber-700"
                                >
                                    Maintenance in Progress
                                </span>

                            </div>



                            {{-- Large Error Number --}}
                            <div class="relative mt-10">

                                <p
                                    class="select-none text-8xl font-black leading-none tracking-tight text-slate-100 sm:text-9xl"
                                >
                                    503
                                </p>


                                <h2
                                    class="-mt-3 text-2xl font-extrabold tracking-tight text-slate-950 sm:text-3xl"
                                >
                                    We'll be back soon
                                </h2>

                            </div>



                            {{-- Description --}}
                            <p
                                class="mt-5 max-w-md text-base leading-7 text-slate-500"
                            >
                                We're currently performing maintenance to improve
                                the system. Access will return once the maintenance
                                process has been completed.
                            </p>



                            {{-- Actions --}}
                            <div class="mt-8">

                                <button
                                    type="button"
                                    onclick="window.location.reload()"
                                    class="group inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-bold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
                                >

                                    <svg
                                        class="h-5 w-5 transition-transform duration-500 group-hover:rotate-180"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M20 7v5h-5"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M19 12a7 7 0 1 0-2.05 4.95"
                                        />

                                    </svg>

                                    Check Again

                                </button>

                            </div>



                            {{-- Divider --}}
                            <div
                                class="my-9 h-px w-full bg-slate-100"
                            ></div>



                            {{-- Information --}}
                            <div class="flex items-start gap-4 mt-6">

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
                                            d="M12 7.5V12l3 2"
                                        />

                                    </svg>

                                </div>


                                <div>

                                    <p
                                        class="font-semibold text-slate-900"
                                    >
                                        What's happening?
                                    </p>

                                    <p
                                        class="mt-1 max-w-sm text-sm leading-6 text-slate-500"
                                    >
                                        The system has been temporarily placed
                                        offline so administrators can safely
                                        perform updates and maintenance.
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
