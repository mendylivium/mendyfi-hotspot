<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Traits\BasicHelper;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Hash;

class Config extends Component
{
    use BasicHelper;

    public $radiusInterim = 1;

    public $currentPassword;
    public $password;
    public $password_confirmation;

    public function changePass()
    {
        $this->validate([
            'currentPassword'=> 'required|min:4',
            'password' => 'required|min:4|confirmed'
        ]);

        if(!Hash::check($this->currentPassword, $this->user->password)) {
            return $this->addError('currentPassword','Wrong Password');
        }

        User::query()
        ->where('id', $this->user->id)
        ->update([
            'password'  => Hash::make($this->password)
        ]);

        $this->showFlash([
            'type'      =>  'success',
            'message'   =>  'Successfully Changed!'
        ]);
    }

    public function editSettings()
    {
        $this->validate([
            'radiusInterim' => 'required|numeric'
        ]);

        $this->setAppSetting([
            'RADIUS_INTERIM' => $this->radiusInterim
        ]);

        return $this->showFlash([
            'type' => 'success',
            'message' => 'Settings updated'
        ]);
    }

    public function mount()
    {
        $this->radiusInterim = $this->getAppSetting('RADIUS_INTERIM');
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.admin.config')
        ->layout('components.layouts.app',[
            'pageName' => 'Configurations',
            'links' => ['Config']
        ]);
    }
}
