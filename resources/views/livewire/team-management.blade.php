<div class="space-y-6">
    {{-- Create Team Section --}}
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
            <i class="fas fa-users text-blue-400"></i>
            Buat Team Baru
        </h2>
        <div class="space-y-4">
            <div>
                <input type="text" wire:model.defer="teamName" placeholder="Masukkan nama team..."
                    class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-600 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" />
                @error('teamName')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button wire:click="createTeam"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg text-white font-semibold hover:from-blue-500 hover:to-blue-600 transition-all duration-200 shadow-lg hover:shadow-blue-500/25 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Buat Team
            </button>
        </div>
    </div>

    {{-- Teams List --}}
    <div class="space-y-4">
        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <i class="fas fa-list text-gray-400"></i>
            Team Saya
        </h3>

        <div class="grid gap-3">
            @foreach ($teams as $team)
                <div class="p-4 bg-gray-800 rounded-xl border border-gray-700 hover:border-gray-600 hover:shadow-lg transition-all duration-200 cursor-pointer group flex justify-between items-center"
                    wire:click="selectTeam({{ $team->id }})">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                        <div>
                            <h4
                                class="text-white font-semibold group-hover:text-blue-400 transition-colors duration-200">
                                {{ $team->name }}
                            </h4>
                            <p class="text-gray-400 text-sm">
                                Owner: {{ $team->owner?->name ?? 'No owner' }}
                            </p>
                        </div>
                    </div>
                    <i
                        class="fas fa-chevron-right text-gray-400 group-hover:text-blue-400 group-hover:translate-x-1 transition-all duration-200"></i>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Selected Team Management --}}
    @if ($selectedTeam)
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
            {{-- Team Header --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-cog text-green-400"></i>
                    Kelola {{ $selectedTeam->name }}
                </h3>
                <span
                    class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-medium border border-blue-500/30">
                    {{ $selectedTeam->users->count() }} Anggota
                </span>
            </div>

            {{-- Invite User Section --}}
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-user-plus text-green-400"></i>
                    Invite Member
                </h4>
                <div class="flex gap-3">
                    <div class="flex-1">
                        <input type="email" wire:model.defer="inviteEmail" placeholder="Masukkan email member..."
                            class="w-full px-4 py-3 rounded-lg bg-gray-900 border border-gray-600 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" />
                        @error('inviteEmail')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button wire:click="inviteUser"
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 rounded-lg text-white font-semibold hover:from-green-500 hover:to-green-600 transition-all duration-200 shadow-lg hover:shadow-green-500/25 flex items-center gap-2 whitespace-nowrap">
                        <i class="fas fa-paper-plane"></i>
                        Invite
                    </button>
                </div>
            </div>

            {{-- Team Members --}}
            <div>
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-users text-purple-400"></i>
                    Daftar Anggota
                </h4>

                <div class="space-y-3">
                    @foreach ($selectedTeam->users as $user)
                        <div
                            class="flex items-center justify-between p-4 bg-gray-700 rounded-lg border border-gray-600 hover:border-gray-500 transition-all duration-200">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $user->name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                                </div>
                                @if ($user->id === $selectedTeam->owner_id)
                                    <span class="text-sm text-gray-300">
                                        Owner: {{ $selectedTeam->owner?->name ?? 'No owner' }}
                                    </span>
                                @endif
                            </div>

                            @if (Auth::id() === $selectedTeam->owner_id && $user->id !== $selectedTeam->owner_id)
                                <button wire:click="removeUser({{ $user->id }})"
                                    class="px-3 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-all duration-200 flex items-center gap-2 border border-red-500/30"
                                    title="Remove user from team">
                                    <i class="fas fa-times text-xs"></i>
                                    Remove
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
