@extends('layout.app')

@section('title','Add Device')

@section('content')
@php
    $controlHeight = 'h-[52px]';
@endphp

{{-- Top right Back button --}}
<div class="mb-6 flex w-full justify-end">
    <a href="{{ route('device') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200">
        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
        </svg>
        Back to Devices
    </a>
</div>

{{-- Two cards layout --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    {{-- Left card (illustration + text) --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="p-10">
            <div class="flex flex-col items-center">
                <div class="flex h-64 w-64 items-center justify-center rounded-[40px] bg-blue-100">
                    <svg class="h-28 w-28 text-blue-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18a1 1 0 0 1-1-1m2 0a1 1 0 0 1-1 1m1-3a4 4 0 1 0-4-4m8 0a4 4 0 1 0-4 4m0 0v2"/>
                    </svg>
                </div>
                <h1 class="mt-10 text-3xl font-semibold text-gray-900">Device Registration</h1>
                <p class="mt-4 max-w-md text-center text-lg text-gray-600">Register a device to enable workstation assignments.</p>
                <div class="mt-10 w-full rounded-2xl border border-blue-200 bg-blue-50 p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-blue-700 text-blue-700">
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9h.01M11 12h1v4h1" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22a10 10 0 1 0-10-10 10 10 0 0 0 10 10Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-blue-900">Device Code must be unique.</p>
                            <p class="mt-2 text-base text-blue-900/80">Make sure the code matches what is printed or stored on the ESP device.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right card (form) --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="p-10">
            <h2 class="text-4xl font-semibold text-gray-900">Add Device</h2>
            <form method="POST" action="{{ route('device.store') }}" class="mt-10 space-y-8">
                @csrf
                <div>
                    <label for="device_uid" class="mb-2 block text-base font-medium text-gray-900">Device Code <span class="text-red-600">*</span></label>
                    <input type="text" id="device_uid" name="device_uid" value="{{ old('device_uid') }}" placeholder="12345" class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-base text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600" required />
                    @error('device_uid') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    <p class="mt-2 text-sm text-gray-500">Unique code printed/stored on the ESP.</p>
                </div>
                <div>
                    <label for="name" class="mb-2 block text-base font-medium text-gray-900">Device Name <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Main Door ESP" class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-white px-4 text-base text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600" required />
                    @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="last_seen" class="mb-2 block text-base font-medium text-gray-900">Last Seen</label>
                    <input type="text" id="last_seen" value="— (Pending Activation)" class="block w-full {{ $controlHeight }} rounded-xl border border-gray-200 bg-gray-50 px-4 text-base text-gray-600" disabled />
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <button type="submit" class="inline-flex w-full {{ $controlHeight }} items-center justify-center rounded-xl bg-blue-800 px-6 text-base font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-200">Save Device</button>
                    <a href="{{ route('device') }}" class="inline-flex w-full {{ $controlHeight }} items-center justify-center rounded-xl border border-gray-300 bg-white px-6 text-base font-medium text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection