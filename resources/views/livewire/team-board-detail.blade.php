<div class="p-6 text-white min-h-screen bg-gray-900">

    {{-- Board Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">
                📌 Board: {{ $board->name }}
            </h1>
            <p class="text-gray-400 text-sm">
                Tim: {{ $board->team->name ?? 'Unknown' }} | Dibuat oleh: {{ $board->user->name ?? 'Unknown' }}
            </p>
        </div>
        <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-medium border border-blue-500/30">
            {{ $board->tasks->count() }} Tasks
        </span>
    </div>

    {{-- Tasks Section --}}
    <div class="bg-gray-800 p-5 rounded-xl border border-gray-700 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-white flex items-center gap-2">
            <i class="fas fa-tasks text-green-400"></i> Tasks
        </h2>

        @forelse ($board->tasks as $task)
            <div class="bg-gray-900 p-4 rounded-lg border border-gray-700 mb-3 flex justify-between items-center hover:border-gray-600 transition">
                <div>
                    <p class="font-semibold text-white">{{ $task->title }}</p>
                    <p class="text-gray-400 text-sm">{{ $task->description }}</p>
                </div>
                <span class="text-gray-400 text-sm">{{ $task->status }}</span>
            </div>
        @empty
            <p class="text-gray-400 italic">Belum ada task untuk board ini.</p>
        @endforelse
    </div>

    {{-- Comments Section --}}
    <div class="bg-gray-800 p-5 rounded-xl border border-gray-700">
        <h2 class="text-xl font-semibold mb-4 text-white flex items-center gap-2">
            <i class="fas fa-comments text-blue-400"></i> Komentar
        </h2>

        {{-- Form Komentar --}}
        @if(session()->has('error'))
            <p class="text-red-400 mb-2">{{ session('error') }}</p>
        @endif
        @if(session()->has('success'))
            <p class="text-green-400 mb-2">{{ session('success') }}</p>
        @endif

        <div class="flex gap-3 mb-4">
            <input type="text" wire:model.defer="message" placeholder="Tulis komentar..."
                class="flex-1 px-4 py-2 rounded-lg bg-gray-900 border border-gray-600 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
            <button wire:click="postComment"
                class="px-4 py-2 bg-blue-600 rounded-lg text-white font-semibold hover:bg-blue-700 transition-all duration-200">
                Kirim
            </button>
        </div>

        {{-- List Komentar --}}
       <div class="space-y-4">
    @foreach ($comments as $comment)
        <div class="p-3 bg-gray-700 rounded-lg flex justify-between items-start">
            <div class="flex-1">
                <p class="text-sm text-gray-300">
                    <span class="font-semibold text-white">{{ $comment->user->name }}</span>:
                </p>

                @if ($editCommentId === $comment->id)
                    <textarea wire:model.defer="editMessage"
                        class="w-full mt-1 p-2 bg-gray-800 border border-gray-600 rounded-lg text-white"></textarea>
                    <div class="flex gap-2 mt-2">
                        <button wire:click="updateComment"
                            class="px-3 py-1 bg-green-600 rounded-lg text-white text-sm">Update</button>
                        <button wire:click="$set('editCommentId', null)"
                            class="px-3 py-1 bg-gray-500 rounded-lg text-white text-sm">Cancel</button>
                    </div>
                @else
                    <p class="text-gray-300 text-sm mt-1">{{ $comment->message }}</p>
                @endif
            </div>

            <div class="flex flex-col gap-1 ml-3">
                @if ($comment->user_id === auth()->id() || $board->team->owner_id === auth()->id())
                    <button wire:click="editComment({{ $comment->id }})"
                        class="text-blue-400 hover:text-blue-300 text-sm">Edit</button>
                    <button wire:click="deleteComment({{ $comment->id }})"
                        class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                @endif
            </div>
        </div>
    @endforeach

    {{-- Form Tambah Komentar --}}
    <div class="mt-4 flex gap-2">
        <input type="text" wire:model.defer="message"
            class="flex-1 px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white"
            placeholder="Tulis komentar...">
        <button wire:click="postComment" class="px-4 py-2 bg-blue-600 rounded-lg text-white">Kirim</button>
    </div>
</div>


</div>
