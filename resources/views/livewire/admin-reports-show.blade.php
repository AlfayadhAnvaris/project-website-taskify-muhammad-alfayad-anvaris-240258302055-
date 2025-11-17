<div class="main-content flex-1 p-4 md:p-6 min-h-screen text-white bg-gray-900">
    <x-toast />
    
    <div class="max-w-4xl mx-auto">
        {{-- Header Section --}}
        <div class="flex items-center gap-3 mb-8">
            <a 
                href="{{ route('admin.reports.index') }}" 
                class="text-gray-400 hover:text-white transition-colors duration-200 p-2 rounded-lg hover:bg-gray-800 flex items-center justify-center"
                title="Kembali ke Daftar Laporan"
            >
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">Detail Laporan</h1>
                <p class="text-gray-400 mt-1">Review dan kelola laporan dari pengguna</p>
            </div>
        </div>

        {{-- Report Details Card --}}
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700 overflow-hidden mb-6">
            {{-- Header --}}
            <div class="border-b border-gray-700 p-6 bg-gray-800/80">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-file-alt text-white text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">{{ $report->title }}</h2>
                                <div class="flex flex-wrap items-center gap-2 mt-2">
                                    @php
                                        $statusConfig = [
                                            'pending' => [
                                                'class' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
                                                'icon' => 'fas fa-clock',
                                                'text' => 'Menunggu Review'
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
                                    
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-700 text-gray-300 border border-gray-600">
                                        <i class="fas fa-tag text-xs mr-2 opacity-60"></i>
                                        {{ str_replace('_', ' ', $report->category) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Quick Actions --}}
                    <div class="flex flex-wrap gap-2">
                        @if($report->status === 'pending')
                            <button 
                                wire:click="approveReport"
                                class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2"
                            >
                                <i class="fas fa-check"></i>
                                Setujui
                            </button>
                            <button 
                                wire:click="rejectReport"
                                class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2"
                            >
                                <i class="fas fa-times"></i>
                                Tolak
                            </button>
                        @endif
                        
                        {{-- Export/Print Button --}}
                        <button 
                            onclick="window.print()"
                            class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2"
                        >
                            <i class="fas fa-print"></i>
                            Print
                        </button>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 space-y-6">
                {{-- User Information --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-700/30 rounded-lg p-4 border border-gray-600">
                        <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                            <i class="fas fa-user text-blue-400"></i>
                            Informasi Pengguna
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        {{ substr($report->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-white">{{ $report->user->name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $report->user->email }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-400">
                                <p><span class="font-medium">ID User:</span> {{ $report->user->id }}</p>
                                <p><span class="font-medium">Bergabung:</span> {{ $report->user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-700/30 rounded-lg p-4 border border-gray-600">
                        <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                            <i class="fas fa-calendar text-green-400"></i>
                            Informasi Laporan
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Dibuat:</span>
                                <span class="text-white font-medium">{{ $report->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Diupdate:</span>
                                <span class="text-white font-medium">{{ $report->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Kategori:</span>
                                <span class="text-white font-medium capitalize">{{ str_replace('_', ' ', $report->category) }}</span>
                            </div>
                            @if($report->attachment)
                            <div class="flex justify-between">
                                <span class="   text-gray-400">Lampiran:</span>
                                <span class="text-green-400 font-medium">Tersedia</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Report Content --}}
                <div class="bg-gray-700/30 rounded-lg p-4 border border-gray-600">
                    <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-align-left text-yellow-400"></i>
                        Deskripsi Laporan
                    </h3>
                    <div class="prose prose-invert max-w-none">
                        <p class="text-gray-100 leading-relaxed whitespace-pre-line">{{ $report->content }}</p>
                    </div>
                </div>

                {{-- Attachment --}}
                @if($report->attachment)
                <div class="bg-gray-700/30 rounded-lg p-4 border border-gray-600">
                    <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-paperclip text-orange-400"></i>
                        Lampiran
                    </h3>
                    <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg">
                        <div class="flex items-center gap-3">
                            @if(str_contains($report->attachment, ['.jpg', '.jpeg', '.png', '.gif']))
                                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-white"></i>
                                </div>
                            @elseif(str_contains($report->attachment, '.pdf'))
                                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-pdf text-white"></i>
                                </div>
                            @elseif(str_contains($report->attachment, ['.doc', '.docx']))
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-word text-white"></i>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file text-white"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-white">{{ basename($report->attachment) }}</p>
                                <p class="text-gray-400 text-sm">
                                    @if(file_exists(storage_path('app/public/' . $report->attachment)))
                                        {{ round(filesize(storage_path('app/public/' . $report->attachment)) / 1024, 2) }} KB
                                    @else
                                        File tidak ditemukan
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a 
                            href="{{ asset('storage/' . $report->attachment) }}" 
                            target="_blank"
                            class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2"
                        >
                            <i class="fas fa-download"></i>
                            Download
                        </a>
                    </div>
                </div>
                @endif

                {{-- Admin Actions --}}
                @if($report->status === 'pending' || $report->admin_note)
                <div class="bg-gray-700/30 rounded-lg p-4 border border-gray-600">
                    <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-user-shield text-purple-400"></i>
                        Tindakan Admin
                    </h3>
                    
                    @if($report->status === 'pending')
                        {{-- Admin Note Form --}}
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-300 mb-2">Catatan Admin (Opsional)</label>
                                <textarea 
                                    wire:model="adminNote"
                                    rows="4"
                                    placeholder="Berikan catatan atau feedback untuk laporan ini..."
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                ></textarea>
                                @error('adminNote')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex flex-wrap gap-3">
                                <button 
                                    wire:click="approveReport"
                                    class="bg-green-600 hover:bg-green-500 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center gap-2"
                                >
                                    <i class="fas fa-check"></i>
                                    Setujui Laporan
                                </button>
                                <button 
                                    wire:click="rejectReport"
                                    class="bg-red-600 hover:bg-red-500 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center gap-2"
                                >
                                    <i class="fas fa-times"></i>
                                    Tolak Laporan
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Existing Admin Note --}}
                    @if($report->admin_note)
                        <div class="mt-4 p-4 bg-gray-800 rounded-lg border border-gray-600">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-sticky-note text-blue-400"></i>
                                <p class="text-blue-400 font-semibold">Catatan Admin:</p>
                            </div>
                            <p class="text-gray-200 leading-relaxed whitespace-pre-line">{{ $report->admin_note }}</p>
                            <p class="text-gray-400 text-xs mt-2">
                                Diupdate: {{ $report->updated_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endif
                </div>
                @endif

                {{-- Report History --}}
                <div class="bg-gray-700/30 rounded-lg p-4 border border-gray-600">
                    <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-history text-gray-400"></i>
                        Riwayat Status
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-plus text-white text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white">Laporan dibuat</p>
                                <p class="text-gray-400">{{ $report->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($report->status !== 'pending')
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 {{ $report->status === 'approved' ? 'bg-green-500' : 'bg-red-500' }} rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $report->status === 'approved' ? 'fa-check' : 'fa-times' }} text-white text-xs"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-white">
                                        Laporan {{ $report->status === 'approved' ? 'disetujui' : 'ditolak' }}
                                        @if($report->admin_note)
                                            dengan catatan
                                        @endif
                                    </p>
                                    <p class="text-gray-400">{{ $report->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-between">
            <a 
                href="{{ route('admin.reports.index') }}" 
                class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center justify-center gap-2"
            >
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar Laporan
            </a>
            
            <div class="flex gap-3">
                @if($report->id > 1)
                    <a 
                        href="{{ route('admin.reports.show', $report->id - 1) }}" 
                        class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center gap-2"
                    >
                        <i class="fas fa-chevron-left"></i>
                        Sebelumnya
                    </a>
                @endif
                
                @if($report->id < $totalReports)
                    <a 
                        href="{{ route('admin.reports.show', $report->id + 1) }}" 
                        class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center gap-2"
                    >
                        Selanjutnya
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

  
</div>

@push('scripts')
<script>
// Confirmation for actions
function confirmAction(action, reportId) {
    if (confirm(`Apakah Anda yakin ingin ${action} laporan ini?`)) {
        Livewire.dispatch(`${action}-report`, { reportId: reportId });
    }
}

// Print styles
@media print {
    .main-content {
        background: white !important;
        color: black !important;
    }
    
    .bg-gray-900 { background: white !important; }
    .text-white { color: black !important; }
    .bg-gray-800 { background: #f8f9fa !important; }
    .border-gray-700 { border-color: #dee2e6 !important; }
    
    .no-print {
        display: none !important;
    }
}
</script>
@endpush