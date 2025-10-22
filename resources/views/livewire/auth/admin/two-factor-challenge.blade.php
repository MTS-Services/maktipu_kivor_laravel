<div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-md p-8 mt-10">
    <!-- Header -->
    <h2 class="text-2xl font-semibold text-center text-gray-900 dark:text-gray-100 mb-2">
        Two-Factor Authentication
    </h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
        Please confirm access to your account by entering the authentication code
        provided by your authenticator app.
    </p>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <!-- Authentication Code Form -->
    <form method="POST" action="{{ route('admin.two-factor.login.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Authentication Code
            </label>
            <input type="text" id="code" name="code" maxlength="6" placeholder="000000"
                autocomplete="one-time-code" autofocus inputmode="numeric" pattern="[0-9]*"
                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-gray-100
                       shadow-sm py-2.5 px-3 text-center text-lg tracking-widest font-mono">
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Enter the 6-digit code from your authenticator app
            </p>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg
                   transition duration-150 ease-in-out shadow-sm">
            Verify Code
        </button>
    </form>

    <!-- Divider -->
    <div class="my-6 flex items-center">
        <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
        <span class="mx-3 text-sm text-gray-500 dark:text-gray-400">or</span>
        <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
    </div>
    <div class="mt-6 pt-6 border-t border-gray-200">
        <button type="button" onclick="toggleRecoveryForm()"
            class="w-full text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
            Don't have your authenticator? Use a recovery code
        </button>

        <form method="POST" action="{{ route('admin.two-factor.login.store') }}" id="recoveryForm" class="hidden mt-4">
            @csrf
            <div class="mb-4">
                <label for="recovery_code" class="block text-sm font-medium text-gray-700 mb-2">
                    Recovery Code
                </label>
                <input type="text" id="recovery_code" name="recovery_code"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter recovery code">
                <p class="text-xs text-gray-500 mt-2">Enter one of your recovery codes (stored separately)</p>
            </div>
            <button type="submit"
                class="w-full bg-gray-600 text-white font-semibold py-2 rounded-lg hover:bg-gray-700 transition duration-200">
                Verify Recovery Code
            </button>
        </form>
    </div>
    <!-- Recovery Code Form -->
    {{-- <form method="POST" action="{{ route('admin.two-factor.login.store') }}" class="space-y-5">
        @csrf
        <div>
            <label for="recovery_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Recovery Code
            </label>
            <input
                type="text"
                id="recovery_code"
                name="recovery_code"
                autocomplete="one-time-code"
                placeholder="xxxxx-xxxxx"
                class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900
                       focus:ring-2 focus:ring-gray-500 focus:border-gray-500 text-gray-900 dark:text-gray-100
                       shadow-sm py-2.5 px-3 font-mono"
            >
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Lost your device? Use one of your recovery codes
            </p>
        </div>

        <button
            type="submit"
            class="w-full bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2.5 rounded-lg
                   transition duration-150 ease-in-out shadow-sm"
        >
            Use Recovery Code
        </button>
    </form> --}}

    <!-- Back to Login -->
    <div class="mt-6 text-center">
        <a href="{{ route('admin.login') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
            ← Back to Login
        </a>
    </div>


    <script>
        function toggleRecoveryForm() {
            const form = document.getElementById('recoveryForm');
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
                document.getElementById('recovery_code').focus();
            }
        }

        // Auto-focus code input for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            if (codeInput) {
                codeInput.focus();
            }
        });
    </script>
</div>
