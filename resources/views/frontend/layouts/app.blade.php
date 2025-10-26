<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ isset($title) ? $title . ' - ' : '' }}
        {{ site_name() }}
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-bg-primary custom-scrollbar overflow-y-auto">
    <div x-data="scrollHandler()" x-init="init()" @scroll.window="handleScroll">
        <!-- Ads Section -->
        <div x-show="showAds" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-full"
            :class="isFixed ? 'fixed top-0 left-0 right-0 z-50' : 'relative z-40'" class="transition-all duration-300">
            <livewire:frontend.components.ads />
        </div>

        <!-- Header -->
        <div :class="isFixed ? 'fixed left-0 right-0 z-40 animate-slideDown' : 'relative'"
            :style="isFixed && showAds ? 'top: ' + adsHeight + 'px' : 'top: 0'"
            class="transition-all duration-300 ease-in-out">
            <livewire:frontend.partials.header :pageSlug="$pageSlug ?? 'home'" />
        </div>

        <!-- Spacer when header becomes fixed - ALWAYS maintain full height to prevent jumping -->
        <div x-show="isFixed" :style="'height: ' + (headerHeight + adsHeight) + 'px'"
            class="transition-all duration-300"></div>

        <!-- Main Content -->
        <div class="flex flex-col min-h-screen">
            <div class="flex-1">
                {{ $slot }}
            </div>
            <livewire:frontend.partials.footer />
        </div>
    </div>

    <x-ui.navigation />
    @fluxScripts()
    @stack('scripts')

    <script>
        function scrollHandler() {
            return {
                isFixed: false,
                showAds: true,
                lastScrollY: 0,
                scrollThreshold: 100,
                adsHeight: 0,
                headerHeight: 0,
                ticking: false, // Throttle scroll events

                init() {
                    this.lastScrollY = window.scrollY;

                    // Measure heights after DOM is ready
                    this.$nextTick(() => {
                        const adsElement = this.$el.querySelector('[x-show="showAds"]');
                        const headerElement = this.$el.querySelector('header');
                        if (adsElement) this.adsHeight = adsElement.offsetHeight;
                        if (headerElement) this.headerHeight = headerElement.offsetHeight;
                    });
                },

                handleScroll() {
                    // Throttle scroll events to prevent glitches
                    if (!this.ticking) {
                        window.requestAnimationFrame(() => {
                            this.updateScrollPosition();
                            this.ticking = false;
                        });
                        this.ticking = true;
                    }
                },

                updateScrollPosition() {
                    const currentScrollY = window.scrollY;
                    const scrollDifference = currentScrollY - this.lastScrollY;

                    // Handle header fixed state
                    if (currentScrollY > this.scrollThreshold) {
                        this.isFixed = true;
                    } else {
                        this.isFixed = false;
                        this.showAds = true; // Always show ads when at top
                        this.lastScrollY = currentScrollY;
                        return;
                    }

                    // Handle ads visibility based on scroll direction (only when header is fixed)
                    if (this.isFixed) {
                        // Only update if scroll difference is significant enough
                        if (Math.abs(scrollDifference) > 10) {
                            if (scrollDifference > 0) {
                                // Scrolling down
                                this.showAds = false;
                            } else {
                                // Scrolling up
                                this.showAds = true;
                            }
                        }
                    }

                    this.lastScrollY = currentScrollY;
                }
            }
        }
    </script>

    <style>
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
    </style>
</body>

</html>
