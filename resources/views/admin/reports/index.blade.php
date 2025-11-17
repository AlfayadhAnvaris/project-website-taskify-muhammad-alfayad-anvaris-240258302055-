<div>
    <main class="main-content flex-1 p-6 min-h-screen text-white bg-gray-900">
        <div class="container mx-auto py-6">
            <h1 class="text-2xl font-bold mb-4">Daftar Laporan</h1>

            <!-- Search -->
            <div class="mb-4">
                <input type="text" placeholder="Cari laporan..." wire:model.debounce.300ms="search"
                    class="px-4 py-2 rounded-lg text-gray-900 w-full md:w-64 focus:outline-none">
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($reports->count())
                <table class="w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="px-4 py-2 border">User</th>
                            <th class="px-4 py-2 border">Judul</th>
                            <th class="px-4 py-2 border">Kategori</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr class="hover:bg-gray-700/40 transition">
                                <td class="px-4 py-2 border">{{ $report->user->name }}</td>
                                <td class="px-4 py-2 border">{{ $report->title }}</td>
                                <td class="px-4 py-2 border">{{ $report->category }}</td>
                                <td class="px-4 py-2 border">{{ $report->created_at->format('d-m-Y H:i') }}</td>
                                <td class="px-4 py-2 border capitalize">{{ $report->status ?? 'pending' }}</td>
                                <td class="px-4 py-2 border">
                                    <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-500 hover:underline">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $reports->links() }}
                </div>

            @else
                <p class="text-gray-500 mt-4">Belum ada laporan.</p>
            @endif
        </div>
    </main>
</div>
