@if(session('success'))
    <!-- Added: opacity-0 and pointer-events-none by default -->
    <div id="global-success-modal" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4 opacity-0 pointer-events-none transition-opacity duration-500 ease-out" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm transition-opacity" onclick="closeGlobalSuccessModal()"></div>

        <!-- Added: id="success-modal-panel" and initial transform states (scale-95, translate-y-8, opacity-0) -->
        <div id="success-modal-panel" class="relative transform opacity-0 translate-y-8 scale-95 rounded-2xl border border-gray-200 bg-white p-8 text-left shadow-xl transition-all duration-500 ease-out w-full max-w-md flex flex-col items-center">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>

            <div class="mt-6 text-center">
                <h3 class="text-2xl font-bold text-gray-900" id="modal-title">Success!</h3>
                <p class="mt-3 text-base text-gray-500 leading-relaxed">
                    {{ session('success') }}
                </p>
            </div>

            <button
                type="button"
                onclick="closeSuccessModalAndRedirect()"
                class="mt-8 inline-flex w-full justify-center rounded-xl bg-gray-900 px-6 py-3.5 text-base font-semibold text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-colors"
            >
                Dismiss
            </button>
        </div>
    </div>

    <script>
        // Trigger the animation after the page loads
        document.addEventListener("DOMContentLoaded", () => {
            const delayInMilliseconds = 400; // Change this value to make the delay longer or shorter

            setTimeout(() => {
                const modal = document.getElementById('global-success-modal');
                const panel = document.getElementById('success-modal-panel');
                
                if (modal && panel) {
                    // Show background/wrapper
                    modal.classList.remove('opacity-0', 'pointer-events-none');
                    modal.classList.add('opacity-100');
                    
                    // Pop in the panel
                    panel.classList.remove('opacity-0', 'translate-y-8', 'scale-95');
                    panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
                }
            }, delayInMilliseconds);
        });

        function closeSuccessModalAndRedirect() {
            // Animate out before redirecting (optional but looks nice)
            closeGlobalSuccessModal();
            setTimeout(() => {
                const redirectUrl = @json(session('success_redirect', url()->current()));
                window.location.href = redirectUrl;
            }, 300); // Wait for fade out
        }

        function closeGlobalSuccessModal() {
            const modal = document.getElementById('global-success-modal');
            const panel = document.getElementById('success-modal-panel');
            
            if (modal && panel) {
                // Reverse the animation classes
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0', 'pointer-events-none');
                
                panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
                panel.classList.add('opacity-0', 'translate-y-8', 'scale-95');

                // Remove from DOM after animation completes
                setTimeout(() => {
                    modal.remove();
                }, 500); 
            }
        }
    </script>
@endif