<div class="bg-gray-800 p-4 rounded-xl border border-gray-700 shadow-lg max-w-md mx-auto">
    <form wire:submit.prevent="addColumn" class="flex items-center gap-3">
        <input
            type="text"
            wire:model="name"
            placeholder="Nama Kolom"
            class="flex-1 px-3 py-2 text-sm rounded-lg bg-gray-900 border border-gray-700 text-gray-100
                   focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500"
        >

        <button
            type="submit"
            class="shrink-0 bg-blue-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-blue-500 transition-all duration-200">
            Tambah
        </button>
    </form>

    @error('name')
        <p class="text-red-400 text-sm mt-2 text-center">{{ $message }}</p>
    @enderror
</div>
