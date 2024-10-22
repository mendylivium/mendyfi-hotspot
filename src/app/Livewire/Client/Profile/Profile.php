<?php

namespace App\Livewire\Client\Profile;

use App\Models\User;
use Livewire\Component;
use App\Traits\BasicHelper;
use App\Traits\RadiusHelper;
use Livewire\WithPagination;
use App\Models\HotspotProfile;
use App\Models\HotspotVouchers;
use Livewire\Attributes\Computed;

class Profile extends Component
{
    use BasicHelper;
    use RadiusHelper;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function deleteProfile($id)
    {


        HotspotProfile::where([
            'user_id'   =>  $this->user->id,
            'id'    =>  $id
        ])
        ->delete();

        HotspotVouchers::where([
            'user_id'       =>  $this->user->id,
            'hotspot_profile_id'    =>  $id
        ])
        ->delete();

        $this->showFlash([
            'type'      =>  'danger',
            'message'   =>  'Profile and Its Voucher has been Deleted!'
        ]);

        // return redirect()->route('client.profiles')
        // ->with([
        //     'type'      =>  'warning',
        //     'message'   =>  "You've just deleted a hotspot profile with ID#{$id}"
        // ]);
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    #[Computed()]
    public function profiles()
    {
        // return HotspotProfile::where([
        //     'user_id' => $this->user->id
        // ])
        // ->orderBy('id','DESC')
        // ->paginate(20);

        return $this->user->hotspotProfiles()
        ->orderBy('id','DESC')
        ->paginate(20);
    }

    public function render()
    {
        // $user = User::where('sessionToken', $this->sessionToken)
        // ->first();

        // $profiles = HotspotProfile::where([
        //     'user_id' => $user->id
        // ])
        // ->orderBy('id','DESC')
        // ->paginate(20);
        
        $appName = $this->getAppSetting('APP_NAME');


        return view('livewire.client.profile.profile')
        ->layout('components.layouts.app',[
            'pageName' => 'Profile List',
            'links' => ['Profile List']
        ]);
    }
}
