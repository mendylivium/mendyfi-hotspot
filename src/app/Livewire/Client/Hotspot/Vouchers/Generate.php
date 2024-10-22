<?php

namespace App\Livewire\Client\Hotspot\Vouchers;

use App\Models\User;
use Livewire\Component;
use App\Models\Reseller;
use App\Traits\BasicHelper;
use App\Models\HotspotProfile;
use App\Models\HotspotVouchers;
use App\Models\VoucherTemplate;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;

class Generate extends Component
{

    use BasicHelper;

    public $voucherPrefix = 'VC';
    public $voucherPattern = 6;
    public $voucherPatternLength = 3;
    public $voucherProfile = 0;
    public $voucherQty = 10;
    public $resellerId = 0;

    public $passwordPattern = 0;
    public $voucherPasswordLength = 6;  


    private $patterns = [
        '23456789ABCDEFGHJKMNOPQRSTUVWXYZ',
        '23456789abcdefghjkmnopqrstuvwxyz',
        'ABCDEFGHJKMNOPQRSTUVWXYZ',
        'abcdefghjkmnopqrstuvwxyz',
        'ABCDEFGHJKMNOPQRSTUVWXYZabcdefghjkmnopqrstuvwxyz',
        '0123456789'
    ];

    #[Computed()]
    public function resellers()
    {
        return Reseller::query()
        ->where([
            'user_id'   =>  $this->user->id,
            'status'    =>  'active'
        ])
        ->select('id','name')
        ->get();
    }

    public function generate()
    {

        $this->validate([
            'voucherPrefix'         =>  'alpha_num',
            'voucherPattern'        =>  'required|min:1|max:6',
            'passwordPattern'       =>  'required|min:0|max:6',
            'voucherPasswordLength' =>  'numeric',
            'voucherPatternLength'  =>  'required|numeric|min:3|max:12',
            'voucherProfile'        =>  'required|numeric|min:1|exists:hotspot_profiles,id',
            'voucherQty'            =>  'required|numeric|min:1|max:1000',
            'resellerId'            =>  'numeric'
        ]);

        if(($this->user->total_vouchers + $this->voucherQty)>= 5000) {
            return redirect()->route('client.vouchers.list')
            ->with([
                'type'      =>  'warning',
                'message'   =>  "You can`t have more than 5000 vouchers"
            ]);
        }

        $patternIndex = $this->voucherPattern - 1;
        $passwordPatternIndex = $this->passwordPattern - 1;
        $data = [];
        $batchCode = now()->timestamp;

        for($i = 0; $i < $this->voucherQty;$i++) {
            $postfix = $this->randomStr($this->voucherPatternLength,$this->patterns[$patternIndex]);

            $data[] = [
                'user_id'               =>  $this->user->id,
                'code'                  =>  "{$this->voucherPrefix}{$postfix}",
                'hotspot_profile_id'    =>  $this->voucherProfile,
                'batch_code'            =>  $batchCode,
                'generation_date'       =>  now(),
                'reseller_id'           =>  $this->resellerId ? $this->resellerId : null,
                'password'              =>  $this->passwordPattern == 0 ? null : $this->randomStr($this->voucherPasswordLength,$this->patterns[$passwordPatternIndex])
            ];
        }

        HotspotVouchers::insert($data);

        return redirect()->route('client.vouchers.list')
            ->with([
                'type'      =>  'success',
                'message'   =>  "Generated {$this->voucherQty} vouchers successfully!"
            ]);

    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    #[Computed()]
    public function profiles()
    {
        return HotspotProfile::where('user_id', $this->user->id)
        ->get();
    }

    public function render()
    {
        return view('livewire.client.hotspot.vouchers.generate')
        ->layout('components.layouts.app',[
            'pageName' => 'Active Hotspot',
            'links' => ['Hotspot', 'Generate Voucher']
        ]);
    }
}
