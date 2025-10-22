<div class="h-full z-50">
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed h-full lg:static inset-y-0 left-0 z-50 w-64 sm:w-72 md:w-80 lg:w-68 bg-zinc-950 transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-y-auto px-6">
        <div class="flex flex-col h-full">
            <!-- Mobile Close Button -->
            <div class="lg:hidden flex items-center justify-between px-4 py-3 border-b border-gray-800">
                <span class="text-white font-semibold text-lg">Menu</span>
                <button @click="sidebarOpen = false" class="text-white hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <!-- Orders Dropdown -->
                <div x-data="{
                    ordersOpen: {{ in_array($pageSlug, ['dashboard', '']) ? 'true' : 'false' }},
                    isActive: {{ in_array($pageSlug, ['dashboard', '']) ? 'true' : 'false' }}
                }">
                    <!-- Orders button -->
                    <button x-cloak @click="ordersOpen = !ordersOpen" :class="isActive ? 'bg-black relative' : 'bg-transparent'"
                        class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-white hover:bg-gray-500/50">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <img  src="{{ asset('assets/icons/light.svg') }}" alt=""
                                class="w-5 h-5 sm:w-6 sm:h-6">
                            <span class="text-xs sm:text-sm font-medium text-white">Orders</span>
                            <!-- Left indicator bar for Orders button only -->
                            <div x-show="isActive" x-cloak
                                class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-gradient-to-b from-pink-500 to-purple-600 rounded-l-full z-50">
                            </div>
                        </div>

                        <!-- Chevron Icons -->
                        <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                            class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform" stroke="white" />

                        <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                            class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform" stroke="white" />
                    </button>

                    <!-- Dropdown links (no left bar here) -->
                    <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                        <a href="{{ route('user.dashboard') }}" x-cloak
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm rounded-lg transition-all text-white hover:bg-gray-500/50 {{ $pageSlug === 'dashboard' ? 'bg-pink-500' : '' }}">
                            Dashboard
                        </a>
                        <a href="" x-cloak
                            class="block px-2 sm:px-3 py-2 text-xs sm:text-sm rounded-lg transition-all text-white hover:bg-gray-500/50 {{ $pageSlug === '' ? 'bg-pink-500' : '' }}">
                            Sold orders
                        </a>
                    </div>
                </div>



                <!-- Loyalty Link -->
                <a href="{{ route('user.profile') }}" x-cloak
                    class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-white hover:bg-gray-500/50 {{ $pageSlug === 'profile' ? 'bg-pink-500' : '' }}">
                    <flux:icon name="star" class="w-4 h-4 sm:w-5 sm:h-5 text-white" stroke="white" />
                    <span class="text-xs sm:text-sm font-medium text-white">View Profile</span>
                </a>
            </nav>
        </div>
    </aside>
</div>
