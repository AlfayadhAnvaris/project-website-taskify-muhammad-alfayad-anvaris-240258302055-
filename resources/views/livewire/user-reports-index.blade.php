<div class="p-6 text-white bg-gray-900 min-h-screen">

    <x-toast />

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Laporan Saya</h1>
        <a href="{{ route('user.reports.create') }}"
           class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded-lg text-white shadow">
            <i class="fas fa-plus mr-2"></i> Buat Laporan
        </a>
    </div>

    <div class="bg-gray-800/70 backdrop-blur-sm rounded-xl border border-gray-700 p-5">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-700 text-gray-400 text-sm">
                    <th class="py-3">Judul</th>
                    <th class="py-3">Kategori</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reports as $report)
                    <tr class="border-b border-gray-700/60">
                        <td class="py-3 font-medium">{{ $report->title }}</td>
                        <td class="py-3 capitalize">{{ str_replace('_',' ', $report->category) }}</td>
                        <td class="py-3">
                            @if ($report->status == 'pending')
                                <span class="px-3 py-1 text-xs bg-yellow-600/40 text-yellow-300 rounded-full">Menunggu</span>
                            @elseif ($report->status == 'approved')
                                <span class="px-3 py-1 text-xs bg-green-600/40 text-green-300 rounded-full">Disetujui</span>
                            @else
                                <span class="px-3 py-1 text-xs bg-red-600/40 text-red-300 rounded-full">Ditolak</span>
                            @endif
                        </td>
                        <td class="py-3 text-center">
                            <button data-modal-target="modal_{{ $report->id }}"
                                    class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div id="modal_{{ $report->id }}"
                        class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">

                        <div class="bg-gray-800 w-full max-w-lg p-6 rounded-xl border border-gray-700">
                            <h2 class="text-xl font-bold mb-3">{{ $report->title }}</h2>

                            <p class="text-gray-400 text-sm mb-2">
                                Kategori: <span class="capitalize">{{ $report->category }}</span>
                            </p>

                            <p class="text-gray-300 leading-relaxed mb-4">{{ $report->content }}</p>

                            @if($report->attachment)
                                <a href="{{ asset('storage/' . $report->attachment) }}"
                                   target="_blank" class="text-blue-400 underline text-sm">
                                   Lihat Lampiran
                                </a>
                            @endif

                            @if($report->admin_note)
                                <div class="mt-4 p-3 bg-gray-700 rounded-lg">
                                    <p class="text-sm text-gray-400">Catatan Admin:</p>
                                    <p class="text-gray-200">{{ $report->admin_note }}</p>
                                </div>
                            @endif

                            <button onclick="document.getElementById('modal_{{ $report->id }}').classList.add('hidden')"
                                class="mt-4 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-lg">
                                Tutup
                            </button>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
document.querySelectorAll('[data-modal-target]').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById(btn.getAttribute('data-modal-target')).classList.remove('hidden');
    });
});
</script>
c