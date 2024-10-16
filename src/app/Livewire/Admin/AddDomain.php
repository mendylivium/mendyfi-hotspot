<?php

namespace App\Livewire\Admin;

use App\Models\AppSetting;
use App\Models\Tenant;
use App\Models\User;
use App\Traits\BasicHelper;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;


class AddDomain extends Component
{
    use BasicHelper;

    public $userName, $password, $domainName;

    public function addDomain()
    {
        $this->validate([
            'userName'      =>  'required|unique:domains,user_name',
            'password'   =>  'required',
            'domainName'    =>  'required|unique:domains,domain',
        ]);
        $tenant = Tenant::create([]);
        $hashedPassword = Hash::make($this->password);
        $tenant->domains()->create([
            'domain' => $this->domainName.'.'.request()->getHost(),
            'user_name' => $this->userName,
            'password' => $hashedPassword
        ]);

        tenancy()->initialize($tenant);

        Permission::create(['name' =>  'admin-function']);

        $adminUser = Role::create(['name' => 'admin']);

        $adminUser->givePermissionTo([
            'admin-function',
        ]);

        $admin = User::create([
            'name'          =>  'Administrator',
            'username'         =>  $this->userName,
            'password'      =>  $hashedPassword,
            'api_public'    =>  Str::random(12),
            'api_secret'    =>  Str::random(12),
            'sessionToken'  =>  'ses_' . Str::random(20),
            'license_validity'  =>  now(),
            'mobile'        =>  '09123456789',
        ]);

        $admin->assignRole('admin');

        AppSetting::insert([
            ['name' =>  'APP_NAME',     'value' =>  'Mendyfi'],
            ['name' =>  'INRO_TEXT',    'value' =>  'Centalize Hotspot System'],
            ['name' =>  'SUB_TEXT',     'value' =>  'Radius for your Hotspot'],
            ['name' =>  'RADIUS_INTERIM', 'value' => '1'],
        ]);

        return redirect()->route('admin.dashboard');
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.admin.domain.add-domain')
        ->layout('components.layouts.app',[
            'pageName' => 'Reseller',
            'links' => ['Domain', 'Add']
        ]);
    }
}
