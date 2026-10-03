
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Reset Password</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.css"
        rel="stylesheet"
    >

</head>


<body class="min-h-screen bg-slate-50 font-sans text-slate-900">

<div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10">

    {{-- Background --}}
    <div class="pointer-events-none absolute inset-0">

        <div
            class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-blue-200/30 blur-3xl"
        ></div>

        <div
            class="absolute -bottom-40 -right-32 h-[28rem] w-[28rem] rounded-full bg-indigo-200/30 blur-3xl"
        ></div>

    </div>


    {{-- Card --}}
    <div class="relative z-10 w-full max-w-md">

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60">

            {{-- Header --}}
            <div class="px-6 pb-2 pt-8 text-center sm:px-8 sm:pt-10">

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-200"
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
                            d="M15 7a5 5 0 10-9.9 1H3a1 1 0 00-1 1v3a1 1 0 001 1h2v2h2v2h2v2h3v-3.172l5.414-5.414A4.98 4.98 0 0015 7Z"
                        />

                        <circle
                            cx="10"
                            cy="7"
                            r="1"
                            fill="currentColor"
                            stroke="none"
                        />
                    </svg>

                </div>


                <h1 class="mt-6 text-2xl font-bold text-slate-900">
                    Reset your password
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Create a new password for your account.
                </p>

            </div>


            {{-- Form --}}
            <div class="px-6 pb-8 pt-7 sm:px-8 sm:pb-10">

                @if ($errors->any())

                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4">

                        <div class="flex gap-3">

                            <svg
                                class="h-5 w-5 shrink-0 text-red-500"
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

                            <div>

                                <p class="text-sm font-semibold text-red-800">
                                    Unable to reset password
                                </p>

                                <ul class="mt-1 list-inside list-disc text-xs text-red-700">

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                @endif


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


                    {{-- Email --}}
                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-semibold text-slate-800"
                        >
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $email) }}"
                            required
                            autocomplete="email"
                            class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        >

                    </div>


                    {{-- Password --}}
                    <div>

                        <label
                            for="password"
                            class="mb-2 block text-sm font-semibold text-slate-800"
                        >
                            New Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Enter your new password"
                            class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        >

                    </div>


                    {{-- Confirm Password --}}
                    <div>

                        <label
                            for="password_confirmation"
                            class="mb-2 block text-sm font-semibold text-slate-800"
                        >
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm your new password"
                            class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        >

                    </div>


                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100"
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

                        Reset Password

                    </button>

                </form>


                {{-- Back --}}
                <div class="mt-7 text-center">

                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700"
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

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.js"></script>

</body>
</html>

