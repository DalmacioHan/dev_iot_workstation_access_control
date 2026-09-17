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
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
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
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 00-9-9z" />
                    </svg>
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