<div id="remoteLockModal" class="fixed inset-0 z-50 hidden bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-1/4 mx-auto p-5 border w-full max-w-md shadow-xl rounded-xl bg-white border-gray-100">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-amber-50 border border-amber-100 mb-4">
                <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-2">Remote Lock PC</h3>

            <p class="text-sm text-gray-500 px-2">
                This will immediately end the active session on
                <span id="remoteLockDeviceName" class="font-semibold text-gray-700"></span>
                and lock the screen.
            </p>

            <form id="remoteLockForm" action="" method="POST" class="mt-4 text-left">
                @csrf
                <label for="remoteLockMessage" class="mb-1 block text-xs font-semibold text-gray-600">
                    Message shown on the PC <span class="font-normal text-gray-400">(optional)</span>
                </label>
                <textarea
                    id="remoteLockMessage"
                    name="message"
                    rows="3"
                    maxlength="500"
                    placeholder="e.g. Library closes in 10 minutes."
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50/70 px-3 py-2 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-100"
                ></textarea>
                <p class="mt-1 text-xs text-gray-400">
                    Leave blank to show a generic &quot;logged out&quot; message.
                </p>

                <div class="mt-5 flex items-center justify-center space-x-3">
                    <button onclick="closeRemoteLockModal()" type="button"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        style="background-color:#d97706;color:#ffffff;"
                        class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        Send Lock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRemoteLockModal(actionUrl, deviceName) {
        document.getElementById('remoteLockForm').action = actionUrl;
        document.getElementById('remoteLockDeviceName').innerText = deviceName || 'this PC';
        document.getElementById('remoteLockMessage').value = '';
        document.getElementById('remoteLockModal').classList.remove('hidden');
    }

    function closeRemoteLockModal() {
        document.getElementById('remoteLockModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('remoteLockModal');
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeRemoteLockModal();
            }
        });
    });
</script>