@extends('layout.app')

@section('title', 'Edit Device')

@section('content')

{{-- Top Toolbar navigation link line --}}
<div class="mb-6 flex justify-start">
    <a href="{{ route('device') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Devices
    </a>
</div>

{{-- Main Form Container Wrapper Card Box --}}
<div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm max-w-2xl mx-auto">
    <div class="border-b border-gray-100 pb-4">
        <h2 class="text-2xl font-bold text-gray-900">Edit Device Settings</h2>
        <p class="mt-1 text-sm text-gray-500">Modify the operational characteristics or naming descriptions for this node client.</p>
    </div>

    <form method="POST" action="{{ route('device.update', $device->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        
        <div>
            <label for="device_uid" class="block text-sm font-semibold text-gray-700 mb-2">Device Code</label>
            <input
                type="text"
                id="device_uid"
                value="{{ $device->device_uid }}"
                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 font-mono text-base font-semibold text-gray-500 shadow-inner"
                disabled
            />
            <p class="mt-1.5 text-xs text-gray-400">The physical node hardware address string cannot be rewritten.</p>
        </div>

        
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                Device Name <span class="text-red-600">*</span>
            </label>
            <input
                type="text"
                id="workstation_name"
                name="workstation_name"
                value="{{ old('workstation_name', $device->workstation_name) }}"
                placeholder="{{ $device->workstation_name }}"
                class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-base text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                required
            />
            @error('workstation_name')
                <div class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</div>
            @enderror
        </div>

        
        <div>
            @if(empty($device->pairing_code))
            <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-2">
                Status <span class="text-red-600">*</span>
            </label>
            <select
                id="is_active"
                name="is_active"
                class="block w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-base text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                required
            >
                <option value="1" @selected(old('is_active', $device->is_active) == 1)>Active</option>
                <option value="0" @selected(old('is_active', $device->is_active) == 0)>Inactive</option>
            </select>
                    <div class="rounded-xl border border-amber-200 bg-amber-50/60 p-4 flex gap-3 items-start">
            <svg class="h-5 w-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="text-xs text-amber-800 leading-relaxed">
                <span class="font-bold block text-amber-900 mb-0.5">Notice:</span> 
                Setting this hardware instance to inactive status will automatically interrupt access permissions over any currently designated multi-sensor configurations.
            </div>
        </div>
            @error('is_active')
                <div class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</div>
            @enderror
            @else
        <div class="rounded-xl border border-amber-200 bg-amber-50/60 p-4 flex gap-3 items-start">
            <svg class="h-5 w-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="text-xs text-amber-800 leading-relaxed">
                <span class="font-bold block text-amber-900 mb-0.5">Notice:</span> 
                This device is currently in pairing mode and cannot be deactivated until the pairing process is completed or cancelled. 
            </div>
        </div>
            @endif
        </div>

        
        

        <div class="flex items-center justify-end gap-3 pt-2">
            <a
                href="{{ route('device') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-colors"
            >
                Cancel
            </a>
            
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-colors"
            >
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection