<main class="main-content flex-1 p-6 min-h-screen text-white bg-gray-900">

    <div class="mb-8">
        <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
        <p class="text-gray-400">{{ $user->email }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Profil Info -->
        <div class="bg-gray-800/60 backdrop-blur-sm border border-gray-700 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold mb-4 border-b border-gray-700 pb-2">📋 Info Akun</h2>
            <p><span class="text-gray-400">Nama:</span> {{ $user->name }}</p>
            <p><span class="text-gray-400">Email:</span> {{ $user->email }}</p>
            <p><span class="text-gray-400">Dibuat:</span> {{ $user->created_at->format('d M Y') }}</p>
        </div>

        <!-- Boards -->
        <div class="bg-gray-800/60 backdrop-blur-sm border border-gray-700 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-semibold mb-4 border-b border-gray-700 pb-2">🗂️ Boards</h2>
            @forelse($boards as $board)
                <div class="border border-gray-700 rounded-lg p-3 mb-2 bg-gray-900/40">
                    <p class="font-semibold text-white">{{ $board->name }}</p>
                    <p class="text-sm text-gray-400">Tasks: {{ $board->columns->sum(fn($col) => $col->tasks->count()) }}</p>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Belum ada board.</p>
            @endforelse
        </div>
    </div>

    <!-- Tasks Section -->
    <div class="bg-gray-800/60 backdrop-blur-sm border border-gray-700 rounded-xl p-6 mt-6 shadow-lg">
        <h2 class="text-xl font-semibold mb-4 border-b border-gray-700 pb-2">✅ Semua Tasks</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($tasks as $task)
                <div class="p-4 rounded-xl bg-gray-900/60 border border-gray-700 hover:border-gray-600 transition">
                    <p class="font-medium">{{ $task->title }}</p>
                    <span class="text-xs px-2 py-1 rounded-full mt-2 inline-block 
                        @if($task->priority === 'primary') bg-blue-500/20 text-blue-400
                        @elseif($task->priority === 'important') bg-yellow-500/20 text-yellow-400
                        @else bg-gray-500/20 text-gray-400 @endif">
                        {{ ucfirst($task->priority ?? 'secondary') }}
                    </span>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Belum ada task.</p>
            @endforelse
        </div>
    </div>

</main>
