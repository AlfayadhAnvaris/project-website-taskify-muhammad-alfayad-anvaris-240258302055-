<div>
    <div class="flex mb-4 gap-2">
        <input type="text" placeholder="Cari team..." wire:model.debounce.300ms="search"
               class="px-4 py-2 rounded bg-gray-800 border border-gray-700 text-white w-full">
        <button wire:click="createTeam" class="px-4 py-2 bg-blue-600 rounded text-white">Buat Team</button>
    </div>

    @if(session()->has('success'))
        <div class="mb-4 text-green-400">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-800 p-4 rounded-lg">
        @if($teams->count())
            <ul>
                @foreach($teams as $team)
                    <li class="flex justify-between py-2 border-b border-gray-700">
                        <span>{{ $team->name }}</span>
                        <span class="text-sm text-gray-400">
                            @if($team->pivot->is_admin) Admin @else Member @endif
                        </span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4">
                {{ $teams->links() }}
            </div>
        @else
            <p class="text-gray-400">Belum ada team.</p>
        @endif
    </div>
</div>
