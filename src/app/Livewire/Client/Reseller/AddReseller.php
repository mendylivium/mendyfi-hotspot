<?php

namespace App\Livewire\Client\Reseller;

use Livewire\Component;
use App\Models\Reseller;
use App\Traits\BasicHelper;
use Livewire\Attributes\Computed;

class AddReseller extends Component
{
    use BasicHelper;

    public $resellerName, $resellerAddress, $resellerMobile, $resellerEmail, $resellerStatus = 'active';

    public function addReseller()
    {
        $this->validate([
            'resellerName'      =>  'required',
            'resellerAddress'   =>  'required',
            'resellerMobile'    =>  'required',
            'resellerEmail'     =>  'required|email',
            'resellerStatus'    =>  'required|in:active,suspended'
        ]);

        $newReseller = new Reseller();

        $newReseller->user_id       =   $this->user->id;
        $newReseller->name          =   $this->resellerName;
        $newReseller->address_name  =   $this->resellerAddress;
        $newReseller->mobile        =   $this->resellerMobile;
        $newReseller->email         =   $this->resellerEmail;
        $newReseller->status        =   $this->resellerStatus;

        $newReseller->save();

        return redirect()->route('client.reseller.list');
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.client.reseller.add-reseller')
        ->layout('components.layouts.app',[
            'pageName' => 'Reseller',
            'links' => ['Reseller', 'Add']
        ]);
    }
}
