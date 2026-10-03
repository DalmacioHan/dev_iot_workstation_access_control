<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IoT Workstation Access Control</title>

    <meta
        name="description"
        content="Securely authenticate, authorize, and monitor access to IoT-enabled workstations."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background:
                radial-gradient(
                    circle at 18% 8%,
                    rgba(59, 130, 246, 0.14),
                    transparent 30rem
                ),
                radial-gradient(
                    circle at 85% 35%,
                    rgba(99, 102, 241, 0.10),
                    transparent 30rem
                ),
                #020617;
        }

        .grid-bg {
            background-image:
                linear-gradient(
                    rgba(255, 255, 255, 0.025) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0.025) 1px,
                    transparent 1px
                );

            background-size: 48px 48px;
        }

        .glass {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .hero-item,
        .workstation-node,
        .reveal {
            opacity: 0;
        }

        .connection-line {
            transform-origin: left;
            transform: scaleX(0);
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden bg-slate-950 text-white antialiased selection:bg-blue-500 selection:text-white">

{{-- Background Grid --}}
<div class="pointer-events-none fixed inset-0 -z-10 grid-bg"></div>

{{-- ============================================================ --}}
{{-- NAVBAR --}}
{{-- ============================================================ --}}
<nav class="fixed top-0 z-50 w-full border-b border-white/10 bg-slate-950/70 backdrop-blur-xl">

    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between px-4 py-4 lg:px-8">

        {{-- Brand --}}
        <a href="/" class="flex items-center gap-3">

            <div
                class="flex h-11 w-11 items-center justify-center overflow-hidden
                       rounded-2xl border border-white/20 bg-white/10
                       shadow-lg backdrop-blur-sm"
            >
                <img
                    src="{{ asset('image/library_logo.jpg') }}"
                    alt="Open Learning Hub Logo"
                    class="h-full w-full object-cover"
                >
            </div>

            <div>
                <span class="block text-sm font-bold tracking-wide text-white">
                    Open Learning Hub
                </span>

                <span class="block text-[10px] uppercase tracking-[0.22em] text-blue-200/60">
                    Workstation Access
                </span>
            </div>

        </a>

        {{-- Mobile Button --}}
        <button
            data-collapse-toggle="navbar-menu"
            type="button"
            class="inline-flex h-10 w-10 items-center justify-center
                   rounded-xl border border-white/10 bg-white/5
                   text-white/70 transition hover:bg-white/10
                   focus:outline-none focus:ring-4 focus:ring-blue-500/20 md:hidden"
            aria-controls="navbar-menu"
            aria-expanded="false"
        >
            <span class="sr-only">Open navigation</span>

            <svg
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>

        {{-- Navigation --}}
        <div class="hidden w-full md:block md:w-auto" id="navbar-menu">

            <div
                class="mt-4 flex flex-col gap-2 rounded-2xl
                       border border-white/10 bg-slate-950/90 p-4
                       md:mt-0 md:flex-row md:items-center
                       md:border-0 md:bg-transparent md:p-0"
            >

                <a
                    href="#features"
                    class="rounded-lg px-4 py-2 text-sm text-white/60
                           transition hover:bg-white/5 hover:text-white"
                >
                    Features
                </a>

                <a
                    href="#workflow"
                    class="rounded-lg px-4 py-2 text-sm text-white/60
                           transition hover:bg-white/5 hover:text-white"
                >
                    Workflow
                </a>

                <a
                    href="#security"
                    class="rounded-lg px-4 py-2 text-sm text-white/60
                           transition hover:bg-white/5 hover:text-white"
                >
                    Security
                </a>

                <a
                    href="{{ route('login') }}"
                    class="md:ml-3 inline-flex items-center justify-center
                           rounded-xl bg-blue-600 px-5 py-2.5
                           text-sm font-bold text-white
                           shadow-lg shadow-blue-900/30
                           transition hover:bg-blue-500
                           focus:ring-4 focus:ring-blue-400/20"
                >
                    Sign in
                </a>

            </div>
        </div>
    </div>
</nav>

<main>

    {{-- ============================================================ --}}
    {{-- HERO --}}
    {{-- ============================================================ --}}
    <section class="relative overflow-hidden pt-32 lg:pt-40">

        {{-- Blue glow --}}
        <div
            class="pointer-events-none absolute -left-40 top-10
                   h-[30rem] w-[30rem] rounded-full
                   bg-blue-500/10 blur-3xl"
        ></div>

        {{-- Indigo glow --}}
        <div
            class="pointer-events-none absolute -right-40 top-72
                   h-[30rem] w-[30rem] rounded-full
                   bg-indigo-500/10 blur-3xl"
        ></div>

        <div
            class="mx-auto grid max-w-7xl items-center gap-16
                   px-4 pb-24 lg:grid-cols-2 lg:px-8 lg:pb-32"
        >

            {{-- Hero Copy --}}
            <div>

                <div
                    class="hero-item mb-6 inline-flex items-center gap-2
                           rounded-full border border-blue-300/20
                           bg-blue-500/10 px-3 py-1.5
                           text-xs font-semibold text-blue-200"
                >
                    <span class="relative flex h-2 w-2">

                        <span
                            class="status-ping absolute inline-flex h-full w-full
                                   rounded-full bg-blue-400 opacity-75"
                        ></span>

                        <span
                            class="relative inline-flex h-2 w-2
                                   rounded-full bg-blue-400"
                        ></span>

                    </span>

                    Secure workstation infrastructure online
                </div>

                <h1
                    class="hero-item max-w-3xl text-4xl font-extrabold
                           tracking-tight text-white sm:text-5xl
                           lg:text-6xl xl:text-7xl"
                >
                    Secure access to your

                    <span
                        class="bg-gradient-to-r from-blue-200
                               via-blue-400 to-indigo-400
                               bg-clip-text text-transparent"
                    >
                        IoT workstations.
                    </span>
                </h1>

                <p
                    class="hero-item mt-6 max-w-xl text-base
                           leading-8 text-white/60 sm:text-lg"
                >
                    A private workstation access platform for authenticating users,
                    enforcing role-based permissions, managing IoT-enabled computers,
                    and maintaining complete security audit records.
                </p>

                {{-- Buttons --}}
                <div class="hero-item mt-8 flex flex-col gap-3 sm:flex-row">

                    <a
                        href="{{ route('login') }}"
                        class="group inline-flex items-center justify-center gap-2
                               rounded-xl bg-blue-600 px-6 py-3.5
                               text-sm font-bold text-white
                               shadow-lg shadow-blue-900/30
                               transition hover:bg-blue-500
                               hover:shadow-blue-500/20"
                    >
                        Access workstation

                        <svg
                            class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                            />
                        </svg>
                    </a>

                    <button
                        data-modal-target="workflow-modal"
                        data-modal-toggle="workflow-modal"
                        type="button"
                        class="inline-flex items-center justify-center gap-2
                               rounded-xl border border-white/15
                               bg-white/5 px-6 py-3.5
                               text-sm font-semibold text-white
                               backdrop-blur-sm transition
                               hover:border-white/25 hover:bg-white/10"
                    >

                        <svg
                            class="h-4 w-4 text-blue-300"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5.25 5.25v13.5l11.25-6.75L5.25 5.25Z"
                            />
                        </svg>

                        How it works
                    </button>

                </div>

                {{-- Mini statistics --}}
                <div class="hero-item mt-10 grid max-w-lg grid-cols-3 gap-4">

                    <div>
                        <p class="text-lg font-bold text-white">
                            RBAC
                        </p>

                        <p class="mt-1 text-xs text-white/40">
                            Role permissions
                        </p>
                    </div>

                    <div class="border-x border-white/10 px-4">
                        <p class="text-lg font-bold text-white">
                            24/7
                        </p>

                        <p class="mt-1 text-xs text-white/40">
                            Audit tracking
                        </p>
                    </div>

                    <div>
                        <p class="text-lg font-bold text-white">
                            IoT
                        </p>

                        <p class="mt-1 text-xs text-white/40">
                            Device control
                        </p>
                    </div>

                </div>

            </div>

            {{-- ============================================================ --}}
            {{-- WORKSTATION PANEL --}}
            {{-- ============================================================ --}}
            <div class="hero-item relative mx-auto w-full max-w-xl">

                <div
                    class="absolute -inset-12 -z-10
                           rounded-full bg-blue-500/10 blur-3xl"
                ></div>

                <div
                    class="overflow-hidden rounded-[2rem]
                           border border-white/15 bg-white/[0.07]
                           shadow-2xl shadow-black/30
                           backdrop-blur-xl"
                >

                    {{-- Window Header --}}
                    <div
                        class="flex items-center justify-between
                               border-b border-white/10 px-5 py-4"
                    >

                        <div class="flex gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-red-400/70"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-400/70"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-blue-400/70"></span>
                        </div>

                        <span
                            class="font-mono text-[10px]
                                   tracking-wider text-white/35"
                        >
                            ACCESS-CONTROL / LIVE
                        </span>

                    </div>

                    <div class="p-5 sm:p-7">

                        {{-- Panel heading --}}
                        <div class="mb-7 flex items-center justify-between">

                            <div>
                                <p
                                    class="text-xs uppercase tracking-[0.18em]
                                           text-white/35"
                                >
                                    Workstation network
                                </p>

                                <h3 class="mt-1 font-semibold text-white">
                                    Device availability
                                </h3>
                            </div>

                            <div
                                class="flex items-center gap-2 rounded-lg
                                       border border-blue-400/20
                                       bg-blue-500/10 px-3 py-2"
                            >
                                <span
                                    class="device-pulse h-2 w-2
                                           rounded-full bg-blue-400"
                                ></span>

                                <span class="text-xs text-blue-200">
                                    Connected
                                </span>
                            </div>

                        </div>

                        {{-- Server --}}
                        <div class="mb-5 flex justify-center">

                            <div
                                id="server-node"
                                class="flex h-20 w-20 items-center justify-center
                                       rounded-2xl border border-blue-400/30
                                       bg-blue-500/10
                                       shadow-lg shadow-blue-500/10"
                            >

                                <svg
                                    class="h-8 w-8 text-blue-300"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.75 3h10.5A1.75 1.75 0 0 1 19 4.75v14.5A1.75 1.75 0 0 1 17.25 21H6.75A1.75 1.75 0 0 1 5 19.25V4.75A1.75 1.75 0 0 1 6.75 3Z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M8 7h8M8 11h8M8 15h4"
                                    />
                                </svg>

                            </div>
                        </div>

                        {{-- Connection --}}
                        <div
                            class="mx-auto mb-5 h-px w-3/4
                                   bg-white/10"
                        >
                            <div
                                class="connection-line h-px w-full
                                       bg-gradient-to-r
                                       from-transparent
                                       via-blue-400
                                       to-transparent"
                            ></div>
                        </div>

                        {{-- Devices --}}
                        <div class="grid grid-cols-3 gap-3">

                            {{-- WS1 --}}
                            <div
                                class="workstation-node rounded-xl
                                       border border-white/10
                                       bg-slate-950/40 p-4"
                            >

                                <div class="mb-4 flex items-center justify-between">

                                    <svg
                                        class="h-5 w-5 text-white/50"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M4 5.75A1.75 1.75 0 0 1 5.75 4h12.5A1.75 1.75 0 0 1 20 5.75v8.5A1.75 1.75 0 0 1 18.25 16H5.75A1.75 1.75 0 0 1 4 14.25v-8.5ZM9 20h6M12 16v4"
                                        />
                                    </svg>

                                    <span
                                        class="h-2 w-2 rounded-full bg-blue-400"
                                    ></span>

                                </div>

                                <p class="text-xs font-semibold text-white">
                                    WS-01
                                </p>

                                <p class="mt-1 text-[10px] text-blue-300">
                                    Available
                                </p>

                            </div>

                            {{-- WS2 --}}
                            <div
                                class="workstation-node rounded-xl
                                       border border-blue-400/30
                                       bg-blue-500/10 p-4"
                            >

                                <div class="mb-4 flex items-center justify-between">

                                    <svg
                                        class="h-5 w-5 text-blue-300"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M4 5.75A1.75 1.75 0 0 1 5.75 4h12.5A1.75 1.75 0 0 1 20 5.75v8.5A1.75 1.75 0 0 1 18.25 16H5.75A1.75 1.75 0 0 1 4 14.25v-8.5ZM9 20h6M12 16v4"
                                        />
                                    </svg>

                                    <span
                                        class="device-pulse h-2 w-2
                                               rounded-full bg-blue-400"
                                    ></span>

                                </div>

                                <p class="text-xs font-semibold text-white">
                                    WS-02
                                </p>

                                <p class="mt-1 text-[10px] text-blue-200">
                                    In use
                                </p>

                            </div>

                            {{-- WS3 --}}
                            <div
                                class="workstation-node rounded-xl
                                       border border-white/10
                                       bg-slate-950/40 p-4"
                            >

                                <div class="mb-4 flex items-center justify-between">

                                    <svg
                                        class="h-5 w-5 text-white/50"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M4 5.75A1.75 1.75 0 0 1 5.75 4h12.5A1.75 1.75 0 0 1 20 5.75v8.5A1.75 1.75 0 0 1 18.25 16H5.75A1.75 1.75 0 0 1 4 14.25v-8.5ZM9 20h6M12 16v4"
                                        />
                                    </svg>

                                    <span
                                        class="h-2 w-2 rounded-full bg-indigo-400"
                                    ></span>

                                </div>

                                <p class="text-xs font-semibold text-white">
                                    WS-03
                                </p>

                                <p class="mt-1 text-[10px] text-indigo-300">
                                    Reserved
                                </p>

                            </div>

                        </div>

                        {{-- Authorization Event --}}
                        <div
                            class="mt-5 rounded-xl border border-white/10
                                   bg-white/5 p-4"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center
                                           justify-center rounded-lg
                                           bg-blue-500/10 text-blue-300"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m5 12 4 4L19 6"
                                        />
                                    </svg>
                                </div>

                                <div class="min-w-0 flex-1">

                                    <p class="text-xs font-medium text-white">
                                        Access authorization verified
                                    </p>

                                    <p class="mt-1 text-[10px] text-white/40">
                                        Security event recorded in audit log
                                    </p>

                                </div>

                                <span
                                    class="rounded-md bg-blue-500/10
                                           px-2 py-1 text-[10px]
                                           font-semibold text-blue-300"
                                >
                                    GRANTED
                                </span>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FEATURES --}}
    {{-- ============================================================ --}}
    <section
        id="features"
        class="border-y border-white/10 bg-white/[0.02] py-24"
    >

        <div class="mx-auto max-w-7xl px-4 lg:px-8">

            <div class="reveal max-w-2xl">

                <p
                    class="text-sm font-bold uppercase
                           tracking-[0.2em] text-blue-300"
                >
                    Access infrastructure
                </p>

                <h2
                    class="mt-4 text-3xl font-bold tracking-tight
                           text-white sm:text-4xl"
                >
                    Control physical workstation access from one platform.
                </h2>

                <p class="mt-4 leading-7 text-white/55">
                    Authentication, permissions, IoT device states, and access
                    records are managed through one secure interface.
                </p>

            </div>

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Authentication --}}
                <article
                    class="reveal rounded-3xl border border-white/10
                           bg-white/[0.05] p-6 backdrop-blur-sm
                           transition duration-300
                           hover:-translate-y-1
                           hover:border-blue-400/30
                           hover:bg-white/[0.08]"
                >

                    <div
                        class="mb-5 flex h-11 w-11 items-center
                               justify-center rounded-xl
                               bg-blue-500/10 text-blue-300"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 8.25V6a3.75 3.75 0 0 0-7.5 0v2.25M6.75 8.25h10.5A1.75 1.75 0 0 1 19 10v8.25A1.75 1.75 0 0 1 17.25 20H6.75A1.75 1.75 0 0 1 5 18.25V10a1.75 1.75 0 0 1 1.75-1.75Z"
                            />
                        </svg>
                    </div>

                    <h3 class="font-semibold text-white">
                        Authentication
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-white/50">
                        Verify user identity before allowing access to protected
                        workstation resources.
                    </p>

                </article>

                {{-- RBAC --}}
                <article
                    class="reveal rounded-3xl border border-white/10
                           bg-white/[0.05] p-6 backdrop-blur-sm
                           transition duration-300
                           hover:-translate-y-1
                           hover:border-blue-400/30
                           hover:bg-white/[0.08]"
                >

                    <div
                        class="mb-5 flex h-11 w-11 items-center
                               justify-center rounded-xl
                               bg-blue-500/10 text-blue-300"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 18.75a6 6 0 0 0-12 0M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6.75-1.5 1.5 1.5 2.25-2.75"
                            />
                        </svg>
                    </div>

                    <h3 class="font-semibold text-white">
                        Role permissions
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-white/50">
                        Separate staff and administrator privileges using
                        role-based authorization.
                    </p>

                </article>

                {{-- IoT --}}
                <article
                    class="reveal rounded-3xl border border-white/10
                           bg-white/[0.05] p-6 backdrop-blur-sm
                           transition duration-300
                           hover:-translate-y-1
                           hover:border-indigo-400/30
                           hover:bg-white/[0.08]"
                >

                    <div
                        class="mb-5 flex h-11 w-11 items-center
                               justify-center rounded-xl
                               bg-indigo-500/10 text-indigo-300"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 12a3.75 3.75 0 0 1 7.5 0m-10.5-3a8.25 8.25 0 0 1 13.5 0M12 15.75h.008v.008H12v-.008ZM12 20v-4.25"
                            />
                        </svg>
                    </div>

                    <h3 class="font-semibold text-white">
                        IoT integration
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-white/50">
                        Coordinate application authorization with connected
                        workstation hardware and devices.
                    </p>

                </article>

                {{-- Auditing --}}
                <article
                    class="reveal rounded-3xl border border-white/10
                           bg-white/[0.05] p-6 backdrop-blur-sm
                           transition duration-300
                           hover:-translate-y-1
                           hover:border-blue-400/30
                           hover:bg-white/[0.08]"
                >

                    <div
                        class="mb-5 flex h-11 w-11 items-center
                               justify-center rounded-xl
                               bg-blue-500/10 text-blue-300"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 5.25h6M9 9h6m-6 3.75h3M6.75 3h10.5A1.75 1.75 0 0 1 19 4.75v14.5A1.75 1.75 0 0 1 17.25 21H6.75A1.75 1.75 0 0 1 5 19.25V4.75A1.75 1.75 0 0 1 6.75 3Z"
                            />
                        </svg>
                    </div>

                    <h3 class="font-semibold text-white">
                        Access auditing
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-white/50">
                        Record authorization attempts and workstation activity
                        for future security review.
                    </p>

                </article>

            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- WORKFLOW --}}
    {{-- ============================================================ --}}
    <section id="workflow" class="py-24">

        <div class="mx-auto max-w-7xl px-4 lg:px-8">

            <div class="reveal text-center">

                <p
                    class="text-sm font-bold uppercase
                           tracking-[0.2em] text-blue-300"
                >
                    Authorization workflow
                </p>

                <h2
                    class="mx-auto mt-4 max-w-2xl text-3xl
                           font-bold text-white sm:text-4xl"
                >
                    From identity verification to physical access.
                </h2>

            </div>

            <div class="mt-16 grid gap-6 lg:grid-cols-3">

                @foreach ([
                    [
                        'number' => '01',
                        'title' => 'Authenticate',
                        'description' => 'The user signs in through the Laravel application and their identity is validated.'
                    ],
                    [
                        'number' => '02',
                        'title' => 'Authorize',
                        'description' => 'Roles, permissions, and workstation availability are checked before access is approved.'
                    ],
                    [
                        'number' => '03',
                        'title' => 'Access & audit',
                        'description' => 'The workstation receives the authorization state while the event is recorded for auditing.'
                    ]
                ] as $step)

                    <div
                        class="reveal rounded-3xl border border-white/10
                               bg-white/[0.05] p-7
                               backdrop-blur-sm transition
                               hover:border-blue-400/30
                               hover:bg-white/[0.08]"
                    >

                        <span
                            class="mb-6 inline-flex h-9 w-9
                                   items-center justify-center
                                   rounded-full bg-blue-600
                                   text-sm font-bold text-white
                                   shadow-lg shadow-blue-900/30"
                        >
                            {{ $step['number'] }}
                        </span>

                        <h3 class="text-lg font-semibold text-white">
                            {{ $step['title'] }}
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-white/50">
                            {{ $step['description'] }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- SECURITY --}}
    {{-- ============================================================ --}}
    <section id="security" class="pb-24">

        <div class="mx-auto max-w-7xl px-4 lg:px-8">

            <div
                class="reveal overflow-hidden rounded-[2rem]
                       border border-white/15
                       bg-gradient-to-br
                       from-blue-950/60
                       via-slate-950/60
                       to-indigo-950/50
                       shadow-2xl shadow-black/20
                       backdrop-blur-xl"
            >

                <div
                    class="grid items-center gap-10 p-8
                           md:p-12 lg:grid-cols-2 lg:p-16"
                >

                    <div>

                        <div
                            class="mb-5 inline-flex items-center gap-2
                                   rounded-lg border border-blue-300/20
                                   bg-blue-500/10 px-3 py-2
                                   text-xs font-semibold text-blue-200"
                        >

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M12 3l7.5 3v5.25c0 4.695-3.177 8.927-7.5 9.75-4.323-.823-7.5-5.055-7.5-9.75V6L12 3Z"
                                />
                            </svg>

                            Security-first architecture
                        </div>

                        <h2
                            class="text-3xl font-bold text-white sm:text-4xl"
                        >
                            Access only after authorization checks succeed.
                        </h2>

                        <p
                            class="mt-5 max-w-xl leading-7 text-white/55"
                        >
                            Keep workstation access behind authenticated sessions,
                            server-side authorization, role checks, and traceable
                            audit records.
                        </p>

                    </div>

                    <div class="space-y-3">

                        @foreach ([
                            'Authenticated application sessions',
                            'Staff and administrator role separation',
                            'Server-side access authorization',
                            'Workstation availability verification',
                            'Security audit and access history'
                        ] as $item)

                            <div
                                class="flex items-center gap-3 rounded-xl
                                       border border-white/10
                                       bg-white/[0.05] p-4"
                            >

                                <span
                                    class="flex h-8 w-8 shrink-0
                                           items-center justify-center
                                           rounded-lg bg-blue-500/10
                                           text-blue-300"
                                >

                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m5 12 4 4L19 6"
                                        />
                                    </svg>

                                </span>

                                <span class="text-sm text-white/70">
                                    {{ $item }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CTA --}}
    {{-- ============================================================ --}}
    <section class="border-t border-white/10 py-20">

        <div class="mx-auto max-w-3xl px-4 text-center">

            <div class="reveal">

                <p
                    class="mb-3 text-xs font-bold uppercase
                           tracking-[0.25em] text-blue-300"
                >
                    Secure access portal
                </p>

                <h2 class="text-3xl font-bold text-white">
                    Authorized personnel only.
                </h2>

                <p
                    class="mx-auto mt-4 max-w-xl
                           leading-relaxed text-white/50"
                >
                    Sign in with your authorized account to view available
                    workstations and request access.
                </p>

                <a
                    href="{{ route('login') }}"
                    class="mt-8 inline-flex items-center gap-2
                           rounded-xl bg-blue-600 px-7 py-3.5
                           text-sm font-bold text-white
                           shadow-lg shadow-blue-900/30
                           transition hover:bg-blue-500
                           focus:ring-4 focus:ring-blue-400/20"
                >
                    Continue to secure login

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                        />
                    </svg>

                </a>

            </div>
        </div>
    </section>

</main>

{{-- ============================================================ --}}
{{-- FOOTER --}}
{{-- ============================================================ --}}
<footer class="border-t border-white/10 bg-slate-950/70">

    <div
        class="mx-auto flex max-w-7xl flex-col gap-4
               px-4 py-8 sm:flex-row sm:items-center
               sm:justify-between lg:px-8"
    >

        <div class="flex items-center gap-3">

            <div
                class="h-8 w-8 overflow-hidden rounded-lg
                       border border-white/15"
            >
                <img
                    src="{{ asset('image/library_logo.jpg') }}"
                    class="h-full w-full object-cover"
                    alt=""
                >
            </div>

            <span class="text-sm font-semibold text-white/70">
                Open Learning Hub
            </span>

        </div>

        <p class="text-xs text-white/30">
            IoT Workstation Access Control · Authorized access only
        </p>

    </div>
</footer>

{{-- ============================================================ --}}
{{-- WORKFLOW MODAL --}}
{{-- ============================================================ --}}
<div
    id="workflow-modal"
    tabindex="-1"
    aria-hidden="true"
    class="fixed left-0 right-0 top-0 z-[60]
           hidden h-[calc(100%-1rem)] max-h-full
           w-full items-center justify-center
           overflow-y-auto overflow-x-hidden
           p-4 md:inset-0"
