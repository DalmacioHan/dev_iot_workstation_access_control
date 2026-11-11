@if(session('pairing_success'))
    <div id="toast-illustration" class="w-full space-y-4 max-w-sm p-3 bg-white rounded-xl shadow-lg border border-gray-200 fixed bottom-5 right-5 z-50 transition-all duration-300" role="alert">
        <div class="flex items-start">

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">
                <x-icon name="check-circle" class="h-6 w-6" />
            </div>
            

            <div class="ms-4 text-sm font-normal text-gray-600">
                <span class="mb-1 text-base font-semibold text-gray-900 block">Device Paired Successfully</span>
                <div class="mb-3 text-gray-500 leading-relaxed">
                    A hardware client has successfully used a validation pairing token. You can now inspect its connection status and resource slots.
                </div> 
                
                <div class="grid grid-cols-2 gap-3">
                    
                    <button 
                        type="button" 
                        onclick="closeToastNotification()" 
                        class="w-full text-gray-700 bg-gray-50 border border-gray-200 hover:bg-gray-100 font-medium rounded-lg text-xs px-3 py-2 transition-colors focus:outline-none"
                    >
                        Not now
                    </button>
                    
                    {{-- Navigation Action (Directly links to the target device detailed view page) --}}
                    <a 
                    href="{{ session('paired_device_id') ? route('device.edit', session('paired_device_id')) : route('device') }}"
                        class="w-full inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-xs px-3 py-2 transition-colors focus:outline-none"
                    >
                        <x-icon name="eye" class="w-3.5 h-3.5 me-1.5" aria-hidden="true" />
                        View Device
                    </a> 
                </div>     
            </div>
        </div>
    </div>

    {{-- Script Scope to close toast --}}
    <script>
        function closeToastNotification() {
            const toast = document.getElementById('toast-illustration');
            if (toast) {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }
        }
    </script>
@endif