<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Progressly - Kanban Board' }}</title>

    {{-- Styles & Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')

    {{-- Font --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Custom Styles --}}
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: #0f172a;
        }
        
        /* Smooth transitions for sidebar */
        .sidebar {
            transition: all 0.3s ease-in-out;
            width: 16rem;
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
            width: 0;
        }
        
        .content-expanded { 
            margin-left: 16rem; 
            transition: all 0.3s ease-in-out;
            width: calc(100% - 16rem);
        }
        
        .content-full { 
            margin-left: 0; 
            width: 100%;
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .content-expanded {
                margin-left: 0;
                width: 100%;
            }
        }
        
        /* Ensure proper scrolling */
        .main-content {
            min-height: calc(100vh - 4rem);
        }
    </style>
</head>

<body class="bg-gray-900 text-gray-100 antialiased">

    {{-- Navbar --}}
    @include('components.layouts.navbar')

    {{-- Sidebar (per role) --}}
    @yield('sidebar')

    {{-- Main content --}}
    <main id="mainContent" class="content-expanded main-content pt-16 transition-all duration-300">
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    {{-- Scripts --}}
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('content-expanded');
            mainContent.classList.toggle('content-full');
        }
        
        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }
        
        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('[data-toggle-sidebar]');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>