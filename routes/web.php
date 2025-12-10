<?php

use App\Livewire\AdminBoardDetail;
use App\Livewire\TeamBoardDetail;
use App\Livewire\TeamManagement;
use App\Livewire\AdminBoardsIndex;
use App\Livewire\AdminDashboard;
use App\Livewire\AdminLogsIndex;
use App\Livewire\AdminLogsShow;
use App\Livewire\AdminReportsIndex;
use App\Livewire\AdminReportsShow;
use App\Livewire\AdminUserBoards;
use App\Livewire\AdminUsersEdit;
use App\Livewire\AdminUsersIndex;
use App\Livewire\AdminUsersShow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// ===== LOGOUT =====
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ===== HOME =====
Route::get('/', function () {
    return view('welcome');
});

// ===== AUTH REQUIRED =====
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // Redirect berdasarkan role
    Route::get('/redirect', function () {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | USER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:user'])
        ->prefix('user')
        ->name('user.')
        ->group(function () {


            Route::get('/dashboard', \App\Livewire\UserDashboard::class)->name('dashboard');
            Route::get('/boards', \App\Livewire\UserBoardsIndex::class)->name('boards.index');
            Route::get('/boards/{boardId}', \App\Livewire\UserBoardView::class)->name('board.view');

            // Reports
            Route::get('/reports', \App\Livewire\UserReportsIndex::class)->name('reports.index');
            Route::get('/reports/create', \App\Livewire\UserReportsCreate::class)->name('reports.create');

            //Team Management
            Route::get('/user/teams', \App\Livewire\UserTeams::class)->name('teams');

            //Profile
            Route::get('/profile', \App\Livewire\ProfilePage::class)->name('profile');
        });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

            // Users
            Route::get('/users', AdminUsersIndex::class)->name('users');
            Route::get('/users/{user}', AdminUsersShow::class)->name('users.show');
            Route::get('/users/{user}/edit', AdminUsersEdit::class)->name('users.edit');

            // Boards
            Route::get('/boards', AdminBoardsIndex::class)->name('boards');


            // 2. Lihat semua board milik user
            Route::get('/users/{user}/boards', AdminUserBoards::class)
                ->name('users.boards');

            // 3. Detail board (melihat task + komentar)
            Route::get('/boards/{board}', AdminBoardDetail::class)
                ->name('boards.detail');

            // Reports
            Route::get('/reports', AdminReportsIndex::class)->name('reports.index');
            Route::get('/reports/{report}', AdminReportsShow::class)->name('reports.show');

            // Activity Logs
            Route::get('/logs', AdminLogsIndex::class)->name('logs.index');
            Route::get('/logs/{log}', AdminLogsShow::class)->name('logs.show');

            // Team Management
            Route::get('/teams', TeamManagement::class)->name('teams');
            Route::get('/teams/{team}/boards/{board}', TeamBoardDetail::class)->name('teams.boards.show');
        });
});
