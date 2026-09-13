@extends('layout.app')

@section('title', 'Device Details - ' . $device->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-6">
        <a href="{{ route('device') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Devices
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-100 pb-6 mb-6">
            <div>
                <div class="flex items-center space-x-3 flex-wrap gap-y-2">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $device->name }}</h1>
                    
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                        Active
                    </span>
                    @if($device->last_seen_at && $device->last_seen_at->diffInMinutes(now()) < 5)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full animate-pulse"></span> Online
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                            <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span> Offline
                        </span>
                    @endif
                </div>
                @if(!empty($device->pairing_code))
                    <p class="text-sm text-gray-500 mt-1">Pairing Code: <span class="font-mono text-gray-700 font-medium">{{ $device->pairing_code }}</span></p>
                @else
                    <p class="text-sm text-gray-500 mt-1">Device Code: <span class="font-mono text-gray-700 font-medium">{{ $device->device_uid }}</span></p>
                @endif
            </div>

            <div class="mt-4 md:mt-0">
                <a href="{{ route('device.edit', $device->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        {{-- Optimized Metric Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-xl">
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Slot Usage</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $device->workstations()->count() }} 
                    <span class="text-lg font-normal text-gray-400">/ 1 slots used</span>
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ 1 - $device->workstations()->count() }} available
                </p>
            </div>

            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Last Seen</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $device->last_seen_at ? $device->last_seen_at->diffForHumans() : 'Never' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Assigned Workstations</h2>
            </div>
            <div class="divide-y divide-gray-100">
                <table class="min-w-full divide-y divide-gray-100 text-left">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse(($assignedWorkstations ?? []) as $workstation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $workstation->pc_code}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $workstation->created_at ? $workstation->created_at->format('M d, Y') : now()->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400 italic">
                                    No workstations assigned to this device yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Recent Device Events</h2>
            </div>
            <div class="p-6 divide-y divide-gray-100">
            </div>
        </div>

    </div>
</div>
@endsection