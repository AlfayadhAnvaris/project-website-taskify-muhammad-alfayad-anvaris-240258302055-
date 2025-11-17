<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Progressly Admin Dashboard' }}</title>

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous">

    {{-- Tailwind & Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Global Styles --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }

        .sidebar { width: 15rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-collapsed { width: 0; overflow: hidden; }
        .content-expanded { margin-left: 15rem; transition: all 0.3s; }
        .content-full { margin-left: 0; }

        @media (max-width: 768px) {
            .sidebar { width: 0; position: fixed; z-index: 45; }
            .sidebar.sidebar-mobile-open { width: 15rem; }
            .content-expanded { margin-left: 0; }
        }

        /* Scrollbar & animation style tetap sama */
        .kanban-column { animation: fadeInUp 0.4s ease-out; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="bg-gray-900 text-gray-100 antialiased">

    {{-- Navbar --}}
    @include('components.layouts.navbar')

    {{-- Sidebar admin --}}
    @include('components.layouts.sidebar-admin')

    {{-- Main Content --}}
    <main id="mainContent" class="content-expanded min-h-screen pt-16">
    @yield('content')
    </main>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
    <script defer src="//unpkg.com/alpinejs"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireScripts
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            if (sidebarToggle && sidebar && mainContent) {
                sidebarToggle.addEventListener('click', function() {
                    if (window.innerWidth >= 768) {
                        sidebar.classList.toggle('sidebar-collapsed');
                        mainContent.classList.toggle('content-full');
                        mainContent.classList.toggle('content-expanded');
                    } else {
                        sidebar.classList.toggle('sidebar-mobile-open');
                        if (sidebar.classList.contains('sidebar-mobile-open')) {
                            const overlay = document.createElement('div');
                            overlay.id = 'sidebar-overlay';
                            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40';
                            overlay.addEventListener('click', function() {
                                sidebar.classList.remove('sidebar-mobile-open');
                                this.remove();
                            });
                            document.body.appendChild(overlay);
                        } else {
                            document.getElementById('sidebar-overlay')?.remove();
                        }
                    }
                });
            }
        });
    </script>

</body>
</html>
