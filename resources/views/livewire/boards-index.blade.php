{{-- Main Content --}}
<div class="main-content flex-1 p-6 ml-64 min-h-screen bg-gray-900 text-white pt-20">
    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">My Boards</h1>
                <p class="text-gray-400">Manage and organize your project boards</p>
            </div>

            {{-- Create Board Form --}}
            <form wire:submit.prevent="createBoard" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:flex-none">
                    <input 
                        type="text" 
                        wire:model="newBoardName" 
                        placeholder="Enter board name..."
                        class="w-full sm:w-64 px-4 py-3 rounded-lg bg-gray-800 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500 text-white transition-all duration-200"
                    >
                    @error('newBoardName')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button 
                    type="submit" 
                    class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 rounded-lg font-semibold hover:from-blue-500 hover:to-blue-600 transition-all duration-200 shadow-lg hover:shadow-blue-500/25 flex items-center justify-center gap-2"
                    {{-- Disable button jika input kosong --}}
                    {{ empty(trim($newBoardName)) ? 'disabled' : '' }}
                >
                    <i class="fas fa-plus"></i>
                    Create Board
                </button>
            </form>
        </div>

        {{-- Board List --}}
        @if($boards->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($boards as $board)
                    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg hover:shadow-xl hover:border-gray-600 hover:transform hover:-translate-y-1 transition-all duration-300 group">
                        {{-- Board Header --}}
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-xl font-semibold text-white group-hover:text-blue-400 transition-colors duration-200 line-clamp-2">
                                {{ $board->name }}
                            </h2>
                            <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button 
                                    wire:click="deleteBoard({{ $board->id }})"
                                    wire:confirm="Are you sure you want to delete this board?"
                                    class="text-gray-400 hover:text-red-400 p-1 rounded transition-colors duration-200"
                                    title="Delete board"
                                >
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Board Metadata --}}
                        <div class="flex items-center text-gray-400 text-sm mb-4">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar text-xs"></i>

                            </span>
                            {{-- Tambahkan info lain seperti jumlah tasks jika ada --}}
                            {{-- <span class="mx-2">•</span>
                            <span>5 tasks</span> --}}
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex justify-between items-center pt-4 border-t border-gray-700">
                            <a 
                                href="{{ route('user.board.view', ['boardId' => $board->id]) }}"
                                class="text-blue-400 hover:text-blue-300 font-medium text-sm flex items-center gap-2 group-hover:gap-3 transition-all duration-200"
                            >
                                Open Board
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-200"></i>
                            </a>
                            
                            {{-- Additional actions bisa ditambahkan di sini --}}
                            <button class="text-gray-400 hover:text-gray-300 transition-colors duration-200">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
                        <i class="fas fa-tasks text-3xl text-gray-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-300 mb-3">No boards yet</h3>
                    <p class="text-gray-500 mb-6">Create your first board to start organizing your projects</p>
                    <button 
                        onclick="document.querySelector('input[wire\\:model=\"newBoardName\"]').focus()"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 rounded-lg font-semibold hover:from-blue-500 hover:to-blue-600 transition-all duration-200 shadow-lg hover:shadow-blue-500/25 inline-flex items-center gap-2"
                    >
                        <i class="fas fa-plus"></i>
                        Create Your First Board
                    </button>
                </div>
            </div>
        @endif

     
    </div>
</div>