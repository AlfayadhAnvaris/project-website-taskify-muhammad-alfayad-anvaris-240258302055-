<div>
    <main class="main-content flex-1 p-6 min-h-screen text-white bg-gray-900">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">👥 Manajemen User</h1>
                <p class="text-gray-400 text-sm mt-1">Kelola semua pengguna sistem dengan mudah.</p>
            </div>
        </div>

        <!-- Table Container -->
        <div class="max-w-6xl mx-auto bg-gray-800/60 backdrop-blur-sm border border-gray-700 rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-700">
                    <thead class="bg-gray-800/80">
                        <tr>
                            <th class="py-4 px-4 w-[60px] text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                #
                            </th>
                            <th class="py-4 px-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="py-4 px-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="py-4 px-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider w-[100px]">
                                Boards
                            </th>
                            <th class="py-4 px-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider w-[100px]">
                                Tasks
                            </th>
                            <th class="py-4 px-4 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider w-[180px]">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-700 bg-gray-800/40">
                        @foreach ($users as $index => $user)
                            <tr class="hover:bg-gray-700/60 transition-colors duration-200">
                                <td class="py-4 px-4 text-gray-300 text-center text-sm">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Nama + Link -->
                                <td class="py-4 px-4">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="font-medium text-white hover:text-indigo-300 transition-colors duration-200 flex items-center">
                                        <span class="truncate max-w-[180px]">{{ $user->name }}</span>
                                    </a>
                                </td>

                                <!-- Email -->
                                <td class="py-4 px-4 text-gray-300 text-sm truncate max-w-[200px]">
                                    {{ $user->email }}
                                </td>

                                <!-- Boards Count -->
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-blue-900/30 text-blue-300 text-sm font-medium">
                                        {{ $user->boards_count }}
                                    </span>
                                </td>

                                <!-- Tasks Count -->
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-green-900/30 text-green-300 text-sm font-medium">
                                        {{ $user->tasks_count }}
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-center space-x-3">
                                        <!-- Lihat Detail -->
                                        <a href="{{ route('admin.users.show', $user->id) }}" 
                                           class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors duration-200 group"
                                           title="Lihat Detail User">
                                            <i class="fas fa-eye text-gray-300 group-hover:text-white"></i>
                                        </a>

                                        <!-- Boards User -->
                                        <div class="flex items-center">
                                            @forelse ($user->boards->take(2) as $board)
                                                <a href="{{ route('admin.boards.detail', $board->id) }}" 
                                                   class="p-2 bg-gray-700 hover:bg-indigo-600 rounded-lg transition-colors duration-200 group mr-1"
                                                   title="{{ $board->name }}">
                                                    <i class="fas fa-layer-group text-gray-300 group-hover:text-white"></i>
                                                </a>
                                            @empty
                                                <!-- User belum punya board -->
                                                <span class="p-2 bg-gray-700 rounded-lg cursor-not-allowed" 
                                                      title="Belum ada board">
                                                    <i class="fas fa-layer-group text-gray-500"></i>
                                                </span>
                                            @endforelse
                                            
                                            @if($user->boards->count() > 2)
                                                <span class="text-xs text-gray-400 ml-1" 
                                                      title="{{ $user->boards->count() - 2 }} board lainnya">
                                                    +{{ $user->boards->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Delete User -->
                                        <button wire:click="deleteUser({{ $user->id }})" 
                                                class="p-2 bg-gray-700 hover:bg-red-600 rounded-lg transition-colors duration-200 group"
                                                title="Hapus User"
                                                onclick="return confirm('Yakin ingin menghapus user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                            <i class="fas fa-trash text-gray-300 group-hover:text-white"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State -->
            @if($users->isEmpty())
                <div class="py-12 text-center">
                    <div class="text-gray-400 text-5xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-300 mb-2">Tidak ada user</h3>
                    <p class="text-gray-500">Belum ada user yang terdaftar dalam sistem.</p>
                </div>
            @endif
        </div>
    </main>
</div>