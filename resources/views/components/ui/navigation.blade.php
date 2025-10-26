<style>
    @keyframes bounce-dot {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    :root {
        --livewire-progress-bar-color: var(--color-zinc-500) !important;
    }
</style>

<div id="navigation-loader" x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center bg-accent-foreground/50 backdrop-blur-md">
    <div class="flex space-x-2">
        <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]" style="animation-delay: -0.8s;">
        </div>
        <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]" style="animation-delay: -0.4s;">
        </div>
        <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]"></div>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('livewire:navigate', (event) => {
            document.getElementById('navigation-loader').classList.remove('hidden');
        });

        document.addEventListener('livewire:navigating', () => {
            document.getElementById('navigation-loader').classList.remove('hidden');
        });

        document.addEventListener('livewire:navigated', () => {
            document.getElementById('navigation-loader').classList.add('hidden');
        });
    </script>
@endpush
