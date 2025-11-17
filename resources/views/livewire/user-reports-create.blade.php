<div class="main-content flex-1 p-4 md:p-6 min-h-screen text-white bg-gray-900">
    <x-toast />

    <div class="max-w-3xl mx-auto">
        {{-- Header Section --}}
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('user.reports.index') }}"
                class="text-gray-400 hover:text-white transition-colors duration-200 p-2 rounded-lg hover:bg-gray-800 flex items-center justify-center"
                title="Kembali ke Laporan">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">Buat Laporan Baru</h1>
                <p class="text-gray-400 mt-1">Isi form di bawah untuk membuat laporan project baru</p>
            </div>
        </div>

        {{-- Form Container --}}
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700 p-6 md:p-8">
            <form wire:submit.prevent="store" class="space-y-6">

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-3 flex items-center gap-2">
                        <div class="w-6 h-6 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heading text-white text-xs"></i>
                        </div>
                        Judul Laporan
                    </label>
                    <input type="text" wire:model.defer="title"
                        placeholder="Masukkan judul laporan yang jelas dan deskriptif"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    @error('title')
                        <p class="text-red-400 text-sm mt-2 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-3 flex items-center gap-2">
                        <div class="w-6 h-6 bg-purple-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tag text-white text-xs"></i>
                        </div>
                        Kategori Laporan
                    </label>
                    <select wire:model.defer="category"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">Pilih Kategori</option>
                        <option value="progress">Laporan Progress</option>
                        <option value="kritik_saran">Kritik & Saran</option>
                        <option value="masalah">Laporan Masalah</option>
                        <option value="lainnya">Lainnya</option>

                    </select>
                    @error('category')
                        <p class="text-red-400 text-sm mt-2 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-3 flex items-center gap-2">
                        <div class="w-6 h-6 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-align-left text-white text-xs"></i>
                        </div>
                        Deskripsi Lengkap
                    </label>
                    <textarea wire:model.defer="content" rows="6"
                        placeholder="Jelaskan detail laporan Anda. Sertakan informasi yang relevan seperti progress, masalah yang dihadapi, atau permintaan spesifik."
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"></textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-2 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Attachment --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-3 flex items-center gap-2">
                        <div class="w-6 h-6 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-paperclip text-white text-xs"></i>
                        </div>
                        Lampiran (Opsional)
                    </label>

                    {{-- File Upload Area --}}
                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center transition-all duration-200 hover:border-blue-500 hover:bg-blue-500/5 cursor-pointer"
                        x-data="{ isDragging: false }" x-on:drop="isDragging = false" x-on:dragover.prevent="isDragging = true"
                        x-on:dragleave.prevent="isDragging = false"
                        :class="isDragging ? 'border-blue-500 bg-blue-500/10' : ''">
                        <input type="file" wire:model="attachment" id="attachment" class="hidden">

                        <label for="attachment" class="cursor-pointer">
                            @if (!$attachment)
                                <div class="space-y-3">
                                    <div
                                        class="w-12 h-12 mx-auto bg-gray-700 rounded-full flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-300 font-medium">Klik untuk upload atau drag & drop</p>
                                        <p class="text-gray-500 text-sm mt-1">PNG, JPG, PDF, DOCX (Max: 5MB)</p>
                                    </div>
                                </div>
                            @else
                                <div class="space-y-3">
                                    <div
                                        class="w-12 h-12 mx-auto bg-green-500/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-green-400 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-green-400 font-medium">File siap diupload</p>
                                        <p class="text-gray-400 text-sm mt-1">{{ $attachment->getClientOriginalName() }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </label>
                    </div>

                    {{-- File Preview --}}
                    @if ($attachment)
                        <div class="mt-4 p-4 bg-gray-700/50 rounded-lg border border-gray-600">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if (str_contains($attachment->getMimeType(), 'image'))
                                        <img src="{{ $attachment->temporaryUrl() }}"
                                            class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-white font-medium">{{ $attachment->getClientOriginalName() }}</p>
                                        <p class="text-gray-400 text-sm">{{ round($attachment->getSize() / 1024, 2) }}
                                            KB</p>
                                    </div>
                                </div>
                                <button type="button" wire:click="$set('attachment', null)"
                                    class="text-red-400 hover:text-red-300 p-2 rounded-lg transition-colors duration-200 hover:bg-red-400/10">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @error('attachment')
                        <p class="text-red-400 text-sm mt-2 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-700">
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-blue-500/25 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-paper-plane"></i>
                        <span wire:loading.remove>Simpan Laporan</span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin"></i>
                            Menyimpan...
                        </span>
                    </button>

                    <a href="{{ route('user.reports.index') }}"
                        class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all duration-200 text-center flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>

                {{-- Success Message --}}
                @if (session()->has('success'))
                    <div class="p-4 bg-green-500/20 border border-green-500/30 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-green-400 font-semibold">Berhasil!</p>
                                <p class="text-green-300 text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>


    </div>
</div>

@push('scripts')
    <script>
        // Drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('attachment');
            const dropArea = fileInput.closest('div[x-data]');

            if (dropArea) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, unhighlight, false);
                });

                function highlight() {
                    dropArea.classList.add('border-blue-500', 'bg-blue-500/10');
                }

                function unhighlight() {
                    dropArea.classList.remove('border-blue-500', 'bg-blue-500/10');
                }

                dropArea.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    fileInput.files = files;
                    fileInput.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                }
            }
        });
    </script>
@endpush
