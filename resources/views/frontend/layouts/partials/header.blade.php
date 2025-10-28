<header class="py-5 backdrop-blur-2xl transition-all duration-300">
    <div class="container flex items-center justify-between">
        <div class="flex items-center justify-start gap-12">
            <a href="{{ route('home') }}" wire:navigate class="w-full max-w-48 inline-flex">
                <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="w-full object-cover">
            </a>
            <nav class="flex items-center justify-start gap-5">
                <a href="" wire:navigate
                    class="px-3 text-base sm:text-lg hover:text-zinc-500 transition-all duration-150 ease-linear">{{ __('Ladies') }}</a>
                <a href="" wire:navigate
                    class="px-3 text-base sm:text-lg hover:text-zinc-500 transition-all duration-150 ease-linear">{{ __('Men') }}</a>
                <a href="" wire:navigate
                    class="px-3 text-base sm:text-lg hover:text-zinc-500 transition-all duration-150 ease-linear">{{ __('Teen') }}</a>
                <a href="" wire:navigate
                    class="px-3 text-base sm:text-lg hover:text-zinc-500 transition-all duration-150 ease-linear">{{ __('Kid') }}</a>
            </nav>
        </div>
        <div class="flex items-center justify-end gap-4">
            <x-ui.icon-link icon="search" class="w-6 h-6"
                iconClass="w-6 h-6 stroke-text-secondary group-hover:stroke-zinc-500" />
            <x-ui.icon-link icon="heart" class="w-6 h-6"
                iconClass="w-6 h-6 stroke-text-secondary group-hover:stroke-zinc-500" />
            <x-ui.icon-link icon="shopping-bag" class="w-6 h-6"
                iconClass="w-6 h-6 stroke-text-secondary group-hover:stroke-zinc-500" />
            <x-ui.icon-link icon="user-round" class="w-6 h-6"
                iconClass="w-6 h-6 stroke-text-secondary group-hover:stroke-zinc-500" />
        </div>
    </div>
</header>