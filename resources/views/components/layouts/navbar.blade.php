<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progressly - Navbar Baru</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f172a;
            margin: 0;
            padding: 0;
            padding-top: 70px;
        }

        .backdrop-blur-header {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .glow-logo {
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }

        .nav-item {
            position: relative;
            overflow: hidden;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: width 0.3s ease;
        }

        .nav-item:hover::after {
            width: 100%;
        }

        .search-box:focus-within {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .notification-dot {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .user-avatar {
            transition: all 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .dropdown-menu {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <nav class="bg-gray-800/80 backdrop-blur-header border-b border-gray-700 fixed top-0 left-0 right-0 z-50">
        <div class="flex items-center justify-between px-4 py-3">

            <div class="flex items-center">
                <button @click="$store.sidebar.toggle()" class="text-white px-3 py-2 focus:outline-none md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>


                <div class="flex items-center">
                    <div class="w-10 h-10 flex items-center justify-center ">
                        <img src="/favicon.ico" alt="Logo Progressly" class="w-6 h-6 rounded">
                    </div>
                    <h1
                        class="text-xl font-bold text-white hidden sm:block bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                        Progressly</h1>
                </div>
            </div>

            
            <div class="flex items-center space-x-2">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 text-gray-300 hover:text-white p-2 rounded-lg transition nav-item">
                        <img class="w-8 h-8 rounded-full ring-2 ring-gray-600 user-avatar"
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=3b82f6&color=fff"
                            alt="Avatar">
                        <span class="hidden md:block" id="userName">{{ auth()->user()->name ?? 'Guest' }}</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                            :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="absolute right-0 mt-2 w-56 bg-gray-800/90 backdrop-blur-md border border-gray-700 rounded-xl dropdown-menu py-2 z-50">
                        <a href="{{ route('user.profile') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700/50 transition rounded-lg mx-2">
                            <i class="fas fa-user w-5 mr-3 text-blue-400"></i>Profil Saya
                        </a>
                        <div class="border-t border-gray-700 my-2"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center px-4 py-2 text-sm text-red-400 hover:bg-gray-700/50 transition rounded-lg mx-2 w-[calc(100%-1rem)]">
                                <i class="fas fa-sign-out-alt w-5 mr-3"></i>Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
   

</body>

</html>
