<div>
    <main class="main-content flex-1 p-6 min-h-screen text-white bg-gray-900">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">🕓 Log Aktivitas</h1>

            <button wire:click="clearAll" 
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition"
                onclick="confirm('Yakin ingin menghapus semua log?') || event.stopImmediatePropagation()">
                <i class="fas fa-trash mr-2"></i> Hapus Semua
            </button>
        </div>

        <div class="bg-gray-800/60 backdrop-blur-sm border border-gray-700 rounded-2xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800/80">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-400 uppercase">Waktu</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-400 uppercase">User</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-400 uppercase">Aksi</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-400 uppercase">Deskripsi</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-400 uppercase">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-700/40 transition">
                            <td class="px-4 py-3 text-gray-400">{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 text-blue-400">{{ $log->user->name ?? 'System' }}</td>
                            <td class="px-4 py-3">{{ $log->action }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $log->description }}</td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="deleteLog({{ $log->id }})"
                                    class="text-red-400 hover:text-red-300 transition"
                                    onclick="confirm('Hapus log ini?') || event.stopImmediatePropagation()">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Belum ada aktivitas yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>

    </main>
</div>
