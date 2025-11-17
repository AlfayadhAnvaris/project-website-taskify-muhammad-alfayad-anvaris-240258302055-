<div>
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/60 z-50">
            {{-- Klik di luar modal untuk menutup --}}
            <div wire:click="closeModal" class="absolute inset-0"></div>

            <div class="relative bg-gray-800 rounded-xl p-6 w-full max-w-md shadow-xl border border-gray-700 z-10">
                <h2 class="text-lg font-semibold mb-4 text-white">
                    Tambah Task ke: 
                    <span class="text-blue-400">{{ $selectedColumnName }}</span>
                </h2>

                <form wire:submit.prevent="addTask" class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Judul Task</label>
                        <input type="text" wire:model.defer="newTaskTitle"
                               class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white 
                                      focus:border-blue-500 focus:ring focus:ring-blue-500/30">
                        @error('newTaskTitle')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Deskripsi</label>
                        <textarea wire:model.defer="newTaskDescription"
                                  class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white 
                                         focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                  rows="3"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-3">
                        <button type="button" wire:click="closeModal"
                                class="px-3 py-2 text-gray-300 hover:text-white">Batal</button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
