<header>
    <div class="bg-zinc-500 py-4">
        <div class="container mx-auto flex items-center justify-between px-4">
            <a href="{{ route('home') }}" wire:navigate>
                <h1 class="text-2xl font-bold text-white">B33 Rentals</h1>
            </a>
            <nav class="flex items-center justify-end gap-4">
                @auth
                    @if (auth()->guard('web')->check())
                        <a href="{{ route('user.profile') }}" class="text-white" wire:navigate>Profile</a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="text-white" wire:navigate>Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-white" wire:navigate>Login</a>
                    <a href="{{ route('register') }}" class="text-white" wire:navigate>Register</a>
                @endauth
            </nav>
        </div>
    </div>
</header>
