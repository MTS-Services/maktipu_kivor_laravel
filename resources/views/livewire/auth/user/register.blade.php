<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-zinc-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-zinc-400 to-zinc-800 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ __('Create an account') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                {{ __('Join us today and get started in minutes') }}
            </p>
        </div>

        <!-- Card Container -->
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="p-8 sm:p-10">
                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" wire:submit="register" class="space-y-6">
                    <!-- Username Field -->
                    <div class="relative">
                        <x-ui.label for="username" :value="__('Username')" required />
                        <div class="relative">
                            <x-ui.input
                                wire:model.live="username"
                                id="username"
                                type="text"
                                required
                                autofocus
                                autocomplete="username"
                                :placeholder="__('johndoe')"
                            />
                        </div>
                        <x-ui.input-error :messages="$errors->get('username')" class="mt-1" />
                    </div>

                    <!-- Name Fields Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div>
                            <x-ui.label for="first_name" :value="__('First name')" />
                            <x-ui.input
                                wire:model="first_name"
                                id="first_name"
                                type="text"
                                autocomplete="given-name"
                                :placeholder="__('John')"
                                class="mt-1"
                            />
                            <x-ui.input-error :messages="$errors->get('first_name')" class="mt-1" />
                        </div>

                        <!-- Last Name -->
                        <div>
                            <x-ui.label for="last_name" :value="__('Last name')" />
                            <x-ui.input
                                wire:model="last_name"
                                id="last_name"
                                type="text"
                                autocomplete="family-name"
                                :placeholder="__('Doe')"
                                class="mt-1"
                            />
                            <x-ui.input-error :messages="$errors->get('last_name')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="relative">
                        <x-ui.label for="email" :value="__('Email address')" required />
                        <div class="relative">
                            <x-ui.input
                                wire:model="email"
                                id="email"
                                type="email"
                                required
                                autocomplete="email"
                                placeholder="john@example.com"
                            />
                        </div>
                        <x-ui.input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Phone and Country Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Phone -->
                        <div>
                            <x-ui.label for="phone" :value="__('Phone number')" />
                            <div class="relative">
                                <x-ui.input
                                    wire:model="phone"
                                    id="phone"
                                    type="tel"
                                    autocomplete="tel"
                                    :placeholder="__('+1 (555) 123-4567')"
                                />
                            </div>
                            <x-ui.input-error :messages="$errors->get('phone')" class="mt-1" />
                        </div>

                        <!-- Country -->
                        <div>
                            <x-ui.label for="country_id" :value="__('Country')" required />
                            <div class="relative">
                               
                                <x-ui.select
                                    wire:model="country_id"
                                    id="country_id"
                                    required
                                    class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-zinc-500 focus:ring-zinc-500 dark:focus:border-zinc-500 dark:focus:ring-zinc-500 transition-colors"
                                >
                                    <option value="">{{ __('Select your country') }}</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}"> {{ $country->name }}</option>
                                    @endforeach
                                </x-ui.select>
                            </div>
                            <x-ui.input-error :messages="$errors->get('country_id')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Password Fields Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <x-ui.label for="password" :value="__('Password')" required />
                            <div class="relative">
                                <x-ui.input
                                    wire:model="password"
                                    id="password"
                                    type="password"
                                    required
                                    autocomplete="new-password"
                                    :placeholder="__('••••••••')"
                                    class="pl-10"
                                />
                            </div>
                            <x-ui.input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-ui.label for="password_confirmation" :value="__('Confirm password')" required />
                            <div class="relative">
                                <x-ui.input
                                    wire:model="password_confirmation"
                                    id="password_confirmation"
                                    type="password"
                                    required
                                    autocomplete="new-password"
                                    :placeholder="__('••••••••')"
                                    class="pl-10"
                                />
                            </div>
                            <x-ui.input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Terms and Privacy Section -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 space-y-3 border border-gray-200 dark:border-gray-700">
                        <!-- Terms Checkbox -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5 mt-0.5">
                                <input
                                    wire:model="terms_accepted"
                                    id="terms_accepted"
                                    type="checkbox"
                                    class="w-4 h-4 text-zinc-600 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 rounded focus:ring-zinc-500 dark:focus:ring-zinc-600 focus:ring-2 transition-colors cursor-pointer"
                                    required
                                />
                            </div>
                            <label for="terms_accepted" class="ms-3 text-sm text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                                {{ __('I agree to the') }}
                                <a href="#" class="font-semibold text-zinc-600 hover:text-zinc-700 dark:text-zinc-500 dark:hover:text-zinc-400 underline decoration-2 underline-offset-2 transition-colors">
                                    {{ __('Terms of Service') }}
                                </a>
                            </label>
                        </div>
                        <x-ui.input-error :messages="$errors->get('terms_accepted')" />

                        <!-- Privacy Checkbox -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5 mt-0.5">
                                <input
                                    wire:model="privacy_accepted"
                                    id="privacy_accepted"
                                    type="checkbox"
                                    class="w-4 h-4 text-zinc-600 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 rounded focus:ring-zinc-500 dark:focus:ring-zinc-600 focus:ring-2 transition-colors cursor-pointer"
                                    required
                                />
                            </div>
                            <label for="privacy_accepted" class="ms-3 text-sm text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                                {{ __('I agree to the') }}
                                <a href="#" class="font-semibold text-zinc-600 hover:text-zinc-700 dark:text-zinc-500 dark:hover:text-zinc-400 underline decoration-2 underline-offset-2 transition-colors">
                                    {{ __('Privacy Policy') }}
                                </a>
                            </label>
                        </div>
                        <x-ui.input-error :messages="$errors->get('privacy_accepted')" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="group relative w-full flex justify-center items-center px-6 py-3.5 bg-gradient-to-r from-zinc-600 to-zinc-600 hover:from-zinc-700 hover:to-zinc-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-zinc-300 dark:focus:ring-zinc-800"
                        >
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            {{ __('Create account') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Section -->
            <div class="px-8 sm:px-10 py-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Already have an account?') }}
                        <a
                            href="{{ route('login') }}"
                            wire:navigate
                            class="font-semibold text-zinc-600 hover:text-zinc-700 dark:text-zinc-500 dark:hover:text-zinc-400 transition-colors ml-1"
                        >
                            {{ __('Log in') }} →
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ __('By creating an account, you agree to our terms and conditions') }}
            </p>
        </div>
    </div>
</div>