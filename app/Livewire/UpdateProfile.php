<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;

class UpdateProfile extends Component
{
    public $state = [];

    public function mount()
    {
        $this->state = Auth::user()->toArray();
    }

    public function updateProfileInformation()
    {
        Validator::make($this->state, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ])->validate();

        Auth::user()->update($this->state);

        // Dispatch SweetAlert notification
        $this->dispatchBrowserEvent('profile-updated', [
            'type' => 'success',
            'title' => 'Profile Updated',
            'text' => 'Your profile has been successfully updated.',
        ]);

        session()->flash('saved', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.update-profile');
    }
}
