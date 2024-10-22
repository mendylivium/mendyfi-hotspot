<?php

namespace App\Livewire\Client\Settings;

use App\Models\User;
use Livewire\Component;
use App\Traits\BasicHelper;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class Configuration extends Component
{
    use BasicHelper;

    public $sessionToken;
    public $mktikRealm;
    public $otherRealm;
    public $apiPublic;
    public $apiSecret;
    public $radiusIP;
    public $radiusSecret;
    
    public $currentPassword;
    public $password;
    public $password_confirmation;

    public $accountPassword;


    public function changePass()
    {
        $this->validate([
            'currentPassword'   => 'required',
            'password'  =>  'required|min:4|max:20|confirmed',
        ]);

        if(!Hash::check($this->currentPassword, $this->user->password)) {
            return $this->addError('currentPassword','Wrong Password');
        }

        User::query()
        ->where('id', $this->user->id)
        ->update([
            'password'  => Hash::make($this->password)
        ]);

        // return redirect()->route('client.config')
        $this->showFlash([
            'type'      =>  'success',
            'message'   =>  'Successfully Changed!'
        ]);

    }

    public function recreate()
    {
        User::where('id', $this->user->id)
        ->update([
            'api_secret'    =>  Str::random(12)
        ]);

        $this->showFlash([
            'type'      =>  'success',
            'message'   =>  'Config Recreated!'
        ]);
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function mount()
    {
        $this->radiusIP = $this->getCurrentIp();
    }

    public function render()
    {
        $this->mktikRealm = "mikrotik.{$this->user->api_public}.{$this->user->id}.id";
        $this->otherRealm = "other.{$this->user->api_public}.{$this->user->id}.id";

        $this->apiPublic    =   $this->user->api_public;
        $this->apiSecret   =   $this->user->api_secret;

        return view('livewire.client.settings.configuration')
        ->layout('components.layouts.app',[
            'pageName' => 'Voucher Template',
            'links' => ['Hotspot', 'Voucher', 'Template']
        ]);
    }
}
