@if(session('success'))
    <div id="global-success-modal" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm transition-opacity" onclick="closeGlobalSuccessModal()"></div>

        <div class="relative transform overflow-hidden rounded-2xl border border-gray-200 bg-white p-8 text-left shadow-xl transition-all w-full max-w-md flex flex-col items-center">
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
        function closeSuccessModalAndRedirect() {
            const redirectUrl = @json(session('success_redirect', url()->current()));
            window.location.href = redirectUrl;
        }

        function closeGlobalSuccessModal() {
            document.getElementById('global-success-modal')?.remove();
        }
    </script>
@endif