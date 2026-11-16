<div id="remoteUnlockModal" class="fixed inset-0 z-50 hidden bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-1/4 mx-auto p-5 border w-full max-w-md shadow-xl rounded-xl bg-white border-gray-100">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-emerald-50 border border-emerald-100 mb-4">
                <x-icon name="lock-open" class="h-6 w-6 text-emerald-600" />
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-2">Remote Unlock PC</h3>

            <p class="text-sm text-gray-500 px-2">
                This will unlock
                <span id="remoteUnlockDeviceName" class="font-semibold text-gray-700"></span>
                for access without requiring a card scan. No student session will be started.
            </p>

            <form id="remoteUnlockForm" action="" method="POST" class="mt-4 text-left">
                @csrf
                <div id="remoteUnlockDeviceIds"></div>
                <label for="remoteUnlockMessage" class="mb-1 block text-xs font-semibold text-gray-600">
                    Message shown on the PC <span class="font-normal text-gray-400">(optional)</span>
                </label>
                <textarea
                    id="remoteUnlockMessage"
                    name="message"
                    rows="3"
                    maxlength="500"
                    placeholder="e.g. PC unlocked by staff."
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50/70 px-3 py-2 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                ></textarea>

                <div class="mt-5 flex items-center justify-center space-x-3">
                    <button onclick="closeRemoteUnlockModal()" type="button"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-sm shadow-sm transition-colors">
                        Send Unlock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRemoteUnlockModal(actionUrl, deviceName, deviceIds = null) {
        const form = document.getElementById('remoteUnlockForm');
        if (!form) return;
        form.action = actionUrl;
        document.getElementById('remoteUnlockDeviceName').innerText = deviceName || 'this PC';
        document.getElementById('remoteUnlockMessage').value = '';
        const idsContainer = document.getElementById('remoteUnlockDeviceIds');
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
        document.getElementById('remoteUnlockModal').classList.remove('hidden');
    }

    function closeRemoteUnlockModal() {
        document.getElementById('remoteUnlockModal')?.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('remoteUnlockModal');
        if (!modal) return;
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeRemoteUnlockModal();
            }
        });
    });
</script>
