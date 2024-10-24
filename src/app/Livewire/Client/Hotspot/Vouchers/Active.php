<?php
namespace App\Livewire\Client\Hotspot\Vouchers;
use App\Models\User;
use Livewire\Component;
use App\Traits\BasicHelper;
use App\Traits\RadiusHelper;
use Livewire\WithPagination;
use App\Models\HotspotVouchers;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Http;

class Active extends Component
{
    use WithPagination;
    use RadiusHelper;
    use BasicHelper;

    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    #[Computed()]
    public function voucher()
    {
        return HotspotVouchers::leftJoin('hotspot_profiles','hotspot_profiles.id','hotspot_vouchers.hotspot_profile_id')
        ->where([
            'hotspot_vouchers.user_id' => $this->user->id,
            'hotspot_vouchers.connected' => true
        ])
        ->where('hotspot_vouchers.used_date','<>',null)
        ->when($this->search, function($query) {
            $query->where(function($query) {
                $query->where('hotspot_vouchers.code', 'like', '%' . $this->search . '%')
                      ->orWhere('hotspot_vouchers.mac_address', 'like', '%' . $this->search . '%')
                      ->orWhere('hotspot_vouchers.ip_address', 'like', '%' . $this->search . '%')
                      ->orWhere('hotspot_vouchers.router_ip', 'like', '%' . $this->search . '%')
                      ->orWhere('hotspot_profiles.name', 'like', '%' . $this->search . '%');
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

    public function disconnect($id)
    {
        $hotspotUser = HotspotVouchers::query()
        ->where([
            'id' => $id,
            'connected' => true
        ])->first();

        if(!$hotspotUser) {
            return $this->showFlash([
                'type' => 'danger',
                'message' => 'User is not Active'
            ]);
        }

        $coaResult = $this->radiusCoa('disconnect',[
            'User-Name' => $hotspotUser->code,
            'Framed-IP-Address' => $hotspotUser->ip_address,
        ],
        $this->user->api_secret,
        $hotspotUser->router_ip);

        if(!$coaResult) {
            return $this->showFlash([
                'type' => 'danger',
                'message' => 'Fail to sent COA Request'
            ]);
        } else {
            return $this->showFlash([
                'type' => 'success',
                'message' => 'User Disconnected'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.client.hotspot.vouchers.active')
        ->layout('components.layouts.app',[
            'pageName' => 'Active Hotspot',
            'links' => ['Hotspot', 'Active Hotspot']
        ]);
    }
}
