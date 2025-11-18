<div class="main-content flex-1 p-4 md:p-6 min-h-screen text-white bg-gray-900">
    <x-toast />

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('user.boards.index') }}" 
                class="text-gray-400 hover:text-white transition-colors duration-200 p-2 rounded-lg hover:bg-gray-800"
                title="Back to Boards"
            >
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $board->name }}</h1>
                <p class="text-gray-400 text-sm mt-1">{{ $columns->count() }} columns • {{ $totalTasks ?? 0 }} tasks</p>
            </div>
        </div>

        {{-- Add Column Form --}}
        <div class="w-full md:w-auto">
            <livewire:add-column :boardId="$board->id" />
        </div>
    </div>

    {{-- Kanban Board --}}
    <div class="flex gap-4 pb-6 kanban-board overflow-x-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-800" 
         id="kanban-board">
        @foreach ($columns as $column)
            <div class="flex-shrink-0 w-80 kanban-column group">
                <div class="flex flex-col h-full bg-gray-800 border border-gray-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:border-gray-600">
                    
                    {{-- Column Header --}}
                    <div class="border-b border-gray-700 px-4 py-4 flex justify-between items-center bg-gray-800/50 rounded-t-xl">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-3 h-3 rounded-full flex-shrink-0
                                @switch($loop->index % 4)
                                    @case(0) bg-blue-500 @break
                                    @case(1) bg-purple-500 @break
                                    @case(2) bg-green-500 @break
                                    @case(3) bg-orange-500 @break
                                @endswitch">
                            </div>
                            <h2 class="text-lg font-semibold text-white truncate" title="{{ $column->name }}">
                                {{ $column->name }}
                            </h2>
                        </div>

                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="text-xs font-medium text-gray-300 bg-gray-700 px-2 py-1 rounded-full min-w-[2rem] text-center">
                                {{ $column->tasks->count() }}
                            </span>
                            <button 
                                wire:click="deleteColumn({{ $column->id }})"
                                wire:confirm="Are you sure you want to delete this column and all its tasks?"
                                class="text-gray-400 hover:text-red-400 p-1.5 rounded-lg transition-all duration-200 hover:bg-red-400/10"
                                title="Delete column"
                            >
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Task List --}}
                    <div class="px-3 py-3 space-y-3 flex-1 overflow-y-auto max-h-[calc(100vh-16rem)] task-list scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-800"
                         data-column-id="{{ $column->id }}" 
                         id="column-{{ $column->id }}">

                        @forelse ($column->tasks->sortBy('position') as $task)
                            @php
                                $priorityColors = [
                                    'primary' => 'bg-blue-500',
                                    'important' => 'bg-red-500',
                                    'secondary' => 'bg-gray-500',
                                    'optional' => 'bg-yellow-500',
                                ];
                                $priorityColor = $priorityColors[$task->priority] ?? 'bg-gray-500';
                            @endphp

                            {{-- Task Card --}}
                            <div class="task-card group bg-gray-900 border border-gray-700 rounded-lg p-4 transition-all duration-200 hover:border-gray-600 hover:shadow-lg hover:translate-y-[-2px] relative sortable-item"
                                 data-task-id="{{ $task->id }}">

                                {{-- Priority Badge & Drag Handle --}}
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $priorityColor }}"></span>
                                        <select 
                                            wire:change="updateTaskPriority({{ $task->id }}, $event.target.value)"
                                            class="bg-gray-800 text-white text-xs rounded-md px-2 py-1 border border-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition-colors duration-200"
                                        >
                                            <option value="primary" @selected($task->priority == 'primary')>Primary</option>
                                            <option value="important" @selected($task->priority == 'important')>Important</option>
                                            <option value="secondary" @selected($task->priority == 'secondary')>Secondary</option>
                                            <option value="optional" @selected($task->priority == 'optional')>Optional</option>
                                        </select>
                                    </div>

                                    {{-- Drag Handle --}}
                                    <div class="drag-handle text-gray-500 hover:text-gray-300 cursor-move transition-colors duration-200 p-1"
                                         title="Drag to move">
                                        <i class="fas fa-grip-vertical"></i>
                                    </div>
                                </div>

                                {{-- Task Content --}}
                                <div class="space-y-2">
                                    {{-- Task Title / Inline Edit --}}
                                    <div class="min-h-[2rem]">
                                        @if (isset($editingTaskId) && $editingTaskId === $task->id)
                                            <input 
                                                type="text" 
                                                wire:model.defer="editingTaskTitle"
                                                wire:keydown.enter="saveTaskTitle({{ $task->id }})"
                                                wire:blur="saveTaskTitle({{ $task->id }})"
                                                class="w-full bg-gray-800 border border-gray-600 rounded-md px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                autofocus 
                                            />
                                        @else
                                            <p class="font-medium text-gray-100 leading-relaxed cursor-pointer hover:text-blue-400 transition-colors duration-200 line-clamp-3"
                                               wire:click="startEditingTask({{ $task->id }})"
                                               title="Click to edit">
                                                {{ $task->title }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Task Metadata --}}
                                    @if($task->description || $task->due_date)
                                        <div class="flex items-center gap-3 text-xs text-gray-400">
                                            @if($task->description)
                                                <span class="flex items-center gap-1">
                                                    <i class="fas fa-file-alt"></i>
                                                    <span>{{ $task->description }}</span>
                                                </span>
                                            @endif
                                            @if($task->due_date)
                                                <span class="flex items-center gap-1 {{ $task->due_date->isPast() ? 'text-red-400' : '' }}">
                                                    <i class="fas fa-clock"></i>
                                                    <span>{{ $task->due_date->format('M j') }}</span>
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-700">
                                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button
                                            wire:click="$dispatchTo('edit-task', 'open-edit-task-modal', { taskId: {{ $task->id }} })"
                                            class="text-gray-400 hover:text-blue-400 p-1.5 rounded transition-colors duration-200 hover:bg-blue-400/10"
                                            title="Edit Task"
                                        >
                                            <i class="fas fa-pen text-sm"></i>
                                        </button>

                                        <button 
                                            wire:click="deleteTask({{ $task->id }})"
                                            wire:confirm="Are you sure you want to delete this task?"
                                            class="text-gray-400 hover:text-red-400 p-1.5 rounded transition-colors duration-200 hover:bg-red-400/10"
                                            title="Delete Task"
                                        >
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- Empty State --}}
                            <div class="text-center py-8 text-gray-500">
                                <div class="w-12 h-12 mx-auto mb-3 bg-gray-800 rounded-full flex items-center justify-center">
                                    <i class="fas fa-inbox text-xl"></i>
                                </div>
                                <p class="text-sm font-medium">No tasks yet</p>
                                <p class="text-xs mt-1">Add your first task below</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Add Task Button --}}
                    <div class="p-3 border-t border-gray-700">
                        <button
                            wire:click="$dispatchTo('add-task', 'open-add-task-modal', { columnId: {{ $column->id }}, columnName: '{{ $column->name }}' })"
                            class="w-full bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium hover:shadow-lg"
                        >
                            <i class="fas fa-plus"></i>
                            Add Task
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modals --}}
    <livewire:edit-task wire:key="edit-task-modal" />
    <livewire:add-task :board-id="$board->id" wire:key="add-task-modal" />
