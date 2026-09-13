@extends('layout.app')

@section('title','Workstation')

@section('content')


    <div class="w-full flex justify-end mb-4">
        <a href="{{ route('workstation') }}"
            class="inline-flex items-center gap-2 rounded-base px-3 py-2 text-sm border border-gray-300 hover:border-gray-400">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
            </svg>
            Back
        </a>
    </div>

    <div class="w-full flex justify-center">
        <div class="w-full max-w-5xl flex flex-col md:flex-row gap-6 md:items-stretch md:justify-end">

            <div class="w-full md:max-w-md">
                <div class="w-full h-full min-h-[420px] bg-neutral-primary-medium border border-default-medium rounded-lg flex items-center justify-center">
                    <svg class="w-40 h-40 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 17h10M9 20h6M6 16h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
                    </svg>
                </div>
            </div>

            <div class="w-full md:max-w-md">
                <div class="bg-white rounded-lg shadow p-6 h-full min-h-[420px] flex flex-col">
                    <h1 class="text-lg font-semibold mb-6">Create Workstation</h1>

                    <form class="flex flex-col flex-1" action="{{ route('workstation.store') }}" method="POST">
                        @csrf

                        @error('general')
                            <div class="mb-4 rounded-base border border-red-300 bg-red-50 px-3 py-2 text-sm text-red-800">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="space-y-4">
                            <div>
                                <label for="workstation_code" class="block mb-2 text-sm font-medium text-heading">Work Station Code</label>
                                <input
                                    type="text"
                                    id="workstation_code"
                                    name="pc_code"
                                    value="{{ old('pc_code') }}"
                                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                    placeholder="WS-001"
                                    required
                                />
                                @error('pc_code') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="device_id" class="block mb-2 text-sm font-medium text-heading">Device Name</label>
                                <select
                                    id="device_id"
                                    name="device_id"
                                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                                    required
                                    
                                >
                                    @forelse ($devicesName as $devices)
                                        @if ($loop->first)
                                            <option value="{{ $devices->id }}" disabled {{ old('device_uid') ? '' : 'selected' }}>Select device</option>
                                        @endif
                                        <option value="{{ $devices->id }}" {{ old('device_id') == $devices->id ? 'selected' : '' }}>
                                            {{ $devices->name ?? $devices->device_name }}
                                        </option>
                                    @empty
                                        <option value="" selected>No available devices </option>
                                    @endforelse
                                </select>
                                @error('device_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

                            </div>

                        </div>

                        <div class="mt-auto pt-6 space-y-3">
                            <div id="portNotice" class="hidden rounded-base border border-red-300 bg-red-50 px-3 py-2 text-sm text-red-800">
                                Selected Device is already u
                            </div>

                            

                            <button
                                id="submitBtn"
                                type="submit"
                                class="w-full text-black bg-brand hover:bg-brand-strong border border-gray-300 hover:border-gray-400 focus:ring-4 focus:ring-brand-medium shadow-xs font-medium rounded-base text-sm px-10 py-2.5 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed"

                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<x-success-modal />
   
@endsection