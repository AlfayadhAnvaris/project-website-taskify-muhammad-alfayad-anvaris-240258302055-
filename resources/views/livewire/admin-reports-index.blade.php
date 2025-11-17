<div class="main-content flex-1 p-4 md:p-6 min-h-screen text-white bg-gray-900">
    <x-toast />
    
    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Daftar Laporan</h1>
                <p class="text-gray-400">Kelola dan pantau semua laporan dari pengguna</p>
            </div>
            
        </div>

        {{-- Search & Filters --}}
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                {{-- Search --}}
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Cari Laporan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            placeholder="Cari berdasarkan judul, user, atau kategori..." 
                            wire:model.debounce.300ms="search"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg pl-10 pr-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        >
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="w-full md:w-48">
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Filter Status</label>
                    <select 
                        wire:model="statusFilter"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                    >
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>

                {{-- Category Filter --}}
                <div class="w-full md:w-48">
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Filter Kategori</label>
                    <select 
                        wire:model="categoryFilter"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                    >
                        <option value="">Semua Kategori</option>
                        <option value="progress_report">Progress Report</option>
                        <option value="issue_report">Issue Report</option>
                        <option value="feature_request">Feature Request</option>
                        <option value="bug_report">Bug Report</option>
                        <option value="weekly_report">Weekly Report</option>
                        <option value="monthly_report">Monthly Report</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-green-400 font-semibold">Sukses!</p>
                        <p class="text-green-300 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Reports Table --}}
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700 overflow-hidden">
            @if($reports->count())
                {{-- Table Container --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700 bg-gray-800/80">
                                <th class="py-4 px-6 text-left">
                                    <span class="text-gray-400 font-semibold text-sm uppercase tracking-wider">User</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span class="text-gray-400 font-semibold text-sm uppercase tracking-wider">Judul Laporan</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span class="text-gray-400 font-semibold text-sm uppercase tracking-wider">Kategori</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span class="text-gray-400 font-semibold text-sm uppercase tracking-wider">Tanggal</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span class="text-gray-400 font-semibold text-sm uppercase tracking-wider">Status</span>
                                </th>
                                <th class="py-4 px-6 text-center">
                                    <span class="text-gray-400 font-semibold text-sm uppercase tracking-wider">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/60">
                            @foreach($reports as $report)
                                <tr class="hover:bg-gray-700/30 transition-colors duration-200 group">
                                    {{-- User --}}
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-white font-semibold text-sm">
                                                    {{ substr($report->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-white">{{ $report->user->name }}</p>
                                                <p class="text-gray-400 text-sm">{{ $report->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Judul --}}
                                    <td class="py-4 px-6">
                                        <p class="font-medium text-white group-hover:text-blue-400 transition-colors duration-200 line-clamp-2">
                                            {{ $report->title }}
                                        </p>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-700 text-gray-300 capitalize">
                                            <i class="fas fa-tag text-xs mr-1 opacity-60"></i>
                                            {{ str_replace('_', ' ', $report->category) }}
                                        </span>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="py-4 px-6">
                                        <div class="text-sm">
                                            <p class="text-white font-medium">{{ $report->created_at->format('d M Y') }}</p>
                                            <p class="text-gray-400">{{ $report->created_at->format('H:i') }}</p>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-4 px-6">
                                        @php
                                            $statusConfig = [
                                                'pending' => [
                                                    'class' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
                                                    'icon' => 'fas fa-clock',
                                                    'text' => 'Menunggu'
                                                ],
                                                'approved' => [
                                                    'class' => 'bg-green-500/20 text-green-300 border-green-500/30',
                                                    'icon' => 'fas fa-check-circle',
                                                    'text' => 'Disetujui'
                                                ],
                                                'rejected' => [
                                                    'class' => 'bg-red-500/20 text-red-300 border-red-500/30',
                                                    'text' => 'Ditolak',
                                                    'icon' => 'fas fa-times-circle'
                                                ]
                                            ];
                                            $status = $report->status ?? 'pending';
                                            $config = $statusConfig[$status] ?? $statusConfig['pending'];
                                        @endphp
                                        
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium border {{ $config['class'] }}">
                                            <i class="{{ $config['icon'] }} text-xs mr-2"></i>
                                            {{ $config['text'] }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <a 
                                                href="{{ route('admin.reports.show', $report->id) }}" 
                                                class="text-gray-400 hover:text-blue-400 p-2 rounded-lg transition-all duration-200 hover:bg-blue-400/10 group/btn"
                                                title="Lihat Detail"
                                            >
                                                <i class="fas fa-eye group-hover/btn:scale-110 transition-transform duration-200"></i>
                                            </a>
                                            
                                            {{-- Quick Actions --}}
                                            @if($report->status === 'pending')
                                                <button 
                                                    wire:click="approveReport({{ $report->id }})"
                                                    class="text-gray-400 hover:text-green-400 p-2 rounded-lg transition-all duration-200 hover:bg-green-400/10 group/btn"
                                                    title="Setujui Laporan"
                                                >
                                                    <i class="fas fa-check group-hover/btn:scale-110 transition-transform duration-200"></i>
                                                </button>
                                                
                                                <button 
                                                    wire:click="rejectReport({{ $report->id }})"
                                                    class="text-gray-400 hover:text-red-400 p-2 rounded-lg transition-all duration-200 hover:bg-red-400/10 group/btn"
                                                    title="Tolak Laporan"
                                                >
                                                    <i class="fas fa-times group-hover/btn:scale-110 transition-transform duration-200"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($reports->hasPages())
                    <div class="px-6 py-4 border-t border-gray-700">
                        {{ $reports->links() }}
                    </div>
                @endif

            @else
                {{-- Empty State --}}
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-alt text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-300 mb-2">Tidak ada laporan</h3>
                        <p class="text-gray-500 mb-6">
                            @if($search || $statusFilter || $categoryFilter)
                                Tidak ada laporan yang sesuai dengan filter yang dipilih
                            @else
                                Belum ada laporan yang dibuat oleh pengguna
                            @endif
                        </p>
                        @if($search || $statusFilter || $categoryFilter)
                            <button 
                                wire:click="$set(['search' => '', 'statusFilter' => '', 'categoryFilter' => ''])"
                                class="inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-lg text-white font-semibold transition-all duration-200"
                            >
                                <i class="fas fa-times"></i>
                                Reset Filter
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Stats Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $totalReports ?? 0 }}</p>
                        <p class="text-gray-400 text-sm">Total Laporan</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $pendingReports ?? 0 }}</p>
                        <p class="text-gray-400 text-sm">Menunggu</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $approvedReports ?? 0 }}</p>
                        <p class="text-gray-400 text-sm">Disetujui</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $rejectedReports ?? 0 }}</p>
                        <p class="text-gray-400 text-sm">Ditolak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush