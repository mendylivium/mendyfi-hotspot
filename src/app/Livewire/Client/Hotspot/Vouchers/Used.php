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
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function vouchers()
    {
        return HotspotVouchers::leftJoin('hotspot_profiles','hotspot_profiles.id','hotspot_vouchers.hotspot_profile_id')
        ->where([
            'hotspot_vouchers.user_id' => $this->user->id
        ])
        ->where('hotspot_vouchers.used_date','<>',null)
        ->when($this->search, function($query) {
            $query->where(function($query) {
                $query->where('hotspot_vouchers.code', 'like', '%' . $this->search . '%')
                      ->orWhere('hotspot_vouchers.batch_code', 'like', '%' . $this->search . '%')
                      ->orWhere('hotspot_profiles.name', 'like', '%' . $this->search . '%')
                      ->orWhere('hotspot_vouchers.mac_address', 'like', '%' . $this->search . '%')
                      ->orWhere('hotspot_vouchers.ip_address', 'like', '%' . $this->search . '%');
            });
        })
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
