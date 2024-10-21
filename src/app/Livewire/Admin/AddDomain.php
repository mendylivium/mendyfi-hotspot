<?php

namespace App\Livewire\Admin;

use App\Models\AppSetting;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\User;
use App\Traits\BasicHelper;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Orangehill\Iseed\Iseed;

class AddDomain extends Component
{
    use BasicHelper;

    public $userName, $password, $domainName, $errorMessage;

    public function addDomain()
    {
        try {
            $this->validate([
                'userName'      =>  'required|unique:domains,user_name',
                'password'   =>  'required',
                'domainName'    =>  'required|unique:domains,domain',
            ]);
            $tenant = Tenant::create([]);
            $hashedPassword = Hash::make($this->password);
            $domain = $tenant->domains()->create([
                'domain' => $this->domainName.'.'.request()->getHost(),
                'user_name' => $this->userName,
                'password' => $hashedPassword
            ]);

            $iseed = new Iseed();
            $iseed->generateSeed('tenants', null, null, 'mysql');
            $iseed->generateSeed('domains', null, null, 'mysql');

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

            return redirect()->route('admin.dashboard',['id' => $domain->id]);
        } catch (\Throwable $e) {
            $this->errorMessage = 'Failed to add domain: ' . $e->getMessage();
        }

    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function render()
    {
        // $tenant = Tenant::first();
        // tenancy()->initialize($tenant);

        // dd(DB::connection()->getName());

        return view('livewire.admin.domain.add-domain')
        ->layout('components.layouts.app',[
            'pageName' => 'Reseller',
            'links' => ['Domain', 'Add']
        ]);
    }
}
