<aside id="sidebarUser"
    class="sidebar bg-gray-800 border-r border-gray-700 fixed left-0 top-16 h-[calc(100vh-4rem)] z-20 
    overflow-y-auto transform transition-transform -translate-x-full md:translate-x-0">
    <div class="p-4 flex flex-col h-full">

        <!-- Navigation Menu -->
        <div class="mb-8">
            <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 px-2">Menu Utama</h2>
            <ul class="space-y-2">

                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200
                        {{ request()->routeIs('user.dashboard') 
                            ? 'text-white bg-blue-600 shadow-lg' 
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                {{-- Boards --}}
                <li>
                    <a href="{{ route('user.boards.index') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200
                        {{ request()->routeIs('user.boards.*') 
                            ? 'text-white bg-blue-600 shadow-lg' 
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-tasks w-5 text-center"></i>
                        <span class="font-medium">Board Saya</span>
                    </a>
                </li>

                {{-- Reports --}}
                <li>
                    <a href="{{ route('user.reports.index') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200
                        {{ request()->routeIs('user.reports.*') 
                            ? 'text-white bg-blue-600 shadow-lg' 
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-file-alt w-5 text-center"></i>
                        <span class="font-medium">Laporan Saya</span>
                    </a>
                </li>

                {{-- Tim --}}
                <li>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span class="font-medium">Tim</span>
                    </a>
                </li>

            </ul>
        </div>

        <!-- Projects Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4 px-2">
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Proyek</h2>
                <button class="text-gray-400 hover:text-white transition-colors duration-200 p-1 rounded">
                    <i class="fas fa-plus text-sm"></i>
                </button>
            </div>
            <ul class="space-y-2">
                <li>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <span class="text-sm font-medium">Web Development</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-sm font-medium">Mobile App</span>
                    </a>
                </li>
            </ul>
        </div>

      

    </div>
</aside>