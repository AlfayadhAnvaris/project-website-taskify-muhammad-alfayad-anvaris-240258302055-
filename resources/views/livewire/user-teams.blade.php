<div class="space-y-6">

    <!-- Search & Create Team -->
    <div class="flex flex-col md:flex-row gap-2 md:items-center">
        <input 
            type="text" 
            placeholder="Cari team..." 
            wire:model.debounce.300ms="search"
            class="flex-1 px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
        >
        <button 
            wire:click="createTeam" 
            class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-lg font-semibold shadow-md transition-all duration-200"
        >
            Cari
        </button>
    </div>

    <!-- Success Message -->
    @if(session()->has('success'))
        <div class="px-4 py-2 rounded-lg bg-green-800 text-green-400 font-medium shadow-inner">
            {{ session('success') }}
        </div>
    @endif

    <!-- Teams List -->
    <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-700">
        @if($teams->count())
            <ul class="divide-y divide-gray-700">
                @foreach($teams as $team)
                    <li class="flex justify-between items-center px-4 py-3 hover:bg-gray-700 transition rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($team->name, 0, 1)) }}
                            </div>
                            <span class="text-white font-medium">{{ $team->name }}</span>
                        </div>
                        <span class="text-sm text-gray-400 px-2 py-1 bg-gray-700/50 rounded-lg">
                            @if($team->pivot->is_admin) Admin @else Member @endif
                        </span>
                    </li>
                @endforeach
            </ul>

            <!-- Pagination -->
            <div class="px-4 py-3 bg-gray-800/50 border-t border-gray-700">
                {{ $teams->links() }}
            </div>
        @else
            <div class="p-6 text-center text-gray-400">
                Belum ada team. Buat tim baru untuk memulai kolaborasi!
            </div>
        @endif
    </div>

</div>
