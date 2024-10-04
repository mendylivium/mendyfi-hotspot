<?php

namespace App\Livewire\Client\Hotspot\Vouchers;

use App\Models\User;
use Livewire\Component;
use App\Traits\BasicHelper;
use App\Traits\RadiusHelper;
use Livewire\WithPagination;
use App\Models\HotspotVouchers;
use Livewire\Attributes\Computed;

class Used extends Component
{
    use BasicHelper;
    use WithPagination;
    use RadiusHelper;

    protected $paginationTheme = 'bootstrap';


    #[Computed()]
    public function vouchers()
    {
        return HotspotVouchers::leftJoin('hotspot_profiles','hotspot_profiles.id','hotspot_vouchers.hotspot_profile_id')
        ->where([
            'hotspot_vouchers.user_id' => $this->user->id
        ])
        ->where('hotspot_vouchers.used_date','<>',null)
        ->select(
            'hotspot_vouchers.*',
            'hotspot_profiles.name as profile_name',
            'hotspot_profiles.price',
            'hotspot_profiles.uptime_limit',
            'hotspot_profiles.data_limit',
            'hotspot_profiles.max_download',
            'hotspot_profiles.max_upload',
            'hotspot_profiles.validity'
        )
        ->orderBy('hotspot_vouchers.id','DESC')
        ->paginate(10);
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.client.hotspot.vouchers.used')
        ->layout('components.layouts.app',[
            'pageName' => 'Used Voucher',
            'links' => ['Hotspot', 'Used']
        ]);
    }
}
