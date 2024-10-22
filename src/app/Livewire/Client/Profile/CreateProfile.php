<?php

namespace App\Livewire\Client\Profile;

use App\Models\User;
use Livewire\Component;
use App\Traits\BasicHelper;
use App\Models\HotspotProfile;
use Livewire\Attributes\Computed;

class CreateProfile extends Component
{
    use BasicHelper;

    public $profileName;
    public $profileDescription;
    public $profilePrice = 0;
    public $profileUptimeLimit = 0;
    public $profileValidity = 0;
    public $profileMaxDownload = 0;
    public $profileMaxUpload = 0;
    public $profileDataLimit = 0;

    public function create()
    {
        $this->validate([
            'profileName'           =>  'required|min:5|max:50',
            'profileDescription'    =>  'max:50',
            'profilePrice'          =>  'min:0|numeric',
            'profileUptimeLimit'    =>  'min:0|numeric',
            'profileValidity'       =>  'min:0|numeric',
            'profileMaxDownload'    =>  'min:0|numeric',
            'profileMaxUpload'      =>  'min:0|numeric',
            'profileDataLimit'      =>  'min:0|numeric'
        ]);

    

        HotspotProfile::create([
            'user_id'       =>  $this->user->id,
            'name'          =>  $this->profileName,
            'description'   =>  $this->profileDescription,
            'price'         =>  $this->profilePrice,
            'uptime_limit'  =>  $this->profileUptimeLimit,
            'data_limit'    =>  $this->profileDataLimit,
            'max_download'  =>  $this->profileMaxDownload,
            'max_upload'    =>  $this->profileMaxUpload,
            'validity'      =>  $this->profileValidity

        ]);

        return redirect()->route('client.vouchers.profiles')
        ->with([
            'type'      =>  'success',
            'message'   =>  "Hotspot Profile \"{$this->profileName}\" created!"
        ]);
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.client.profile.create-profile')
        ->layout('components.layouts.app',[
            'pageName' => 'Create Profile',
            'links' => ['Create Profile']
        ]);
    }
}