</div>

@push('styles')
<style>
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .scrollbar-thumb-gray-700::-webkit-scrollbar-thumb {
        background-color: #374151;
        border-radius: 10px;
    }
    
    .scrollbar-track-gray-800::-webkit-scrollbar-track {
        background-color: #1f2937;
        border-radius: 10px;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Sortable.js Styles */
    .sortable-ghost {
        opacity: 0.4;
        background: rgba(59, 130, 246, 0.1);
        border: 2px dashed #3b82f6;
    }
    
    .sortable-chosen {
        transform: rotate(2deg);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    
    .sortable-drag {
        opacity: 0.8;
        transform: rotate(5deg);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeKanbanDragDrop();
});

document.addEventListener('livewire:load', function() {
    initializeKanbanDragDrop();
});

document.addEventListener('livewire:update', function() {
    setTimeout(initializeKanbanDragDrop, 100);
});

function initializeKanbanDragDrop() {
    if (window.kanbanSortables) {
        window.kanbanSortables.forEach(instance => {
            if (instance && typeof instance.destroy === 'function') {
                instance.destroy();
            }
        });
    }
    
    window.kanbanSortables = [];
    
    const taskLists = document.querySelectorAll('.task-list');
    
    if (taskLists.length === 0 || typeof Sortable === 'undefined') {
        return;
    }

    taskLists.forEach((list) => {
        const columnId = list.getAttribute('data-column-id');
        
        if (!columnId) return;

        const sortable = Sortable.create(list, {
            group: {
                name: 'kanban-tasks',
                pull: true,
                put: true
            },
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            forceFallback: false,
            fallbackOnBody: true,
            
            onStart: function(evt) {
                evt.item.style.opacity = '0.8';
                evt.item.style.cursor = 'grabbing';
            },
            
            onEnd: function(evt) {
                evt.item.style.opacity = '1';
                evt.item.style.cursor = '';
                
                const taskId = evt.item.getAttribute('data-task-id');
                const fromColumnId = evt.from.getAttribute('data-column-id');
                const toColumnId = evt.to.getAttribute('data-column-id');
                const newPosition = evt.newIndex;
                
                if (!taskId || !fromColumnId || !toColumnId) {
                    return;
                }

                const livewireComponent = getLivewireComponent();
                
                if (livewireComponent) {
                    livewireComponent.call('updateTaskPosition', 
                        parseInt(taskId), 
                        parseInt(toColumnId), 
                        parseInt(newPosition)
                    ).catch(error => {
                        console.error('Error updating task position:', error);
                    });
                }
            }
        });
        
        window.kanbanSortables.push(sortable);
    });
}

function getLivewireComponent() {
    const wireElement = document.querySelector('[wire\\:id]');
    if (wireElement) {
        const wireId = wireElement.getAttribute('wire:id');
        return window.Livewire.find(wireId);
    }
    
    const livewireComponents = Object.values(window.Livewire.components.componentsById);
    if (livewireComponents.length > 0) {
        return livewireComponents[0];
    }
    
    return null;
}

document.addEventListener('livewire:navigated', function() {
    setTimeout(initializeKanbanDragDrop, 200);
});
</script>
@endpush