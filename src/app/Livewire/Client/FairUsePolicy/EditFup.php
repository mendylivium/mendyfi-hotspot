<?php

namespace App\Livewire\Client\FairUsePolicy;

use Livewire\Component;
use App\Traits\BasicHelper;
use App\Models\FairUsePolicy;
use Livewire\Attributes\Computed;

class EditFup extends Component
{

    use BasicHelper;

    public $policyId;

    public $policyName = "Fair Use Policy";
    public $resetsEvery = 3600;
    public $condition = "fup_uptime>=1000\nfup_data>=1000";
    public $action = "WISPr-Bandwidth-Max-Down=1000\nWISPr-Bandwidth-Max-Up=1000";


    public function savePolicy()
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
        ->where('id','<>',$this->policyId)
        ->select('id')
        ->first();

        if($existName) {
            return $this->addError('policyName', "Name Already Used!");
        }

        FairUsePolicy::query()
        ->where([
            'id' => $this->policyId
        ])->update([
            'name' => $this->policyName,
            'resets_every' => $this->resetsEvery,
            'action' => $this->action,
            'condition' => $this->condition
        ]);

        return redirect()->route('client.fairuse.list')->with([
            'type' => 'success',
            'message' => "Fair Use Policy Id#{$this->policyId} has been updated!"
        ]);

    }

    #[Computed()]
    public function policy()
    {
        return FairUsePolicy::query()
        ->where([
            'id' => $this->policyId
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
        $this->policyId = $id;

        if(!$this->policy) {
            return redirect()->route('client.fairuse.list')->with([
                'type' => 'danger',
                'message' => "Fair Use Policy Id#{$id} is not Exist!"
            ]);
        }

        $this->policyName = $this->policy->name;
        $this->resetsEvery = $this->policy->resets_every;
        $this->condition = $this->policy->condition;
        $this->action = $this->policy->action;
    }

    public function render()
    {
        return view('livewire.client.fair-use-policy.edit-fup')
        ->layout('components.layouts.app',[
            'pageName' => 'Fair Use Policy',
            'links' => ['Fair Use Policy', 'Edit', $this->policy->name]
        ]);
    }
}
