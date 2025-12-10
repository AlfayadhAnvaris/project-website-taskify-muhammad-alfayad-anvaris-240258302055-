<div class="p-6 text-white">

    <h1 class="text-2xl font-bold mb-4">
        📌 Daftar Board Milik: <span class="text-blue-400">{{ $user->name }}</span>
    </h1>

    <div class="bg-gray-800 p-5 rounded-xl border border-gray-700 space-y-3">

        @forelse ($boards as $board)
            <div
                class="flex justify-between items-center bg-gray-900 p-4 rounded-xl border border-gray-700 hover:border-blue-600 transition">

                <div class="space-y-1">
                    <!-- NAMA BOARD (lebih besar & jelas) -->
                    <p class="font-bold text-lg text-white">
                        {{ $board->title }}
                    </p>

                    <!-- Informasi tambahan -->
                    <div class="text-gray-400 text-sm">
                        <p>{{ $board->tasks_count }} task total
                            • Dibuat: {{ optional($board->created_at)->format('d M Y') ?? 'Tidak diketahui' }}</p>

                        @if ($board->description)
                            <p class="text-gray-500 text-xs mt-1 truncate max-w-md">
                                {{ $board->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Tombol -->
                <a href="{{ route('admin.boards.detail', $board->id) }}"
                    class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                    Buka Board
                </a>

            </div>

        @empty
            <p class="text-gray-500 italic text-sm">User ini belum membuat board.</p>
        @endforelse

    </div>

</div>
