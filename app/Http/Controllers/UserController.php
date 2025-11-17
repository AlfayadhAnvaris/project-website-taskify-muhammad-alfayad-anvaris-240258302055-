<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class UserController extends Controller
{

    protected $listeners = [
        'taskMoved' => 'updateTaskPosition',
        'refreshBoard' => 'loadColumns',
        'columnAdded' => 'refreshColumns',
        'deleteTask' => 'deleteTask',
        'deleteColumn' => 'deleteColumn',
        'markAsDone' => 'markAsDone',


    ];

    public $board;
    public $totalBoards;
    public $totalColumns;
    public $totalTasks;
    public $completedTasks;


    public $primaryTasks;
    public $importantTasks;
    public $secondaryTasks;

    public function __construct()
    {
        // Pastikan hanya user biasa yang bisa akses
        $this->middleware(['auth', 'role:user']);
    }



    public function dashboard()
    {
       $users = User::where('role', 'user')   // hanya ambil role user
                ->withCount(['boards', 'tasks'])
                ->get();

        // User cuma bisa lihat board yang dia punya
        $boards = $users->boards->with('columns.tasks')->get();

        return view('livewire.dashboard', compact('boards'));
    }
}
