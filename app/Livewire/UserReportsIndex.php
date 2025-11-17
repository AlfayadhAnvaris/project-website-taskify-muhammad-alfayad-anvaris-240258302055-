<?php

namespace App\Livewire;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserReportsIndex extends Component
{
    public function render()
    {
        $reports = Report::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.user-reports-index', compact('reports'));
    }
}
