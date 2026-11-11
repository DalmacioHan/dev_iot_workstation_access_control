<div id="globalConfirmModal" class="fixed inset-0 z-50 hidden bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full">
    <div class="relative top-1/4 mx-auto p-5 border w-full max-w-md shadow-xl rounded-xl bg-white border-gray-100">
        <div class="mt-3 text-center">
            <div id="globalConfirmIconContainer" class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-50 border border-red-100 mb-4">
                <x-icon name="exclamation-triangle" class="h-6 w-6 text-red-600" id="globalConfirmIcon" />
            </div>
            
            <h3 id="globalConfirmTitle" class="text-xl font-bold text-gray-900 mb-2">Confirm Action</h3>
            <div class="px-7 py-3">
                <p id="globalConfirmMessage" class="text-sm text-gray-500">Are you sure you want to proceed with this action?</p>
            </div>
            
            <div class="flex items-center justify-center space-x-3 px-4 py-3 mt-4">
                <button onclick="closeGlobalConfirmModal()" type="button" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors">
                    Cancel
                </button>
                
                <form id="globalConfirmForm" action="" method="POST">
                    @csrf
                    <div id="globalConfirmMethodContainer"></div>
                    <button id="globalConfirmBtn" type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openGlobalConfirmModal(options) {
        const modal = document.getElementById('globalConfirmModal');
        const form = document.getElementById('globalConfirmForm');
        const title = document.getElementById('globalConfirmTitle');
        const message = document.getElementById('globalConfirmMessage');
        const btn = document.getElementById('globalConfirmBtn');
        const methodContainer = document.getElementById('globalConfirmMethodContainer');
        const iconContainer = document.getElementById('globalConfirmIconContainer');
        const icon = document.getElementById('globalConfirmIcon');

        
        form.action = options.action;
        title.innerText = options.title || 'Confirm Action';
        message.innerText = options.message || 'Are you sure?';
        btn.innerText = options.btnText || 'Confirm';

        
        methodContainer.innerHTML = '';
        if (options.method && options.method.toUpperCase() !== 'POST') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_method';
            input.value = options.method.toUpperCase();
            methodContainer.appendChild(input);
        }

        
        if (options.type === 'warning' || options.type === 'delete') {
            btn.className = "px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-red-700 transition-colors";
            iconContainer.className = "mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-50 border border-red-100 mb-4";
            icon.className = "h-6 w-6 text-red-600";
        } else {
            btn.className = "px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 transition-colors";
            iconContainer.className = "mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-50 border border-blue-100 mb-4";
            icon.className = "h-6 w-6 text-blue-600";
        }

        
        modal.classList.remove('hidden');
    }

    function closeGlobalConfirmModal() {
        document.getElementById('globalConfirmModal').classList.add('hidden');
    }
</script>