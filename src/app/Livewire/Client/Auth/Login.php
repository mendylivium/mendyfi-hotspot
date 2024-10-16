<?php

namespace App\Livewire\Client\Auth;

use App\Models\User;
use Livewire\Component;
use App\Models\AppSetting;
use App\Traits\BasicHelper;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class Login extends Component
{
    use BasicHelper;

    public $username;
    public $password;
    public $pageTitle = 'Test';

    public function login()
    {
        $credentials = $this->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $tenant = tenant();
        if(RateLimiter::tooManyAttempts('login:'.$this->username, 20)) {
            $seconds = RateLimiter::availableIn('login:'.$this->username);
            return $this->addError('username', 'You may try again in '.$seconds.' seconds.');
        }

        if(auth()->attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->route($tenant ? 'client.dashboard' : 'admin.dashboard');
        }

        RateLimiter::hit('login:'.$this->username, 30);

        return  $this->addError('username', 'Username or Password Mismatch');

    }

    public function mount()
    {
        $this->pageTitle = $this->getAppSetting('APP_NAME');
    }

    public function render()
    {
        return view('livewire.client.auth.login')
        ->layout('components.layouts.guest',[
            'page_title' => $this->pageTitle
        ]);
    }
}
