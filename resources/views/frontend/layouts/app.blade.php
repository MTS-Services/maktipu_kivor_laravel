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
    @fluxAppearance()
    <style>
        :root {
            --livewire-progress-bar-color: var(--accent);
        }
    </style>
    @stack('styles')
</head>

<body class="h-screen flex flex-col">
    <livewire:frontend.partials.header :pageSlug="$pageSlug ?? 'home'" />
    <main class="flex-1">
        {{ $slot }}
    </main>
    <livewire:frontend.partials.footer />
    @fluxScripts()
    
    @stack('scripts')
</body>

</html>
