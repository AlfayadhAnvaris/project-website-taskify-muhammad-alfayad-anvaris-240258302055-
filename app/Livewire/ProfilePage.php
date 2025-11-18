<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilePage extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $avatar;
    public $newAvatar;

    public $current_password;
    public $new_password;
    public $confirm_password;

    public function mount()
    {
        $user = Auth::user();

        // FIX: pastikan selalu user model
        if (!$user) {
            abort(403, 'User not authenticated');
        }

        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
    }

    public function updateProfile()
    {
        $this->validate([
            'name'  => 'required|min:3',
            'email' => 'required|email',
        ]);

        $user = Auth::user(); // FIX: Eloquent instance

        $user->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Profil berhasil diperbarui.');
    }

    public function updateAvatar()
    {
        $this->validate([
            'newAvatar' => 'required|image|max:2048',
        ]);

        $user = Auth::user(); // FIX: Eloquent instance

        $fileName = 'avatar_' . $user->id . '.' . $this->newAvatar->extension();
        $this->newAvatar->storeAs('avatars', $fileName, 'public');

        $user->avatar = $fileName;
        $user->save; 

        $this->avatar = $fileName;
        $this->newAvatar = null;

        session()->flash('success', 'Foto profil berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password'      => 'required|min:6',
            'confirm_password'  => 'required|same:new_password',
        ]);

        $user = Auth::user(); // FIX

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password lama salah');
            return;
        }

        $user->password = Hash::make($this->new_password);
        $user->save; 

        $this->reset(['current_password', 'new_password', 'confirm_password']);

        session()->flash('success', 'Password berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.profile-page');
    }
}
