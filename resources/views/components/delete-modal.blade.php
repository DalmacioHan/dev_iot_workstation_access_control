<div id="delete-confirmation-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>

    <!-- Modal Panel -->
    <div class="relative transform overflow-hidden rounded-2xl border border-gray-200 bg-white p-8 text-left shadow-xl transition-all w-full max-w-md flex flex-col items-center">
        
        <!-- Warning/Trash Icon -->
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-100 text-red-600">
            <x-icon name="trash" class="h-10 w-10" />
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