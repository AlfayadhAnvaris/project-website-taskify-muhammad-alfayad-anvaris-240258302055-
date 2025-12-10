<div class="space-y-4">

    <!-- Form -->
    <div class="bg-gray-800 border border-gray-700 p-4 rounded-xl">
        <h3 class="text-lg font-semibold mb-3">💬 Tambah Komentar</h3>

        @if(session()->has('error'))
            <p class="text-red-400 mb-2">{{ session('error') }}</p>
        @endif

        @if(session()->has('success'))
            <p class="text-green-400 mb-2">{{ session('success') }}</p>
        @endif

        <textarea wire:model="message"
            class="w-full p-3 bg-gray-900 border border-gray-700 rounded-xl text-white"
            rows="3"
            placeholder="Tulis komentar untuk team..."></textarea>

        <button wire:click="postComment"
            class="mt-3 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
            Kirim
        </button>
    </div>

    <!-- List Comments -->
    <div class="bg-gray-800 border border-gray-700 p-4 rounded-xl">
        <h3 class="text-lg font-semibold mb-3">Komentar</h3>

        <div class="space-y-4">
            @forelse($comments as $comment)
            <div class="bg-gray-900 border border-gray-700 p-3 rounded-xl">
                <div class="flex justify-between">
                    <p class="font-semibold">{{ $comment->user->name }}</p>
                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-300 mt-1">{{ $comment->message }}</p>
            </div>
            @empty
                <p class="text-gray-500 text-sm italic">Belum ada komentar</p>
            @endforelse
        </div>
    </div>

</div>
