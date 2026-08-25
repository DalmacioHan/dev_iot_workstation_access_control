
<div class="max-w-3xl mx-auto">
    <!-- Header & Back Button -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Workstation</h2>
        <a href="{{ route('workstation') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">

        <form action="" method="" class="p-6">
            @csrf
           
            
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <!-- Workstation Code -->
                <div class="col-span-2 md:col-span-1">
                    <label for="workstation_code" class="block mb-2 text-sm font-medium text-gray-900">Workstation Code</label>
                    <input type="text" name="workstation_code" id="workstation_code" 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 @error('workstation_code') border-red-500 @enderror" 
                           value="{{ old('workstation_code', $workstation->workstation_code) }}" 
                           placeholder="e.g. PC01" required>
                    @error('workstation_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Status -->
                <div class="col-span-2 md:col-span-1">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                    <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="active" {{ old('status', $workstation->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $workstation->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="maintenance" {{ old('status', $workstation->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
    
                <div class="col-span-2">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Notes (Optional)</label>
                    <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Add any notes about this workstation...">{{ old('description', $workstation->description ?? '') }}</textarea>
                </div>
            </div>
            
           
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('workstation') }}" class="text-gray-700 bg-white border border-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Update Workstation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection