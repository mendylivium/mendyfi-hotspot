<?php

namespace App\Livewire\Client\Profile;

use Livewire\Component;
use App\Traits\BasicHelper;

class BindPolicy extends Component
{
    use BasicHelper;

    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        $appName = $this->getAppSetting('APP_NAME');

        return view('livewire.client.profile.bind-policy',[
            'user'      => $this->user,
            'appName'   => $appName 
        ]);
    }
}
