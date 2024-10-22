<?php

namespace App\Livewire\Client\Reseller;

use Livewire\Component;
use App\Models\Reseller;
use App\Traits\BasicHelper;
use Livewire\Attributes\Computed;

class EditReseller extends Component
{

    use BasicHelper;

    public $resellerName, $resellerAddress, $resellerMobile, $resellerEmail, $resellerStatus = 'active';
    public $resellerId;

    

    public function editReseller()
    {
        $this->validate([
            'resellerName'      =>  'required',
            'resellerAddress'   =>  'required',
            'resellerMobile'    =>  'required',
            'resellerEmail'     =>  'required|email',
            'resellerStatus'    =>  'required|in:active,suspended'
        ]);

        $reseller = Reseller::query()
        ->where([
            'user_id'   =>  $this->user->id,
            'id'        =>  $this->resellerId
        ])->first();

        $reseller->user_id       =   $this->user->id;
        $reseller->name          =   $this->resellerName;
        $reseller->address_name  =   $this->resellerAddress;
        $reseller->mobile        =   $this->resellerMobile;
        $reseller->email         =   $this->resellerEmail;
        $reseller->status        =   $this->resellerStatus;

        $reseller->save();

        return redirect()->route('client.reseller.list')->with([
            'type'      =>  'success',
            'message'   =>  "Reseller ID#{$this->resellerId} is Updated!"
        ]);
    }

    #[Computed()]
    public function reseller()
    {
        return Reseller::query()
        ->where([
            'user_id'   =>  $this->user->id,
            'id'        =>  $this->resellerId,
        ])
        ->first();
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function mount($id)
    {
  
        $this->resellerId = $id;

        if(!$this->reseller) {
            return redirect()->route('client.reseller.list')->with([
                'type'      =>  'danger',
                'message'   =>  "Reseller with ID#{$id} is not exist"
            ]);
        }

        $this->resellerName     =   $this->reseller->name;
        $this->resellerAddress  =   $this->reseller->address_name;
        $this->resellerMobile   =   $this->reseller->mobile;
        $this->resellerEmail    =   $this->reseller->email;
        $this->resellerStatus   =   $this->reseller->status;
    }

    public function render()
    {
        return view('livewire.client.reseller.edit-reseller')
        ->layout('components.layouts.app',[
            'pageName' => 'Reseller',
            'links' => ['Reseller', 'Edit']
        ]);
    }
}
