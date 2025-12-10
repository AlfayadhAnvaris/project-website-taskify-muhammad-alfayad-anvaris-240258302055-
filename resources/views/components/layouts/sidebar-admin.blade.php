<aside id="sidebarAdmin"
    class="sidebar bg-gray-800 border-r border-gray-700 fixed left-0 top-16 h-[calc(100vh-4rem)] z-20 
    overflow-y-auto transform transition-transform -translate-x-full md:translate-x-0">
    <div class="p-4 flex flex-col h-full">

        <!-- Navigation Menu -->
        <div class="mb-8">
            <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 px-2">Menu Admin</h2>
            <ul class="space-y-2">

                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200
                        {{ request()->routeIs('admin.dashboard')
                            ? 'text-white bg-blue-600 shadow-lg'
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-gauge w-5 text-center"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                {{-- Kelola User --}}
                <li>
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200
                        {{ request()->routeIs('admin.users*')
                            ? 'text-white bg-blue-600 shadow-lg'
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-user w-5 text-center"></i>
                        <span class="font-medium">Kelola User</span>
                    </a>
                </li>

                {{-- Log Aktivitas --}}
                <li>
                    <a href="{{ route('admin.logs.index') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200
                        {{ request()->routeIs('admin.logs*')
                            ? 'text-white bg-blue-600 shadow-lg'
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-clipboard-list w-5 text-center"></i>
                        <span class="font-medium">Log Aktivitas</span>
                    </a>
                </li>

                {{-- Laporan --}}
                <li>
                    <a href="{{ route('admin.reports.index') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200  {{ request()->routeIs('admin.reports*')
                            ? 'text-white bg-blue-600 shadow-lg'
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-chart-bar w-5 text-center"></i>
                        <span class="font-medium">Laporan</span>
                    </a>
                </li>
                {{-- Teams --}}
                <li>
                    <a href="{{ route('admin.teams') }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200  {{ request()->routeIs('admin.teams*')  
                            ? 'text-white bg-blue-600 shadow-lg'
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                       <i class="fas fa-users w-5 text-center"></i
                        <span class="font-medium">Team Management</span>
                    </a>
                </li>

            </ul>
        </div>



    </div>
</aside>
