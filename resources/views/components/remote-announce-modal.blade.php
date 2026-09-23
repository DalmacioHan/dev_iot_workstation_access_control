<div id="remoteAnnounceModal" class="fixed inset-0 z-50 hidden bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-1/4 mx-auto p-5 border w-full max-w-md shadow-xl rounded-xl bg-white border-gray-100">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-sky-50 border border-sky-100 mb-4">
                <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46"/>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-2">Send Announcement</h3>

            <p class="text-sm text-gray-500 px-2">
                This will display a message on top of
                <span id="remoteAnnounceDeviceName" class="font-semibold text-gray-700"></span>
                until someone at the PC dismisses it.
            </p>

            <form id="remoteAnnounceForm" action="" method="POST" class="mt-4 text-left">
                @csrf
                <label for="remoteAnnounceMessage" class="mb-1 block text-xs font-semibold text-gray-600">
                    Message shown on the PC
                </label>
                <textarea
                    id="remoteAnnounceMessage"
                    name="message"
                    rows="3"
                    maxlength="500"
                    required
                    placeholder="e.g. Library closes in 10 minutes."
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50/70 px-3 py-2 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-100"
                ></textarea>

                <div class="mt-5 flex items-center justify-center space-x-3">
                    <button onclick="closeRemoteAnnounceModal()" type="button"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        style="background-color:#0284c7;color:#ffffff;"
                        class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors">
                        Send Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRemoteAnnounceModal(actionUrl, deviceName) {
        document.getElementById('remoteAnnounceForm').action = actionUrl;
        document.getElementById('remoteAnnounceDeviceName').innerText = deviceName || 'this PC';
        document.getElementById('remoteAnnounceMessage').value = '';
        document.getElementById('remoteAnnounceModal').classList.remove('hidden');
    }

    function closeRemoteAnnounceModal() {
        document.getElementById('remoteAnnounceModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('remoteAnnounceModal');
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeRemoteAnnounceModal();
            }
        });
    });
</script>