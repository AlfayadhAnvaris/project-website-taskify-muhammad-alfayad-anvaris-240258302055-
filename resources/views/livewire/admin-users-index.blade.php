<div>
    <main class="main-content flex-1 p-6 min-h-screen text-white bg-gray-900">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">👥 Manajemen User</h1>
                <p class="text-gray-400 text-sm">Kelola semua pengguna sistem dengan mudah.</p>
            </div>

            <!-- Search -->
            <div class="mt-4 md:mt-0">
                <input type="text" placeholder="Cari user..." wire:model.debounce.300ms="search"
                    class="px-4 py-2 rounded-lg text-gray-900 focus:outline-none w-full md:w-64">
            </div>
        </div>

        <!-- Table Container -->
        <div class="max-w-5xl mx-auto bg-gray-800/60 backdrop-blur-sm border border-gray-700 rounded-2xl shadow-lg overflow-hidden">
            <table class="w-full divide-y divide-gray-700">
                <thead class="bg-gray-800/80">
                    <tr>
                        <th class="py-3 px-4 w-[60px] text-left text-sm font-semibold text-gray-400 uppercase tracking-wider">#</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="py-3 px-2 text-center text-sm font-semibold text-gray-400 uppercase tracking-wider w-[90px]">Boards</th>
                        <th class="py-3 px-2 text-center text-sm font-semibold text-gray-400 uppercase tracking-wider w-[90px]">Tasks</th>
                        <th class="py-3 px-4 text-center text-sm font-semibold text-gray-400 uppercase tracking-wider w-[120px]">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700">
                    @foreach ($users as $index => $user)
                        <tr class="hover:bg-gray-700/40 transition">
                            <td class="py-3 px-4 text-gray-400 text-center">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-semibold truncate">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="hover:underline text-white">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-gray-300 truncate">{{ $user->email }}</td>
                            <td class="py-3 px-2 text-center font-medium text-blue-400">{{ $user->boards_count }}</td>
                            <td class="py-3 px-2 text-center font-medium text-green-400">{{ $user->tasks_count }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="text-indigo-400 hover:text-indigo-300 transition" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button wire:click="deleteUser({{ $user->id }})"
                                        class="text-red-500 hover:text-red-400 transition"
                                        title="Hapus User"
                                        onclick="confirm('Yakin ingin menghapus user ini?') || event.stopImmediatePropagation()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
