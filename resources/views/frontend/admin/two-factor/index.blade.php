<x-admin::app>
    <x-slot name="pageSlug">two-factor</x-slot>
    <x-slot name="breadcrumb">Two-Factor Authentication</x-slot>
    <x-slot name="title">Two-Factor Authentication</x-slot>

    <div class="max-w-6xl mx-auto py-6">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="p-6 bg-gradient-to-r from-purple-600 to-purple-700">
                <h2 class="text-2xl font-bold text-white">Admin Two-Factor Authentication</h2>
                <p class="text-purple-100 mt-1">Secure your admin account with additional protection</p>
            </div>
            <div class="p-6">
                <!-- Status Messages -->
                @if (session('status') === 'two-factor-authentication-enabled')
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">Two-factor authentication setup is in progress</p>
                        </div>
                    </div>
                @endif 

                @if (session('status') === 'two-factor-authentication-confirmed')
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">Two-factor authentication confirmed successfully!</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'two-factor-authentication-disabled')
                    <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">Two-factor authentication has been disabled.</p>
                        </div>
                    </div>
                @endif

                @if (session('status') === 'recovery-codes-generated')
                    <div class="mb-6 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="font-semibold">New recovery codes have been generated!</p>
                        </div>
                    </div>
                @endif

                {{-- <!-- Current Status -->
                <div class="mb-8">
                    @if ($twoFactorEnabled)
                        <div class="flex items-center gap-3 p-4 bg-blue-100 border border-blue-300 rounded-lg">
                            <div
                                class="flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-full animate-pulse">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-blue-800">Two-Factor Authentication Processing</p>
                                <p class="text-sm text-blue-700">Please wait while your two-factor verification setup is
                                    being confirmed.</p>
                            </div>
                        </div>
                    @endif
                </div> --}}


                <!-- Enable/Disable 2FA -->
                @if (!$twoFactorEnabled)
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Enable Two-Factor Authentication</h3>
                        <p class="text-gray-600 mb-6">
                            When two-factor authentication is enabled, you will be prompted for a secure, random token
                            during authentication.
                            You may retrieve this token from your phone's Google Authenticator, Authy, or any compatible
                            authenticator application.
                        </p>

                        <form method="POST" action="{{ route('admin.two-factor.enable') }}">
                            @csrf
                            <button type="submit"
                                class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-md hover:bg-purple-700 transition duration-200">
                                Enable Two-Factor Authentication
                            </button>
                        </form>
                    </div>
                @else
                    <!-- QR Code Section -->
                    @if (!auth()->guard('admin')->user()->two_factor_confirmed_at)
                        <div class="border-t pt-6 mb-6">
                            <h3 class="text-lg font-semibold mb-4">Finish Enabling Two-Factor Authentication</h3>

                            <p class="text-gray-600 mb-4">
                                To finish enabling two-factor authentication, scan the following QR code using your
                                phone's authenticator application
                                or enter the setup key and provide the generated OTP code.
                            </p>

                            <!-- QR Code Display -->
                            <div class="mb-6 p-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                <div id="qrCode" class="flex justify-center mb-4">
                                    <div class="text-center">
                                        <button type="button" onclick="loadQRCode()"
                                            class="px-6 py-3 bg-purple-600 text-white font-semibold rounded hover:bg-purple-700 transition">
                                            Show QR Code
                                        </button>
                                    </div>
                                </div>
                                <div id="qrCodeContainer" class="hidden text-center"></div>
                            </div>

                            <!-- Confirm 2FA -->
                            <form method="POST" action="{{ route('admin.two-factor.confirm') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirm with code from authenticator app
                                    </label>
                                    <input type="text" id="code" name="code"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500"
                                        placeholder="000000" maxlength="6" required>
                                </div>

                                @error('code')
                                    <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
                                @enderror

                                <button type="submit"
                                    class="px-6 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 transition duration-200">
                                    Confirm & Enable
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Recovery Codes Section -->
                    @if (auth()->guard('admin')->user()->two_factor_confirmed_at)
                        <div class="border-t pt-6 mb-6">
                            <h3 class="text-lg font-semibold mb-4">Recovery Codes</h3>
                            <p class="text-gray-600 mb-4">
                                Store these recovery codes in a secure password manager. They can be used to recover
                                access to your admin account
                                if your two-factor authentication device is lost.
                            </p>

                            <button type="button" onclick="showRecoveryCodes()"
                                class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition mb-4">
                                Show Recovery Codes
                            </button>

                            <div id="recoveryCodes" class="hidden mb-4">
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                    <div id="recoveryCodesList"
                                        class="grid grid-cols-1 md:grid-cols-2 gap-2 font-mono text-sm">
                                        <!-- Codes loaded here via JavaScript -->
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">💡 Save these codes in a safe place. Each code
                                    can only be used once.</p>
                            </div>

                            <form method="POST" action="{{ route('admin.two-factor.recovery-codes.store') }}"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition"
                                    onclick="return confirm('This will invalidate all your old recovery codes. Are you sure?')">
                                    Regenerate Recovery Codes
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Cancel 2FA -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4 text-red-600">Cancel Processing</h3>
                        <p class="text-gray-600 mb-4">
                            ⚠️ <strong>Warning:</strong> Cancel two-factor authentication processing will make your admin
                            account significantly less secure.
                        </p>

                        <form method="POST" action="{{ route('admin.two-factor.disable') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-6 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition duration-200"
                                onclick="return confirm('Are you sure you want to cancel Processing for your admin account?')">
                                Cancel Processing
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-6 text-center">
            <a href="{{ route('admin.dashboard') }}" class="text-purple-600 hover:text-purple-800 font-medium">
                ← Back to Admin Dashboard
            </a>
        </div>
    </div>

    <script>
        function loadQRCode() {
            fetch('{{ route('admin.two-factor.qr-code') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('qrCodeContainer').innerHTML = data.svg;
                    document.getElementById('qrCodeContainer').classList.remove('hidden');
                    document.getElementById('qrCode').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error loading QR code:', error);
                    alert('Failed to load QR code. Please try again.');
                });
        }

        function showRecoveryCodes() {
            fetch('{{ route('admin.two-factor.recovery-codes') }}')
                .then(response => response.json())
                .then(codes => {
                    const container = document.getElementById('recoveryCodesList');
                    container.innerHTML = codes.map(code =>
                        `<div class="p-3 bg-white border border-gray-300 rounded text-center font-bold">${code}</div>`
                    ).join('');
                    document.getElementById('recoveryCodes').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error loading recovery codes:', error);
                    alert('Failed to load recovery codes. Please try again.');
                });
        }
    </script>
</x-admin::app>
