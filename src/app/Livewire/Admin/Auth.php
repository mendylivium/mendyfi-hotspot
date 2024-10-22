<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Auth extends Component
{
    public $username;
    public $password;

    public function login()
    {
        $credentials = $this->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(auth()->attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return  $this->addError('username', 'Username or Password Mismatch');
    }

    public function render()
    {
        return view('livewire.admin.auth')
        ->layout('components.layouts.guest',[
            'page_title' => 'Login'
        ]);
    }
}
