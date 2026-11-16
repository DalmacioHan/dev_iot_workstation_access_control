<div id="remoteAnnounceModal" class="fixed inset-0 z-50 hidden bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-1/4 mx-auto p-5 border w-full max-w-md shadow-xl rounded-xl bg-white border-gray-100">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-sky-50 border border-sky-100 mb-4">
                <x-icon name="megaphone-a" class="h-6 w-6 text-sky-600" />
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-2">Send Announcement</h3>

            <p class="text-sm text-gray-500 px-2">
                This will display a message on top of
                <span id="remoteAnnounceDeviceName" class="font-semibold text-gray-700"></span>
                until someone at the PC dismisses it.
            </p>

            <form id="remoteAnnounceForm" action="" method="POST" class="mt-4 text-left">
                @csrf
                <div id="remoteAnnounceDeviceIds"></div>
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
    function openRemoteAnnounceModal(actionUrl, deviceName, deviceIds = null) {
        const form = document.getElementById('remoteAnnounceForm');
        form.action = actionUrl;
        document.getElementById('remoteAnnounceDeviceName').innerText = deviceName || 'this PC';
        document.getElementById('remoteAnnounceMessage').value = '';
        const idsContainer = document.getElementById('remoteAnnounceDeviceIds');
        if (idsContainer) {
            idsContainer.innerHTML = '';
            if (Array.isArray(deviceIds)) {
                deviceIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'device_ids[]';
                    input.value = id;
                    idsContainer.appendChild(input);
                });
            }
        }
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