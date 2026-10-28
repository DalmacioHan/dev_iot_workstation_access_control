
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

    <title>Maintenance | Open Learning Hub</title>

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
            MAINTENANCE CARD
        ====================================================== --}}

        <div class="relative z-10 w-full max-w-md">


            <div
                class="rounded-[2rem] border border-white/20 bg-white/[0.12] p-6 text-center shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-8"
            >


                {{-- =================================================
                    BRAND
                ================================================== --}}

                <div class="mb-7">


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
                    MAINTENANCE ICON
                ================================================== --}}

                <div
                    class="relative mx-auto mb-6 flex h-20 w-20 items-center justify-center"
                >

                    {{-- Soft Glow --}}
                    <div
                        class="absolute inset-0 rounded-full bg-blue-500/20 blur-xl"
                    ></div>


                    <div
                        class="relative flex h-16 w-16 items-center justify-center rounded-2xl border border-blue-300/20 bg-blue-500/15 text-blue-200"
                    >

                        <svg
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
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
                                d="m5.17 8.42-2.58 2.59A4.5 4.5 0 0 0 9 17.4l2.58-2.57"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="m8.5 8.5 7 7"
                            />

                        </svg>

                    </div>

                </div>



                {{-- =================================================
                    STATUS
                ================================================== --}}

                <div
                    class="mb-4 inline-flex items-center gap-2 rounded-full border border-blue-300/20 bg-blue-500/10 px-3 py-1.5"
                >

                    <span class="relative flex h-2 w-2">

                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-60"
                        ></span>

                        <span
                            class="relative inline-flex h-2 w-2 rounded-full bg-blue-400"
                        ></span>

                    </span>

                    <span
                        class="text-xs font-semibold text-blue-100"
                    >
                        System Maintenance
                    </span>

                </div>



                {{-- =================================================
                    ERROR CODE
                ================================================== --}}

                <p
                    class="text-xs font-bold uppercase tracking-[0.3em] text-blue-200/70"
                >
                    Service 503
                </p>



                {{-- =================================================
                    HEADING
                ================================================== --}}

                <h1
                    class="mt-3 text-3xl font-extrabold tracking-tight text-white"
                >
                    We'll be back soon
                </h1>



                {{-- =================================================
                    DESCRIPTION
                ================================================== --}}

                <p
                    class="mx-auto mt-3 max-w-sm text-sm leading-6 text-white/65"
                >
                    Open Learning Hub is currently undergoing scheduled maintenance.
                    We're working to restore access as soon as possible.
                </p>



                {{-- =================================================
                    MAINTENANCE INFORMATION
                ================================================== --}}

                <div
                    class="mt-6 flex items-start gap-3 rounded-2xl border border-white/10 bg-white/5 p-4 text-left"
                >

                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-500/15 text-blue-200"
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
                                d="M12 6v6l4 2"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.8"
                            />

                        </svg>

                    </div>


                    <div>

                        <p
                            class="text-sm font-semibold text-white"
                        >
                            Temporary service interruption
                        </p>

                        <p
                            class="mt-1 text-xs leading-5 text-white/50"
                        >
                            Workstation access and account services may be
                            temporarily unavailable while maintenance is in progress.
                        </p>

                    </div>

                </div>



                {{-- =================================================
                    RETRY BUTTON
                ================================================== --}}

                <div class="mt-7">


                    <button
                        type="button"
                        onclick="window.location.reload()"
                        class="group flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-bold text-white shadow-lg shadow-blue-900/30 transition hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300/30"
                    >

                        <svg
                            class="h-5 w-5 transition-transform duration-300 group-hover:rotate-180"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M16.023 9.348h4.992V4.356"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M21.015 9.348A9 9 0 1 0 18.36 18"
                            />

                        </svg>

                        Check Again

                    </button>


                </div>



                {{-- =================================================
                    SMALL MESSAGE
                ================================================== --}}

                <p
                    class="mt-5 text-xs leading-5 text-white/40"
                >
                    Please try again in a few moments.
                    Thank you for your patience.
                </p>


            </div>



            {{-- Footer --}}
            <p
                class="mt-5 text-center text-xs text-white/40"
            >
                Open Learning Hub · Secure Digital Access
            </p>


        </div>

    </section>


</body>

</html>
