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

<body class="min-h-screen flex flex-col custom-scrollbar overflow-y-auto bg-bg-primary">
    <livewire:frontend.partials.header :pageSlug="$pageSlug ?? 'home'" />

    <div class="flex-1">
        {{ $slot }}
        <livewire:frontend.partials.footer />
    </div>

    <x-ui.navigation />

    @fluxScripts()

    @stack('scripts')
</body>

</html>
