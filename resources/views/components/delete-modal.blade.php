<div id="delete-confirmation-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>

    <!-- Modal Panel -->
    <div class="relative transform overflow-hidden rounded-2xl border border-gray-200 bg-white p-8 text-left shadow-xl transition-all w-full max-w-md flex flex-col items-center">
        
        <!-- Warning/Trash Icon -->
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-100 text-red-600">
            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        </div>

        <!-- Text Content -->
        <div class="mt-6 text-center">
            <h3 class="text-2xl font-bold text-gray-900" id="modal-title">Confirm Deletion</h3>
            <p class="mt-3 text-base text-gray-500 leading-relaxed" id="delete-modal-message">
                Are you sure you want to delete this item? This action cannot be undone.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex w-full gap-3">
            <button 
                type="button" 
                onclick="closeDeleteModal()" 
                class="inline-flex w-full justify-center rounded-xl bg-white px-6 py-3.5 text-base font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-colors"
            >
                Cancel
            </button>
            
            <form id="delete-form" method="POST" class="w-full m-0">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="inline-flex w-full justify-center rounded-xl bg-red-600 px-6 py-3.5 text-base font-semibold text-white shadow-sm hover:bg-red-500 focus:outline-none focus:ring-4 focus:ring-red-200 transition-colors"
                >
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Call this function from your delete buttons, passing the route URL and an optional custom message
    function openDeleteModal(actionUrl, customMessage = null) {
        const modal = document.getElementById('delete-confirmation-modal');
        const form = document.getElementById('delete-form');
        const messageEl = document.getElementById('delete-modal-message');

        // Set the form action to the specific item's delete route
        form.action = actionUrl;

        // Optionally override the default message
        if (customMessage) {
            messageEl.textContent = customMessage;
        }

        // Show the modal
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-confirmation-modal').classList.add('hidden');
    }
</script>