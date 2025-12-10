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

    public $statusFilter = '';
    public $categoryFilter = '';

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

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

      public function render()
    {
        $reports = Report::with('user')
            ->when($this->search, fn($query) => 
                $query->where('title', 'like', "%{$this->search}%")
                      ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            )
            ->when($this->statusFilter, fn($query) => $query->where('status', $this->statusFilter))
            ->when($this->categoryFilter, fn($query) => $query->where('category', $this->categoryFilter))
            ->orderByDesc('created_at')
            ->paginate(10);

        $totalReports = Report::count();
        $pendingReports = Report::where('status', 'pending')->count();
        $approvedReports = Report::where('status', 'approved')->count();
        $rejectedReports = Report::where('status', 'rejected')->count();

        return view('livewire.admin-reports-index', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'approvedReports',
            'rejectedReports'
        ));
    }
}
