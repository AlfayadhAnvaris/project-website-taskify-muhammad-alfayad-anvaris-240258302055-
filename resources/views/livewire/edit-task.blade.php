<div>
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-gray-800 rounded-xl p-6 w-96 shadow-lg">
                <h2 class="text-xl font-semibold text-gray-100 mb-4">Edit Task</h2>

                <form wire:submit.prevent="updateTask" class="space-y-3">
                    <input type="text" wire:model="title" placeholder="Judul"
                        class="w-full p-2 bg-gray-900 border border-gray-700 rounded text-white">
                    <textarea wire:model="description" placeholder="Deskripsi"
                        class="w-full p-2 bg-gray-900 border border-gray-700 rounded text-white"></textarea>

                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" wire:click="closeModal"
                            class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-500">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
