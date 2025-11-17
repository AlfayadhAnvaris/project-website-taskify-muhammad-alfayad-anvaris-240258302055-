<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Column;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 
class AdminController extends Controller
{

    public function __construct()
    {
        // Pastikan hanya admin yang bisa akses
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Admin bisa lihat semua board
        $boards = Board::with('columns.tasks')->get();

        return view('admin.dashboard', compact('boards'));
    }

    public function manageUsers()
    {
        $users = User::where('role', 'user')   // hanya ambil role user
                ->withCount(['boards', 'tasks'])
                ->get();;
        return view('admin.users', compact('users'));
    }
public function dashboard()
{
    $totalUsers = User::count();
    $totalBoards = Board::count();
    $totalTasks = Task::count();

    // Ambil semua column + task + user pembuat task
    $columns = Column::with(['tasks.user'])->get();

    // Ambil board pertama saja
    $board = Board::first();

    // Priority
    $primaryTasks = Task::where('priority', 'primary')->count();
    $importantTasks = Task::where('priority', 'important')->count();
    $secondaryTasks = Task::where('priority', 'secondary')->count();

    // Top user (paling banyak board)
    $topUsers = User::withCount('boards')
        ->orderBy('boards_count', 'desc')
        ->take(5)
        ->get();

    // Task per bulan untuk chart
    $taskByMonth = Task::selectRaw("COUNT(*) as total, DATE_FORMAT(created_at, '%M') as month")
        ->groupBy('month')
        ->pluck('total', 'month');

    return view('admin.dashboard', compact(
        'totalUsers',
        'totalBoards',
        'totalTasks',
        'primaryTasks',
        'importantTasks',
        'secondaryTasks',
        'topUsers',
        'columns',
        'board',
        'taskByMonth'
    ));
}


  public function updateTaskPosition($taskId = null, $to = null, $position = null, $from = null)
{
    if (!$taskId || !$to || $position === null) {
        Log::warning("updateTaskPosition dipanggil tanpa parameter lengkap.");
        return;
    }

    try {
        $task = Task::findOrFail($taskId);
        $oldColumnId = $task->column_id;
        $newColumnId = $to;

        Log::info("📦 Moving task {$task->id} from {$oldColumnId} to {$newColumnId} at position {$position}");

        // Update posisi & kolom
        $task->update([
            'column_id' => $newColumnId,
            'position' => $position,
        ]);

        // Reorder task di kolom lama & baru
        $this->reorderTasksInColumn($newColumnId);
        if ($oldColumnId !== $newColumnId) {
            $this->reorderTasksInColumn($oldColumnId);
        }

        // Optional: update priority sesuai kebutuhan (misal berdasarkan kolom atau logic lain)
        // $task->priority = ...;
        // $task->save();

        $this->dispatch('taskMoved', [
            'taskId' => $task->id,
            'from' => $oldColumnId,
            'to' => $newColumnId,
        ]);

    } catch (\Exception $e) {
        Log::error("❌ Error updating task position: " . $e->getMessage());
        $this->dispatch('toast', [
            'type' => 'error',
            'message' => 'Gagal memindahkan task.',
        ]);
    }
}


public function users()
{
    $users = User::where('role', 'user')              // hanya role user
        ->withCount('boards')                         // hitung boards otomatis
        ->get()
        ->map(function ($user) {

            // Hitung total tasks milik user berdasarkan board
            $user->tasks_count = Task::whereHas('column.board', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();

            return $user;
        });

    return view('admin.users.index', compact('users'));
}


public function showUser(User $user)
{
    $boards = $user->boards()->with('columns.tasks')->get();

    $tasks = Task::whereHas('column.board', function($q) use ($user) {
        $q->where('user_id', $user->id);
    })->get();

    return view('admin.users.show', compact('user', 'boards', 'tasks'));
}


  public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }



}
