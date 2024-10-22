<?php

namespace App\Livewire\Client\FairUsePolicy;

use Livewire\Component;
use App\Traits\BasicHelper;
use App\Models\FairUsePolicy;

class AddFup extends Component
{
    use BasicHelper;

    public $policyName = "Fair Use Policy";
    public $resetsEvery = 3600;
    public $condition = "fup_uptime>=1000\nfup_data>=1000";
    public $action = "WISPr-Bandwidth-Max-Down=1000\nWISPr-Bandwidth-Max-Up=1000";

    public function createPolicy()
    {
        $this->validate([
            'policyName' => 'required|min:5|max:30',
            'resetsEvery' => 'required|numeric|min:1',
            'condition' => 'required',
            'action' => 'required'
        ]);

        if(!$this->isConditionFormat($this->condition)) {
            return $this->addError('condition', "Invalid Condition Format");
        }

        if(!$this->isActionFormat($this->action)) {
            return $this->addError('action', "Invalid Action Format");
        }

        $existName = FairUsePolicy::query()
        ->where('name', $this->policyName)
        ->select('id')
        ->first();

        if($existName) {
            return $this->addError('policyName', "Name Already Used!");
        }

        $fairUserPolicy = new FairUsePolicy();

        $fairUserPolicy->name = $this->policyName;
        $fairUserPolicy->resets_every = $this->resetsEvery;
        $fairUserPolicy->condition = $this->condition;
        $fairUserPolicy->action = $this->action;

        $fairUserPolicy->save();

        return redirect()->route('client.fairuse.list')->with([
            'type' => 'success',
            'message' => 'Added New Policy'
        ]);
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.client.fair-use-policy.add-fup')
        ->layout('components.layouts.app',[
            'pageName' => 'Fair Use Policy',
            'links' => ['Fair Use Policy', 'Add']
        ]);
    }
}
