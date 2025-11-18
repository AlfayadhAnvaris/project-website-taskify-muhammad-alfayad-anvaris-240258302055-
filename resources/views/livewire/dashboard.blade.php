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

                 
                </div>
            </div>
        @endforeach
    </div>
</div>


