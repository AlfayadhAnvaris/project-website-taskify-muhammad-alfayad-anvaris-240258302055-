<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Progressly - Kanban Board' }}</title>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body { font-family: 'Inter', sans-serif; background: #0f172a; }

        .sidebar {
            transition: all 0.3s ease-in-out;
            width: 16rem;
        }
        .sidebar.collapsed { transform: translateX(-100%); width: 0; }
        .content-expanded { margin-left: 16rem; width: calc(100% - 16rem); transition: all 0.3s ease-in-out; }
        .content-full { margin-left: 0; width: 100%; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .content-expanded { margin-left: 0; width: 100%; }
        }
        .main-content { min-height: calc(100vh - 4rem); }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: false,
                toggle() { this.open = !this.open }
            });
        });
    </script>
</head>

<body class="bg-gray-900 text-gray-100 antialiased">

    {{-- Navbar --}}
    @include('components.layouts.navbar')

    {{-- Sidebar --}}
    @yield('sidebar')

    {{-- Main Content --}}
    <main id="mainContent" class="content-expanded main-content pt-16 transition-all duration-300">
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    @livewireScripts
    @stack('scripts')
</body>
</html>
