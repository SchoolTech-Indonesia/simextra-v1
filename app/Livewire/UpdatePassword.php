<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdatePassword extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function updatePassword()
    {
        $this->validate([
            'state.current_password' => 'required',
            'state.password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        if (!Hash::check($this->state['current_password'], $user->password)) {
            session()->flash('error', 'Current password does not match.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->state['password']),
        ]);

        // Dispatch the SweetAlert event
        $this->dispatchBrowserEvent('password-updated', [
            'type' => 'success',
            'title' => 'Password Updated',
            'text' => 'Your password has been successfully updated.',
        ]);

        // Clear the form
        $this->reset(['state']);
    }

    public function render()
    {
        return view('livewire.update-password');
    }
}
