<aside id="sidebarUser"
    x-show="$store.sidebar.open"
    @click.outside="$store.sidebar.open = false"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="-translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="-translate-x-full opacity-0"
    class="sidebar bg-gray-800 border-r border-gray-700 fixed left-0 top-16
        h-[calc(100vh-4rem)] z-20 overflow-y-auto transform md:translate-x-0 md:block
        transition-transform">

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
                    <a href="{{ route('user.teams') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span class="font-medium">Tim</span>
                    </a>
                </li>

            </ul>
        </div>


    </div>
</aside>