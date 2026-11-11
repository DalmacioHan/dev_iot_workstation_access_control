@if(session('success'))
    @php
        // Dynamically extract the 6-character pairing code from the session message string
        $messageString = session('success');
        $codeFound = substr(trim($messageString), -6);
        $pairingCode = (is_string($codeFound) && strlen($codeFound) === 6) ? strtoupper($codeFound) : 'ACTIVE';
    @endphp

    <div id="global-success-modal" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop Blur Overlay (Clicking this will also trigger redirect) --}}
        <div class="fixed inset-0 bg-gray-950/40 backdrop-blur-sm transition-opacity" onclick="closeSuccessModalAndRedirect()"></div>

        {{-- Modal Content Box --}}
        <div class="relative transform overflow-hidden rounded-2xl border border-gray-200 bg-white p-8 text-left shadow-xl transition-all w-full max-w-md flex flex-col items-center">
            
            {{-- Circular Success Icon --}}
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600">
                <x-icon name="check" class="h-10 w-10" />
            </div>

            <div class="mt-6 text-center">
                <h3 class="text-2xl font-semibold text-gray-900" id="modal-title">
                    Device Profile Generated!
                </h3>
                <p class="mt-3 text-base text-gray-500">
                    The device database instance has been initialized. Provide this one-time pairing token to the IoT endpoint hardware client.
                </p>
            </div>

            {{-- Token Display Box with Copy Feature --}}
            <div class="mt-6 w-full rounded-xl bg-gray-50 border border-gray-200 p-4 flex flex-col items-center justify-center relative group">
                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">One-Time Pairing Code</span>
                <span id="pairing-token-text" class="mt-2 text-4xl font-extrabold font-mono tracking-widest text-blue-800 selection:bg-blue-200">
                    {{ $pairingCode }}
                </span>
                
                <button type="button" onclick="copyPairingToken()" class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-blue-700 transition-colors">
                    <x-icon name="copy" class="h-4 w-4" />
                    <span id="copy-btn-label">Copy to Clipboard</span>
                </button>
            </div>

            {{-- Close Button --}}
            <button
                type="button"
                onclick="closeSuccessModalAndRedirect()"
                class="mt-8 inline-flex w-full h-[52px] items-center justify-center rounded-xl bg-gray-900 px-6 text-base font-semibold text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-colors"
            >
                Acknowledge & Close
            </button>
        </div>
    </div>

    {{-- Script Scope --}}
    <script>
        function closeSuccessModalAndRedirect() {
            // Performs a direct client-side redirection to your main devices table list
            window.location.href = "{{ route('device') }}";
        }

        function copyPairingToken() {
            const tokenText = document.getElementById('pairing-token-text').innerText;
            const btnLabel = document.getElementById('copy-btn-label');
            
            navigator.clipboard.writeText(tokenText).then(() => {
                btnLabel.innerText = "Copied!";
                btnLabel.classList.add('text-green-600', 'font-semibold');
                
                setTimeout(() => {
                    btnLabel.innerText = "Copy to Clipboard";
                    btnLabel.classList.remove('text-green-600', 'font-semibold');
                }, 2000);
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endif