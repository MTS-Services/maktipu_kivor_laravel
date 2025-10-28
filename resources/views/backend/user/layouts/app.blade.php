<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: false, mobileMenuOpen: false }"
    class="h-full max-h-screen antialiased bg-gray-950 text-gray-100">

    <div class="flex flex-col h-screen">
        <livewire:backend.user.partials.header :pageSlug="$pageSlug" />

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <livewire:backend.user.partials.sidebar :pageSlug="$pageSlug" />
            <!-- Main content -->
            <div class="flex-1 flex flex-col custom-scrollbar overflow-y-auto">
                <main class="flex-1 p-4 lg:p-6">
                    <div class="mx-auto space-y-6">
                        {{ $slot }}
                    </div>
                </main>

            </div>
        </div>
    </div>


    @fluxScripts

    @stack('scripts')
</body>

</html>
