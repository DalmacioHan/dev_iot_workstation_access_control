@extends('layout.app')

@section('title','Account')

@section('content')

<form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="verification_code" id="verification_code">

    <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Profile Picture --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-xs p-6 border border-gray-200 sticky top-20">

                {{-- Profile Picture Upload Area --}}
                <div class="mb-6">
                    <label for="profile_image" class="relative w-full aspect-square bg-neutral-primary-medium border-2 border-dashed border-default rounded-lg flex items-center justify-center overflow-hidden group cursor-pointer hover:bg-neutral-secondary-medium transition">

                        <img id="image_preview"
                            src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : '' }}"
                            class="absolute inset-0 w-full h-full object-cover {{ $user->profile_picture ? '' : 'hidden' }}">

                        <div id="upload_placeholder" class="text-center {{ $user->profile_picture ? 'hidden' : '' }}">
                            <svg class="w-16 h-16 text-body mx-auto mb-2 group-hover:text-heading transition" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM3 20a6 6 0 0 1 12 0v1H3v-1z"/>
                            </svg>
                            <p class="text-xs font-medium text-body group-hover:text-heading transition">Upload Photo</p>
                            <p class="text-xs text-body mt-1">JPG, PNG up to 2MB</p>
                        </div>

                        <input type="file" name="profile_picture" id="profile_image" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>

                {{-- Profile Info Card --}}
                <div class="bg-neutral-primary-soft border border-default rounded-lg p-4">
                    <div class="mb-3">
                        <p class="text-xs font-semibold text-body uppercase tracking-wide">Member Since</p>
                        <p class="text-sm font-medium text-heading mt-1">{{ $user->created_at->format('F j, Y') }}</p>
                    </div>
                    <hr class="border-default my-3">
                    <div>
                        <p class="text-xs font-semibold text-body uppercase tracking-wide">Last Updated</p>
                        <p class="text-sm font-medium text-heading mt-1">{{ $user->updated_at->format('F j, Y') }}</p>
                    </div>
                </div>

                {{-- Quick Action Buttons --}}
                <div class="mt-4 space-y-2">
                    <button type="button"
                            onclick="confirmDelete()"
                            class="w-full text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 rounded-base px-4 py-2.5 transition">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>

        {{-- Right Column: Profile Form --}}
        <div class="lg:col-span-2">
            {{-- Personal Information Section --}}
            <div class="bg-white rounded-lg shadow-xs p-6 border border-gray-200 mb-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-heading">Personal Information</h2>
                    <p class="text-sm text-body mt-1">Update your basic account details</p>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-heading">Username</label>
                            <input type="text" name="username" id="username" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-2 focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="John" value="{{ $user->name }}" />
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-heading">Email Address</label>
                        <input type="email" name="email" id="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-2 focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="john.doe@example.com" value="{{ $user->email }}" />
                        <p class="text-xs text-body mt-1">Your email is used for login and notifications</p>
                    </div>
                </div>
            </div>

            {{-- Security Section --}}
            <div class="bg-white rounded-lg shadow-xs p-6 border border-gray-200 mb-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-heading">Security Settings</h2>
                    <p class="text-sm text-body mt-1">Manage your account security and password</p>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block mb-2 text-sm font-medium text-heading">New Password</label>
                            <input type="password" name="password" id="new_password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-2 focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="••••••••" />
                        </div>

                        <div>
                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-heading">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="confirm_password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-2 focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="••••••••" />
                        </div>
                    </div>

                    <div class="bg-neutral-primary-soft border border-default rounded-lg p-4">
                        <p class="text-xs font-semibold text-body uppercase tracking-wide mb-3">Password Requirements</p>
                        <ul class="space-y-2 text-xs text-body">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-body rounded-full"></span> At least 8 characters long</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-body rounded-full"></span> Contains uppercase letters (A-Z)</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-body rounded-full"></span> Contains numbers (0-9)</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 sticky bottom-0 bg-white pt-4 pb-6 border-t border-gray-200">
                <button type="button"
                        class="flex-1 text-heading bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary rounded-base px-4 py-2.5 font-medium text-sm transition"
                        onclick="goBack()">
                    Cancel
                </button>
                <button id="save-changes-button" type="submit" class="flex-1 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-base px-4 py-2.5 font-medium text-sm transition">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</form>

<form id="delete-account-form" action="{{ route('account.delete') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- Global Shared Component Layer --}}
<x-verification-modal />


<script>
    const accountForm = document.querySelector('form[action="{{ route('account.update') }}"]');
    const saveButton = document.getElementById('save-changes-button');
    const passwordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    const verificationHiddenInput = document.getElementById('verification_code');
    let bypassVerification = false;

    function goBack() {
        window.history.back();
    }

    function confirmDelete() {
        if (confirm('Are you sure you want to delete your account? This cannot be undone.')) {
            document.getElementById('delete-account-form').submit();
        }
    }

    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('image_preview');
        const placeholder = document.getElementById('upload_placeholder');

        reader.onload = function() {
            if (reader.readyState === 2) {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    async function sendVerificationCode() {
        const emailValue = document.getElementById('email').value.trim();
        saveButton.disabled = true;
        saveButton.textContent = 'Sending Code...';

        try {
            const response = await fetch("{{ route('account.send-code') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email: emailValue }),
            });

            const payload = await response.json();

            if (!response.ok) {
                throw new Error(payload.message || 'Unable to send verification code.');
            }

            // Code generation succeeded, show verification layout boxes
            openVerificationModal();
        } catch (error) {
            // FIXED: Handled failure gracefully by opening the new global error modal instead
            openGlobalErrorModal(error.message, 'Verification Failed');
        } finally {
            saveButton.disabled = false;
            saveButton.textContent = 'Save Changes';
        }
    }

    accountForm.addEventListener('submit', function (event) {
        if (bypassVerification) {
            return;
        }

        // Trigger code flow only if user modifies the password fields
        if (passwordInput.value.trim() !== '') {
            event.preventDefault();

            // Client-side quick check matching confirmation passwords
            if (passwordInput.value !== confirmPasswordInput.value) {
                openGlobalErrorModal('Your new password and confirmation password fields do not match.', 'Password Mismatch');
                return;
            }

            sendVerificationCode();
        }
    });

    // Capture confirmation callbacks submitted via component templates
    document.addEventListener('DOMContentLoaded', () => {
        const confirmBtn = document.getElementById('confirm-save-button');
        const modalInput = document.getElementById('verification_code_input');

        if (confirmBtn) {
            confirmBtn.addEventListener('click', function () {
                const code = modalInput.value.trim();

                if (code.length !== 6) {
                    // Update feedback inline context inside the verification box modal
                    const feedbackBox = document.getElementById('send-code-feedback');
                    if (feedbackBox) {
                        feedbackBox.textContent = 'Enter the complete 6-digit verification code.';
                        feedbackBox.classList.remove('hidden');
                    }
                    return;
                }

                verificationHiddenInput.value = code;
                bypassVerification = true;
                
                if (typeof closeVerificationModal === "function") {
                    closeVerificationModal();
                }
                
                accountForm.requestSubmit();
            });
        }
    });
    
</script>
@if($errors->has('verification_code'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const codeError = "{{ $errors->first('verification_code') }}";
            // This instantly calls your newly created global error modal!
            openGlobalErrorModal(codeError, 'Invalid Code');
        });
    </script>
@endif
@endsection