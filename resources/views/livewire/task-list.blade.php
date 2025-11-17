<div class="px-5 py-4 space-y-3 min-h-[140px] flex-1 task-list" data-column-id="{{ $column->id }}"
    id="column-{{ $column->id }}">

    @forelse ($column->tasks->sortBy('position') as $task)
        @php
            $statusColor =
                $task->status === 'done' ? 'bg-green-400' :
                ($task->status === 'in_progress' ? 'bg-yellow-400' :
                'bg-gray-400');
        @endphp

        <div class="task-card bg-gray-900 border border-gray-700 rounded-xl p-4 transition hover:border-gray-600 flex items-center gap-3 relative"
            data-task-id="{{ $task->id }}">

            {{-- Status Indicator: dot di kiri --}}
            <div class="w-4 h-4 rounded-full {{ $statusColor }} border-2 border-gray-800 flex-shrink-0" title="{{ ucfirst(str_replace('_', ' ', $task->status)) }}"></div>

            {{-- Task Title --}}
            <p class="font-medium text-gray-100 leading-snug flex-1">{{ $task->title }}</p>

            {{-- Actions --}}
            <div class="flex items-center space-x-2">
                @if ($task->status !== 'done')
                    <button wire:click="markAsDone({{ $task->id }})" class="text-green-400 hover:text-green-300"
                        title="Tandai selesai">
                        <i class="fas fa-check"></i>
                    </button>
                @endif
                <button wire:click="deleteTask({{ $task->id }})" class="text-red-500 hover:text-red-400"
                    title="Hapus Task">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    @empty
        <div class="text-gray-500 text-sm text-center py-8">
            <i class="fas fa-inbox text-2xl mb-2 block"></i>
            <p>Belum ada task</p>
        </div>
    @endforelse
</div>
