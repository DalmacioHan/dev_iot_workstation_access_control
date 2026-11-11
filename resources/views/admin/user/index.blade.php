
@extends('layout.app')

@section('title', 'Users')

@section('content')

<div class="min-h-full bg-slate-50/70">

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- =========================================================
            PAGE HEADER
        ========================================================== --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">

                    <x-icon name="users" class="h-3.5 w-3.5" />

                    User Management

                </div>


                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Users
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage registered users and their system access.
                </p>

            </div>


            {{-- Add User --}}
            
            <a
                href="{{ route('user.create') }}"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200"
            >

                <x-icon name="plus" class="h-5 w-5" aria-hidden="true" />

                Add User

            </a>
            

        </div>


        {{-- =========================================================
            SEARCH / FILTER
        ========================================================== --}}
        <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

            <form
                method="GET"
                action="{{ route('user') }}"
                class="w-full"
            >

                <label
                    for="search"
                    class="sr-only"
                >
                    Search users
                </label>


                <div class="relative">

                    {{-- Search Icon --}}
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                        <x-icon name="search" class="h-5 w-5 text-slate-400" />

                    </div>


                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        class="block h-12 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-11 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                        placeholder="Search by name or email..."
                    />


                    {{-- Clear Search --}}
                    @if(request('search'))

                        <a
                            href="{{ route('user') }}"
                            class="absolute right-3 top-10/12 -translate-y-1/2 rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                            title="Clear search"
                        >

                            <x-icon name="information-circle" class="h-5 w-5" />

                        </a>

                    @endif

                </div>

            </form>

        </div>


        {{-- =========================================================
            USERS TABLE
        ========================================================== --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">


            {{-- Table Header --}}
            <div class="flex flex-col gap-2 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                            <x-icon name="users" class="h-5 w-5" />

                        </div>


                        <div>

                            <h2 class="text-base font-bold text-slate-900">
                                Registered Users
                            </h2>

                            <p class="text-xs text-slate-500">
                                Accounts registered in your system.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- User Count --}}
                <div class="inline-flex w-fit items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">

                    {{ $users->total() }}

                    {{ Str::plural('user', $users->total()) }}

                </div>

            </div>


            {{-- Table --}}
            <div class="relative overflow-x-auto">

                <table class="w-full text-left text-sm text-slate-600">

                    <thead class="border-b border-slate-100 bg-slate-50/70 text-xs uppercase tracking-wider text-slate-500">

                        <tr>

                            <th
                                scope="col"
                                class="px-6 py-4 font-semibold sm:px-8"
                            >
                                User
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 font-semibold sm:px-8"
                            >
                                Email
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-center font-semibold"
                            >
                                Role
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-center font-semibold"
                            >
                                Status
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-center font-semibold sm:px-8"
                            >
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($users as $user)

                            <tr class="group bg-white transition-colors hover:bg-blue-50/30">


                                {{-- =================================================
                                    USER
                                ================================================== --}}
                                <td class="px-6 py-5 sm:px-8">

                                    <div class="flex items-center gap-3">

                                        {{-- Profile --}}
                                        @if($user->profile_picture)

                                            <img
                                                src="{{ asset('storage/' . $user->profile_picture) }}"
                                                alt="{{ $user->name }}"
                                                class="h-10 w-10 shrink-0 rounded-xl object-cover"
                                            >

                                        @else

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 font-bold text-blue-600 transition-colors group-hover:bg-blue-100">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>

                                        @endif


                                        <div class="min-w-0">

                                            <p class="truncate font-semibold text-slate-800">
                                                {{ $user->name }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-slate-400">
                                                User #{{ $user->id }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- =================================================
                                    EMAIL
                                ================================================== --}}
                                <td class="px-6 py-5 sm:px-8">

                                    <p class="max-w-xs truncate font-medium text-slate-700">
                                        {{ $user->email }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        Email Address
                                    </p>

                                </td>


                                {{-- =================================================
                                    ROLE
                                ================================================== --}}
                                <td class="px-6 py-5 text-center">

                                    @php
                                        $role = strtolower($user->role ?? 'user');

                                        $roleClasses = match ($role) {
                                            'superadmin' => 'border-purple-200 bg-purple-50 text-purple-700',
                                            'admin' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                            default => 'border-blue-200 bg-blue-50 text-blue-700',
                                        };
                                    @endphp


                                    <span
                                        class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-semibold {{ $roleClasses }}"
                                    >

                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                            {{ $role === 'admin'
                                                ? 'bg-purple-500'
                                                : ($role === 'librarian'
                                                    ? 'bg-emerald-500'
                                                    : 'bg-blue-500') }}"
                                        ></span>

                                        {{ ucfirst($role) }}

                                    </span>

                                </td>


                                {{-- =================================================
                                    STATUS
                                ================================================== --}}
                                <td class="px-6 py-5 text-center">

                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                        Active

                                    </span>

                                </td>


                                {{-- =================================================
                                    ACTIONS
                                ================================================== --}}
                                <td class="px-6 py-5 sm:px-8">

                                    <div class="flex items-center justify-center gap-1">


                                        {{-- =====================================
                                            VIEW
                                        ====================================== --}}
                                        <a
                                            href="{{ route('user.show', $user->id) }}"
                                            class="rounded-xl p-2.5 text-slate-400 transition hover:bg-blue-50 hover:text-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-100"
                                            title="View Details"
                                        >

                                            <x-icon name="eye" class="h-5 w-5" />

                                        </a>


                                        {{-- =====================================
                                            EDIT
                                        ====================================== --}}
                                        <a
                                            href="{{ route('user.edit', $user->id) }}"
                                            class="rounded-xl p-2.5 text-slate-400 transition hover:bg-amber-50 hover:text-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-100"
                                            title="Edit"
                                        >

                                            <x-icon name="edit" class="h-5 w-5" />

                                        </a>


                                        {{-- =====================================
                                            DELETE
                                        ====================================== --}}
                                        <button
                                            type="button"
                                            onclick="openDeleteModal(
                                                '{{ route('user.destroy', $user->id) }}',
                                                'Are you sure you want to delete {{ $user->name }}? This action cannot be undone.'
                                            )"
                                            class="rounded-xl p-2.5 text-slate-400 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-4 focus:ring-red-100"
                                            title="Delete"
                                        >

                                            <x-icon name="trash" class="h-5 w-5" />

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            {{-- =================================================
                                EMPTY STATE
                            ================================================== --}}
                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-20 text-center"
                                >

                                    <div class="mx-auto flex max-w-sm flex-col items-center">

                                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                            <x-icon name="users" class="h-8 w-8" />

                                        </div>


                                        <h3 class="mt-4 text-base font-bold text-slate-800">
                                            No users found
                                        </h3>


                                        <p class="mt-1 text-sm text-slate-500">
                                            Try adjusting your search or add a new user.
                                        </p>


                                        @if(request('search'))

                                            <a
                                                href="{{ route('user') }}"
                                                class="mt-4 inline-flex items-center rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
                                            >
                                                Clear Search
                                            </a>

                                        @else

                                            <a
                                                href="{{ route('user.create') }}"
                                                class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                                            >

                                                <x-icon name="plus" class="h-4 w-4" />

                                                Add User

                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =========================================================
            PAGINATION
        ========================================================== --}}
        @if($users->hasPages())

            <div class="mt-6">

                {{ $users->onEachSide(1)->links('vendor.pagination.flowbite') }}

            </div>

        @endif


        {{-- =========================================================
            DELETE MODAL
        ========================================================== --}}
        <x-delete-modal />

    </div>

</div>

@endsection

