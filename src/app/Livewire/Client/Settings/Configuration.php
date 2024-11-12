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
    public $radiusIP, $radiusPublicIP;
    public $radiusSecret;
    
    public $currentPassword;
    public $password;
    public $password_confirmation;


    public $currentPassword2;

    public $accountPassword;

    public $userName = '';


    public function changeUserName()
    {
        $this->validate([
            'userName' => 'required|min:4|alpha_num',
            'currentPassword2' => 'required'
        ],[],[
            'currentPassword2' => 'Password'
        ]);

        if($this->userName == $this->user->username) {
            return $this->addError('userName','Same with Old!');
        }

        if(!Hash::check($this->currentPassword2, $this->user->password)) {
            return $this->addError('currentPassword2','Wrong Password');
        }

        /**
         * tenancy()->central() currently not works here use DB instead
         */
        $existInCentral = \DB::connection('mysql')
        ->table('domains')
        ->where([
            'username' => $this->userName
        ])
        ->exists();

        if($existInCentral) {
            return $this->addError('userName','Already Taken!');
        }

        \DB::connection('mysql')
        ->table('domains')
        ->where([
            'username' => $this->user->username
        ])
        ->update([
            'username' => $this->userName
        ]);

        $this->user->username = $this->userName;
        $this->user->save();

        $this->showFlash([
            'type'      =>  'success',
            'message'   =>  'Username Changed!, Please make sure to update your Router / NAS Also.'
        ]);
    }
    

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
        $this->radiusPublicIP = $this->getPublicIp();
        $this->userName = $this->user->username;
    }

    public function render()
    {
        $this->mktikRealm = "mikrotik.{$this->user->api_public}.{$this->user->id}.id";
        $this->otherRealm = "other.{$this->user->api_public}.{$this->user->id}.id";

        $this->apiPublic    =   $this->user->api_public;
        $this->apiSecret   =   $this->user->api_secret;

        return view('livewire.client.settings.configuration')
        ->layout('components.layouts.app',[
            'pageName' => 'Settings',
            'links' => ['Settings']
        ]);
    }
}
