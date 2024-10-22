<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Tenant;
use Livewire\Component;
use App\Models\AppSetting;
use Illuminate\Support\Str;

class AddUser extends Component
{
    public $userName;
    public $password;
    public $domain;
    public $userStatus = 'active';

    public function addTenant()
    {
        $this->validate([
            'userName'   =>  'required|unique:domains,username',
            'password'   =>  'required|min:8',
            'domain'    =>  'required|unique:domains,domain',
            'userStatus' => 'required|in:active,suspended'
        ]);

        $newTenant = Tenant::create([]);

        $hashedPassword = bcrypt($this->password);

        $newTenant->domains()->create([
            'username' => $this->userName,
            'password' => $hashedPassword,
            'domain' => $this->domain,
            'status' => $this->userStatus,
        ]);

        tenancy()->initialize($newTenant);

        User::create([
            'name'          =>  'Administrator',
            'username'      =>  $this->userName,
            'password'      =>  $hashedPassword,
            'api_public'    =>  $this->userName,
            'api_secret'    =>  Str::random(12),
            'sessionToken'  =>  'ses_' . Str::random(20),
            'license_validity'  =>  now(),
            'mobile'        =>  '09123456789',
        ]);

        AppSetting::insert([
            ['name' =>  'APP_NAME',     'value' =>  'Mendyfi'],
            ['name' =>  'INRO_TEXT',    'value' =>  'Centalize Hotspot System'],
            ['name' =>  'SUB_TEXT',     'value' =>  'Radius for your Hotspot'],
            ['name' =>  'RADIUS_INTERIM', 'value' => '1'],
        ]);

        return redirect()->route('admin.dashboard')
        ->with([
            'type' => 'success',
            'message' => 'Tenant Created!'
        ]);
        
    }

    public function render()
    {
        return view('livewire.admin.add-user')
        ->layout('components.layouts.app',[
            'pageName' => 'Add User',
            'links' => ['Users', 'Add']
        ]);
    }
}
