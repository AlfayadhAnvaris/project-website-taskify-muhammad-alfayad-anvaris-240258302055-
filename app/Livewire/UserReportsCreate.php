<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Report;

class UserReportsCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $category;
    public $content;
    public $attachment;

    // RULES WAJIB ADA!
    protected $rules = [
        'title' => 'required|string|max:255',
        'category' => 'required|in:progress,kritik_saran,masalah,lainnya',
        'content' => 'required|string',
        'attachment' => 'nullable|file|max:5120', // max 5MB
    ];

    public function store()
    {
        $this->validate(); // VALIDASI JALAN

        $path = null;

        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');
        }

        Report::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'category' => $this->category,
            'content' => $this->content,
            'attachment' => $path,
        ]);

        session()->flash('success', 'Laporan berhasil dibuat.');

        return redirect()->route('user.reports.index');
    }

    public function render()
    {
        return view('livewire.user-reports-create');
    }
}
