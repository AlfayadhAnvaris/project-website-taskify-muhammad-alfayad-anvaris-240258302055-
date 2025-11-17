<div class="main-content flex-1 p-4 md:p-6 min-h-screen text-white bg-gray-900">
    <x-toast />

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-bold">Dashboard</h1>

    </div>

    <!-- Board Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl p-4 flex items-center gap-3">
            <i class="fas fa-tasks text-blue-400 text-xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Total Task</p>
                <p class="text-white text-2xl font-bold">{{ $totalTasks }}</p>
            </div>
        </div>
        <div class="bg-blue-500/20 backdrop-blur-sm border border-gray-700 rounded-xl p-4 flex items-center gap-3">
            <i class="fas fa-star text-blue-400 text-xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Primary</p>
                <p class="text-white text-2xl font-bold">{{ $primaryTasks ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-yellow-500/20 backdrop-blur-sm border border-gray-700 rounded-xl p-4 flex items-center gap-3">
            <i class="fas fa-exclamation text-yellow-400 text-xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Important</p>
                <p class="text-white text-2xl font-bold">{{ $importantTasks ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-gray-500/20 backdrop-blur-sm border border-gray-700 rounded-xl p-4 flex items-center gap-3">
            <i class="fas fa-circle text-gray-400 text-xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Secondary</p>
                <p class="text-white text-2xl font-bold">{{ $secondaryTasks ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="flex gap-4 overflow-x-auto pb-6 kanban-board">
        @foreach($columns as $column)
            <div class="flex-shrink-0 w-72 kanban-column">
                <div class="flex flex-col h-full bg-gray-800/80 backdrop-blur-sm border border-gray-700 rounded-2xl shadow-lg hover:shadow-2xl transition duration-300">

                    <!-- Header -->
                    <div class="border-b border-gray-700 px-4 pt-4 pb-3 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-2.5 h-2.5 rounded-full @if($loop->index % 3 === 0) bg-purple-500 @elseif($loop->index %3 ===1) bg-blue-500 @else bg-green-500 @endif"></div>
                            <h2 class="text-base font-semibold text-white">{{ $column->name }}</h2>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-400 bg-gray-700 px-2 py-0.5 rounded-full">{{ $column->tasks->count() }} Tasks</span>
                            <button wire:click="deleteColumn({{ $column->id }})" class="text-red-500 hover:text-red-400 text-sm px-1 rounded">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Task List -->
                    <div class="px-4 py-3 space-y-3 min-h-[120px] flex-1 task-list" data-column-id="{{ $column->id }}">
                        @forelse($column->tasks->sortBy('position') as $task)
                            @php
                                $priorityColor = match($task->priority ?? 'secondary') {
                                    'primary' => 'bg-blue-500',
                                    'important' => 'bg-yellow-400',
                                    'secondary' => 'bg-gray-500',
                                    default => 'bg-gray-500',
                                };
                            @endphp
                            <div class="task-card bg-gray-900 border border-gray-700 rounded-xl p-3 transition hover:border-gray-600 flex items-center gap-3" data-task-id="{{ $task->id }}">
                                <!-- Drag Handle -->
                                <div class="drag-handle w-6 h-6 flex-shrink-0 flex items-center justify-center text-gray-400 cursor-grab hover:text-gray-200">
                                    <i class="fas fa-grip-vertical text-base"></i>
                                </div>

                                <!-- Priority Indicator -->
                                <div class="flex-shrink-0 w-3 h-3 rounded-full {{ $priorityColor }}"></div>

                                <!-- Task Info -->
                                <p class="font-medium text-gray-100 flex-1">{{ $task->title }}</p>

                                <!-- Actions -->
                                <div class="flex items-center space-x-2">
                                    <button wire:click="$emit('deleteTask', {{ $task->id }})" class="text-red-500 hover:text-red-400" title="Delete Task">
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

                    <!-- Footer: Tambah Task -->
                    <button 
                        wire:click="$dispatchTo('add-task', 'open-add-task-modal', { columnId: {{ $column->id }}, columnName: '{{ $column->name }}' })"
                        class="w-full bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white py-2 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Task
                    </button>

                </div>
            </div>
        @endforeach
    </div>

    <!-- Livewire AddTask Modal -->
    <livewire:add-task :board-id="$board->id" wire:key="add-task-modal" />
</div>

@push('scripts')
<script>
(function(){
    'use strict';
    let sortableInstances = [];

    function initializeSortable() {
        const lists = document.querySelectorAll('.task-list');
        if (!lists.length || typeof Sortable === 'undefined') return;

        lists.forEach(el => {
            const columnId = el.dataset.columnId;
            if (!columnId) return;

            if (el.sortableInstance) el.sortableInstance.destroy();

            el.sortableInstance = Sortable.create(el, {
                group: 'kanban-tasks',
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd(evt) {
                    const taskId = parseInt(evt.item.dataset.taskId);
                    const newColumnId = parseInt(evt.to.dataset.columnId);
                    const newPosition = evt.newIndex;

                    const component = window.Livewire.find(
                        document.querySelector('[wire\\:id]')?.getAttribute('wire:id')
                    );
                    if (component) {
                        component.call('updateTaskPosition', taskId, newColumnId, newPosition)
                            .catch(() => {
                                evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex]);
                            });
                    }
                }
            });
            sortableInstances.push(el.sortableInstance);
        });
    }

    document.addEventListener('DOMContentLoaded', initializeSortable);
    document.addEventListener('livewire:navigated', () => {
        document.querySelectorAll('.task-list').forEach(el => delete el.sortableInstance);
        sortableInstances = [];
        setTimeout(initializeSortable, 150);
    });
})();
</script>
@endpush
