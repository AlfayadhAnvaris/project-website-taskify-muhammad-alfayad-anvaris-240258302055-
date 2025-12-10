<div class="p-6 text-white">

    <h1 class="text-3xl font-bold mb-4">
        🗂 Board: {{ $board->title }}
    </h1>

    <div class="flex gap-4 overflow-x-auto pb-5">
        @foreach ($board->columns as $column)
            <div class="w-72 flex-shrink-0 bg-gray-800 p-4 rounded-lg border border-gray-700">

                <h2 class="font-semibold mb-3">
                    {{ $column->name }}
                    ({{ $column->tasks->count() }})
                </h2>

                @foreach ($column->tasks as $task)
                    <div class="bg-gray-900 p-3 rounded-lg border border-gray-700 mb-3">
                        <p class="font-semibold">{{ $task->title }}</p>
                        <p class="text-xs text-gray-400">
                            oleh: {{ $task->user->name ?? 'Unknown' }}
                        </p>
                    </div>
                @endforeach

            </div>
        @endforeach
    </div>

    <h2 class="text-xl font-bold mt-6 mb-3">💬 Komentar</h2>

    @livewire('board-comments', ['boardId' => $board->id])
</div>
