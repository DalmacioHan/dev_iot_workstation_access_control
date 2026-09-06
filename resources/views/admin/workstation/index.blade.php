@extends('layout.app')

@section('title','Workstation')

@section('content')

<div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3 lg:items-center">

    <form class="w-full lg:col-span-2" method="GET" action="">
        <label for="search" class="sr-only">Search</label>

        <div class="relative">
            <input
                type="search"
                id="search"
                name="search"
                value="{{ request('search') }}"
                class="block w-full h-[52px] rounded-xl border border-gray-200 bg-white pl-12 pr-4 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
                placeholder="Search by workstation code..."
            />
        </div>
    </form>


    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-1">
        <div class="w-full">
            <label for="status" class="sr-only">Status</label>
            <select
                id="status"
                name="status"
                class="block w-full h-[52px] rounded-xl border border-gray-200 bg-white px-4 pr-10 text-sm text-gray-900 shadow-sm focus:border-blue-600 focus:ring-blue-600"
            >
                <option selected>All Status</option>
                <option>Active</option>
                <option>Inactive</option>
            </select>
        </div>

        <a
            href="{{ route('workstation.create') }}"
            class="inline-flex w-full min-w-0 h-[52px] items-center justify-center gap-2 rounded-xl bg-blue-700 px-3 text-sm font-medium text-white shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
            </svg>
            <span class="truncate">Add Workstation</span>
        </a>
    </div>
</div>

{{-- Table --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
<div class="relative overflow-x-auto">
    <table class="w-full text-left text-sm text-gray-700">
        <thead class="bg-white text-base font-semibold text-black border-b border-gray-200">
            <tr>
                    <th scope="col" class="px-8 py-6">Workstation Code</th>
                    <th scope="col" class="px-8 py-6">Status</th>
                    <th scope="col" class="px-8 py-6">Device Code</th>
                    
                    <th scope="col" class="px-8 py-6 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach ($deviceWorkstations as $dw)
                <tr class="bg-white">
                    <td class="px-8 py-7 font-medium text-gray-900">{{ $dw->workstation->pc_code }}</td>
                    <td class="px-8 py-7">
                        <span class="{{ $dw->workstation->is_active ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }} px-2 py-1 rounded-full">
                        {{ $dw->workstation->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-8 py-7 text-gray-900">{{ $dw->device->device_uid }}</td>
                    <td class="px-8 py-7">
                        <div class="flex items-center justify-center gap-3">

                            <a href="{{ route('workstation.view', $dw->workstation->id) }}" class="group rounded-lg p-2 hover:bg-blue-50 transition-all" title="View Details">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </a>

                            <a href="{{ route('workstation.edit', $dw->workstation->id) }}" class="group rounded-lg p-2 hover:bg-amber-50 transition-all" title="Edit">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            
                            <button 
                                type="button" 
                                onclick="openDeleteModal('{{ route('workstation.destroy', $dw->workstation->id) }}', 'Are you sure you want to delete workstation {{ $dw->workstation->pc_code }}?')"
                                class="group rounded-lg p-2 hover:bg-red-50 transition-all" 
                                title="Delete"
                            >
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $deviceWorkstations->onEachSide(1)->links('vendor.pagination.flowbite') }}
</div>

@endsection