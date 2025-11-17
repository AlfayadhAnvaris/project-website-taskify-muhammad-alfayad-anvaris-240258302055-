<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminUsersEdit extends Component
{
    public User $user;
    public $name;
    public $email;
    public $password;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
    }

    public function update()
    {
        $validated = $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'nullable|min:6',
        ]);

        if ($this->password) {
            $validated['password'] = Hash::make($this->password);
        } else {
            unset($validated['password']);
        }

        $this->user->update($validated);

        session()->flash('success', 'User berhasil diperbarui.');

        return redirect()->route('admin.users');
    }

    public function render()
    {
        return view('livewire.admin.users-edit');
    }
}
