<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Admin Profile') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                {{-- <x-ui.button href="{{ route('admin.am.admin.index') }}" type='secondary' class="flex-1 sm:flex-none">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    <span class="sm:inline text-white">{{ __('Back') }}</span>
                </x-ui.button> --}}
                <x-ui.button href="{{ route('admin.am.admin.index') }}" class="flex-1 sm:flex-none">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    <span class="sm:inline text-white">{{ __('Back') }}</span>
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="bg-white shadow rounded-xl p-6 min-h-[500px]">
        {{-- PERSONAL INFO (Default Tab) --}}

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Left Column --}}
            <div class="flex flex-col h-auto p-4 border-r lg:border-r-2 border-gray-100">
                <h2 class="text-xl text-gray-800 font-semibold mb-6">Profile Image</h2>

                <div class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-red-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $admin->avatar) }}" alt="Profile Image"
                        class="w-full h-full object-cover">
                </div>

                <div class="flex flex-col items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-center mb-1">{{ $admin->name }}</h3>
                    <p class="text-gray-600">{{ $admin->email }}</p>
                </div>

                <div class="space-y-4 text-sm">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-gray-500">Phone</p>
                            <p class="font-medium text-gray-900">{{ $admin->phone }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-gray-500">Email</p>
                            <p class="font-medium text-gray-900">{{ $admin->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002 12c0 2.514.805 4.851 2.152 6.744.912 1.258 2.057 2.378 3.394 3.315C8.922 23.473 10.45 24 12 24c1.55 0 3.078-.527 4.454-1.282 1.337-.937 2.482-2.057 3.394-3.315C21.195 16.851 22 14.514 22 12c0-3.37-1.37-6.495-3.69-8.744l-.382-.36z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-gray-500">Account Status</p>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold inline-block 
                                    @if ($admin->status_label === 'Active') bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif">
                                {{ $admin->status_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-span-1 lg:col-span-2 p-4">
                <h2 class="text-xl font-semibold mb-6 border-b pb-2 text-gray-800">Profile Information</h2>

                <div class="grid md:grid-cols-2 gap-8 text-base">
                    {{-- First Name --}}
                    <div>
                        <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">Name</p>
                        <h3 class="text-lg font-medium text-gray-900">{{ $admin->name }}</h3>
                    </div>

                    {{-- Email --}}
                    <div>
                        <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">Email</p>
                        <h3 class="text-lg font-medium text-gray-900">{{ $admin->email }}</h3>
                    </div>

                    {{-- phone --}}
                    <div>
                        <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">Phone</p>
                        <h3 class="text-lg font-medium text-gray-900">{{ $admin->phone }}</h3>
                    </div>

                    {{-- Status --}}
                    <div>
                        <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">Status</p>
                        {{-- <h3 class="text-lg font-medium text-gray-900">{{ $admin->date_of_birth }}</h3> --}}
                        <h3
                            class="px-3 py-1 rounded-full text-xs font-bold inline-block 
                                    @if ($admin->status_label === 'Active') bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif">
                            {{ $admin->status_label }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
