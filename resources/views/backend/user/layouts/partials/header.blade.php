<header class="bg-gray-950 px-3 sm:px-4 md:px-6 py-3 sm:py-4 z-10">
    <div class="flex items-center justify-between">
        <!-- Logo and Mobile Menu -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Mobile Menu Toggle -->
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-white hover:text-gray-300">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('user.dashboard') }}" wire:navigate>
                <img src="{{ asset('assets/images/header_logo.png') }}" alt="Logo"
                    class="h-6 sm:h-8 w-auto">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-4 xl:gap-6 absolute left-1/2 transform -translate-x-1/2">
            <a href="#"
                class="text-xs xl:text-sm font-medium pb-1 transition-all border-b-2 whitespace-nowrap
        {{ $pageSlug === 'currency' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Currency
            </a>

            <a href="#"
                class="text-xs xl:text-sm font-medium pb-1 transition-all border-b-2 whitespace-nowrap
        {{ $pageSlug === 'gift-cards' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Gift Cards
            </a>

            <a href="#"
                class="text-xs xl:text-sm font-medium pb-1 transition-all border-b-2 whitespace-nowrap
        {{ $pageSlug === 'boosting' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Boosting
            </a>

            <a href="#"
                class="text-xs xl:text-sm font-medium pb-1 transition-all border-b-2 whitespace-nowrap
        {{ $pageSlug === 'items' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Items
            </a>

            <a href="#"
                class="text-xs xl:text-sm font-medium pb-1 transition-all border-b-2 whitespace-nowrap
        {{ $pageSlug === 'accounts' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Accounts
            </a>

            <a href="#"
                class="text-xs xl:text-sm font-medium pb-1 transition-all border-b-2 whitespace-nowrap
        {{ $pageSlug === 'top-ups' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Top Ups
            </a>

            <a href="#"
                class="text-xs xl:text-sm font-medium pb-1 transition-all border-b-2 whitespace-nowrap
        {{ $pageSlug === 'coaching' ? 'text-white border-purple-500' : 'text-gray-200 border-transparent hover:text-white hover:border-purple-500' }}">
                Coaching
            </a>

            <!-- Desktop Search -->
            <div class="relative hidden xl:block">
                <flux:icon name="magnifying-glass"
                    class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-white" stroke="white" />
                <input type="text" placeholder="Search"
                    class="border border-white rounded-full py-1.5 pl-8 pr-2 text-sm text-white placeholder-gray-100 focus:outline-none focus:border-purple-500 focus:bg-gray-800 transition-all w-22 focus:w-64 bg-transparent">
            </div>
        </nav>

        <!-- Right Side Icons -->
        <div class="flex items-center gap-1 sm:gap-2">
            <!-- Mobile Search -->
            <button class="lg:hidden text-white hover:bg-gray-800 p-1.5 sm:p-2 rounded transition-all">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

            <!-- Messages -->
            <button class="text-white hover:bg-gray-800 p-1 sm:p-1.5 rounded transition-all">
                <img src="{{ asset('assets/icons/MessengerLogo.svg') }}" alt="Messages" class="w-5 h-5 sm:w-6 sm:h-6">
            </button>

            <!-- Notifications -->
            <button class="text-white hover:bg-gray-800 p-1 sm:p-1.5 md:p-2 rounded transition-all relative">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span
                    class="absolute -top-1 -right-1 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs font-bold px-1 sm:px-1.5 py-0.5 rounded-full min-w-[18px] sm:min-w-[20px] text-center">1</span>
            </button>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="flex items-center p-1 sm:p-1.5 rounded-lg text-white hover:bg-gray-800 transition-all focus:outline-none">
                    <div
                        class="w-7 h-7 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full overflow-hidden">
                        <img src="{{ storage_url(auth()->user()->avatar) }}" class="w-full h-full object-cover"
                            alt="{{ auth()->user()->full_name ?? 'User Avatar' }}">
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-cloak @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute right-0 mt-2 w-48 sm:w-56 bg-gray-900 border border-gray-800 rounded-lg shadow-lg overflow-hidden z-50">

                    <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-800">
                        <p class="text-xs sm:text-sm font-semibold text-white truncate">{{ auth()->user()->full_name }}
                        </p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <a href="{{ route('user.profile') }}"
                        class="block px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <nav class="lg:hidden mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-800 flex flex-wrap gap-2 sm:gap-3">
        <a href="#"
            class="text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Currency</a>
        <a href="#"
            class="text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Gift
            Cards</a>
        <a href="#"
            class="text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Boosting</a>
        <a href="#"
            class="text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Items</a>
        <a href="#"
            class="text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Accounts</a>
        <a href="#"
            class="text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Top Ups</a>
        <a href="#"
            class="text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">Coaching</a>
    </nav>
</header>