>

    <div class="relative max-h-full w-full max-w-lg">

        <div
            class="relative rounded-3xl border border-white/15
                   bg-slate-950/90 shadow-2xl
                   backdrop-blur-xl"
        >

            <div
                class="flex items-center justify-between
                       border-b border-white/10 p-5"
            >

                <div>
                    <h3 class="font-semibold text-white">
                        Access workflow
                    </h3>

                    <p class="mt-1 text-xs text-white/40">
                        Secure workstation authorization
                    </p>
                </div>

                <button
                    type="button"
                    data-modal-hide="workflow-modal"
                    class="inline-flex h-9 w-9 items-center
                           justify-center rounded-lg
                           text-white/50 transition
                           hover:bg-white/10 hover:text-white"
                >

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>

                    <span class="sr-only">
                        Close
                    </span>

                </button>

            </div>

            <div class="space-y-5 p-6">

                @foreach ([
                    ['1', 'User authentication', 'Laravel verifies the authenticated user session.'],
                    ['2', 'Permission check', 'The backend evaluates user role and workstation permissions.'],
                    ['3', 'IoT authorization', 'An authorized request enables the appropriate workstation.'],
                    ['4', 'Audit logging', 'The access event is stored for monitoring and security review.']
                ] as $step)

                    <div class="flex gap-4">

                        <span
                            class="flex h-8 w-8 shrink-0
                                   items-center justify-center
                                   rounded-full bg-blue-600
                                   text-xs font-bold text-white"
                        >
                            {{ $step[0] }}
                        </span>

                        <div>

                            <h4 class="text-sm font-semibold text-white">
                                {{ $step[1] }}
                            </h4>

                            <p class="mt-1 text-sm text-white/50">
                                {{ $step[2] }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="border-t border-white/10 p-5">

                <a
                    href="{{ route('login') }}"
                    class="inline-flex w-full justify-center
                           rounded-xl bg-blue-600 px-5 py-3
                           text-sm font-bold text-white
                           shadow-lg shadow-blue-900/30
                           transition hover:bg-blue-500"
                >
                    Sign in
                </a>

            </div>

        </div>
    </div>
</div>

{{-- Anime.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const reduceMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    if (reduceMotion) {

        document
            .querySelectorAll('.hero-item, .workstation-node, .reveal')
            .forEach((element) => {
                element.style.opacity = 1;
            });

        document
            .querySelectorAll('.connection-line')
            .forEach((element) => {
                element.style.transform = 'scaleX(1)';
            });

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Hero entrance
    |--------------------------------------------------------------------------
    */

    anime({
        targets: '.hero-item',
        opacity: [0, 1],
        translateY: [24, 0],
        duration: 850,
        delay: anime.stagger(110),
        easing: 'easeOutExpo'
    });

    /*
    |--------------------------------------------------------------------------
    | Workstation entrance
    |--------------------------------------------------------------------------
    */

    anime({
        targets: '.workstation-node',
        opacity: [0, 1],
        translateY: [18, 0],
        scale: [0.94, 1],
        duration: 650,
        delay: anime.stagger(140, {
            start: 750
        }),
        easing: 'easeOutExpo'
    });

    /*
    |--------------------------------------------------------------------------
    | IoT connection animation
    |--------------------------------------------------------------------------
    */

    anime({
        targets: '.connection-line',
        scaleX: [0, 1],
        opacity: [0, 1],
        duration: 1200,
        delay: 700,
        easing: 'easeInOutQuart'
    });

    /*
    |--------------------------------------------------------------------------
    | Server pulse
    |--------------------------------------------------------------------------
    */

    anime({
        targets: '#server-node',

        boxShadow: [
            '0 0 0px rgba(59, 130, 246, 0)',
            '0 0 32px rgba(59, 130, 246, 0.28)',
            '0 0 0px rgba(59, 130, 246, 0)'
        ],

        duration: 2400,
        easing: 'easeInOutSine',
        loop: true
    });

    /*
    |--------------------------------------------------------------------------
    | Device pulse
    |--------------------------------------------------------------------------
    */

    anime({
        targets: '.device-pulse',
        scale: [1, 1.7, 1],
        opacity: [1, 0.35, 1],
        duration: 1800,
        easing: 'easeInOutSine',
        loop: true
    });

    /*
    |--------------------------------------------------------------------------
    | Online status ping
    |--------------------------------------------------------------------------
    */

    anime({
        targets: '.status-ping',
        scale: [1, 2.2],
        opacity: [0.7, 0],
        duration: 1600,
        easing: 'easeOutExpo',
        loop: true
    });

    /*
    |--------------------------------------------------------------------------
    | Scroll reveal
    |--------------------------------------------------------------------------
    */

    const revealObserver = new IntersectionObserver(
        (entries, observer) => {

            entries.forEach((entry) => {

                if (!entry.isIntersecting) {
                    return;
                }

                anime({
                    targets: entry.target,
                    opacity: [0, 1],
                    translateY: [30, 0],
                    duration: 750,
                    easing: 'easeOutExpo'
                });

                observer.unobserve(entry.target);
            });

        },
        {
            threshold: 0.15
        }
    );

    document
        .querySelectorAll('.reveal')
        .forEach((element) => {
            revealObserver.observe(element);
        });

});
</script>

</body>
</html>