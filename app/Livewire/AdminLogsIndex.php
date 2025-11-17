<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLog;

class AdminLogsIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Menghapus log tunggal
    public function deleteLog($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        session()->flash('success', 'Log berhasil dihapus.');
        $this->resetPage();
    }

    // Menghapus semua log
    public function clearAll()
    {
        ActivityLog::truncate(); // hapus semua
        session()->flash('success', 'Semua log berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(10);

        return view('livewire.admin-logs-index', [
            'logs' => $logs
        ]);
    }
}
