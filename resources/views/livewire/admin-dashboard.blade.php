<main class="main-content flex-1 p-4 md:p-6 min-h-screen text-white bg-gray-900">
    <x-toast />

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-3xl font-bold">📊 Laporan & Statistik</h1>
        <p class="text-gray-400">Ringkasan performa sistem secara keseluruhan.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        
        <!-- Total Users -->
        <div class="bg-blue-600/20 border border-blue-600/30 rounded-xl p-4 flex items-center gap-4">
            <i class="fas fa-users text-blue-400 text-2xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Total Users</p>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>
        </div>

        <!-- Total Boards -->
        <div class="bg-purple-600/20 border border-purple-600/30 rounded-xl p-4 flex items-center gap-4">
            <i class="fas fa-table-columns text-purple-400 text-2xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Total Boards</p>
                <p class="text-2xl font-bold">{{ $totalBoards }}</p>
            </div>
        </div>

        <!-- Total Tasks -->
        <div class="bg-green-600/20 border border-green-600/30 rounded-xl p-4 flex items-center gap-4">
            <i class="fas fa-tasks text-green-400 text-2xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Total Tasks</p>
                <p class="text-2xl font-bold">{{ $totalTasks }}</p>
            </div>
        </div>

        <!-- Important Tasks -->
        <div class="bg-yellow-600/20 border border-yellow-600/30 rounded-xl p-4 flex items-center gap-4">
            <i class="fas fa-exclamation text-yellow-400 text-2xl"></i>
            <div>
                <p class="text-gray-400 text-sm">Important Tasks</p>
                <p class="text-2xl font-bold">{{ $importantTasks }}</p>
            </div>
        </div>

    </div>

    <!-- Chart -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">📈 Grafik Task Dibuat per Bulan</h2>
        <canvas id="taskChart" height="100"></canvas>
    </div>

    <!-- Kanban (Mini Preview) -->
    <h2 class="text-xl font-semibold mb-4">🗂 Kanban Board (Preview)</h2>

    <div class="flex gap-4 overflow-x-auto pb-6 kanban-board">

        @foreach($columns as $column)
        <div class="flex-shrink-0 w-72">
            <div class="bg-gray-800/60 border border-gray-700 rounded-xl p-4">

                <div class="mb-3 flex justify-between items-center">
                    <h3 class="font-semibold">{{ $column->name }}</h3>
                    <span class="text-xs bg-gray-700 px-2 py-1 rounded">{{ $column->tasks->count() }} Tasks</span>
                </div>

                <div class="space-y-3">
                    @forelse($column->tasks->sortBy('position') as $task)
                    <div class="bg-gray-900 border border-gray-700 rounded-xl p-3">
                        <p class="font-semibold">{{ $task->title }}</p>

                        <p class="text-xs text-gray-400 mt-1">
                            Dibuat oleh: <span class="text-blue-400">{{ $task->user->name ?? 'Unknown' }}</span>
                        </p>

                        <span class="block mt-2 text-xs px-2 py-1 rounded
                            @if($task->priority === 'important') bg-yellow-500/20 text-yellow-300
                            @elseif($task->priority === 'primary') bg-blue-500/20 text-blue-300
                            @else bg-gray-500/20 text-gray-300 @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                    @empty
                        <p class="text-gray-500 text-sm italic">Tidak ada task</p>
                    @endforelse
                </div>

            </div>
        </div>
        @endforeach

    </div>

</main>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('taskChart').getContext('2d');

// Gradient line
const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // biru atas
gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');   // transparan bawah

const labels = {!! json_encode($taskByMonth->keys()) !!};
const data = {!! json_encode($taskByMonth->values()) !!};

const taskChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Task Dibuat',
            data: data,
            fill: true,
            backgroundColor: gradient,
            borderColor: '#3B82F6', // biru
            borderWidth: 3,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 8,
            pointBackgroundColor: '#3B82F6',
            pointHoverBackgroundColor: '#2563EB',
            pointBorderColor: '#fff',
            pointHoverBorderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'nearest',
            intersect: false
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                enabled: true,
                backgroundColor: '#1F2937',
                titleColor: '#fff',
                bodyColor: '#fff',
                cornerRadius: 6,
                padding: 10,
                displayColors: true
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { color: '#9CA3AF' }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(156, 163, 175, 0.2)',
                    drawBorder: false
                },
                ticks: { color: '#9CA3AF' }
            }
        },
        animation: {
            duration: 1000,
            easing: 'easeOutQuart'
        }
    }
});
</script>

@endpush