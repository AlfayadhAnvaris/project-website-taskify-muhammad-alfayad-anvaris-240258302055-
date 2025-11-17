<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Report;

class AdminReportsIndex extends Component
{
    use WithPagination;

    public $totalReports;
    public $pendingReports;
    public $approvedReports;
    public $rejectedReports;
    public function mount()
    {
        $this->totalReports = Report::count();
        $this->pendingReports = Report::where('status', 'pending')->count();
        $this->approvedReports = Report::where('status', 'approved')->count();
        $this->rejectedReports = Report::where('status', 'rejected')->count();
    }



    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $reports = Report::with('user')
            ->where(function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('category', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin-reports-index', [
            'reports' => $reports,
            'totalReports' => $this->totalReports,
            'pendingReports' => $this->pendingReports,
            'approvedReports' => $this->approvedReports,
            'rejectedReports' => $this->rejectedReports,
        ]);
    }
}
