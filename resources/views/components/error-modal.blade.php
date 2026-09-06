<!-- Error Modal (Hidden by default via opacity-0 and pointer-events-none) -->
<div id="error-modal" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4 opacity-0 pointer-events-none transition-opacity duration-300 ease-out" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm transition-opacity" onclick="closeGlobalErrorModal()"></div>

    <!-- Modal Panel -->
    <div id="error-modal-panel" class="relative transform opacity-0 translate-y-8 scale-95 rounded-2xl border border-gray-200 bg-white p-8 text-left shadow-xl transition-all duration-300 ease-out w-full max-w-md flex flex-col items-center">
        
        <!-- Error Icon -->
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-100 text-red-600">
            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        
        <!-- Text Content -->
        <div class="mt-6 text-center">
            <h3 id="error-modal-title" class="text-2xl font-bold text-gray-900">Security Error</h3>
            
            <p id="error-modal-message" class="mt-3 text-base text-gray-500 leading-relaxed">
                {{-- Blade fallback catch for direct session errors --}}
                {{ $slot->isEmpty() ? 'Something went wrong. Please try again.' : $slot }}
            </p>
        </div>
        
        <!-- Action Button -->
        <div class="mt-8 w-full">
            <button type="button" onclick="closeGlobalErrorModal()"
                class="inline-flex w-full justify-center rounded-xl bg-gray-900 px-6 py-3.5 text-base font-semibold text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-colors">
                Try Again
            </button>
        </div>
    </div>
</div>

<script>
    function openGlobalErrorModal(errorMessage = '', errorTitle = 'Security Error') {
        const modal = document.getElementById('error-modal');
        const panel = document.getElementById('error-modal-panel');
        const titleEl = document.getElementById('error-modal-title');
        const msgEl = document.getElementById('error-modal-message');

        if (titleEl && errorTitle) titleEl.textContent = errorTitle;
        if (msgEl && errorMessage) msgEl.textContent = errorMessage;


        if (modal && panel) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            
            panel.classList.remove('opacity-0', 'translate-y-8', 'scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
        }
    }

    function closeGlobalErrorModal() {
        const modal = document.getElementById('error-modal');
        const panel = document.getElementById('error-modal-panel');
        

        if (modal && panel) {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            
            panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            panel.classList.add('opacity-0', 'translate-y-8', 'scale-95');
        }
    }
</script>