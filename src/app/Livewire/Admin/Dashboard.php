<?php

namespace App\Livewire\Admin;

use App\Models\Tenant;
use Livewire\Component;
use App\Traits\BasicHelper;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Dashboard extends Component
{
    use WithPagination;
    use BasicHelper;

    public $searchStr = '';

    public function deleteTenant($id)
    {
        $tenant = Tenant::find($id);

        $tenant->delete();

        $this->showFlash([
            'type' => 'warning',
            'message' => 'Tenant Deleted!'
        ]);
    }

    #[Computed()]
    public function info()
    {
        return Tenant::whereHas('domains')->count();
    }

    #[Computed()]
    public function myTenants()
    {
        return Tenant::query()
        ->leftJoin('domains','tenants.id','domains.tenant_id')
        ->select('tenants.*', 'domains.domain', 'domains.username', 'domains.status')
        ->where(function($query){
            if(!empty($this->searchStr)) {
                $query->orWhere('domains.username','like',"%{$this->searchStr}%");
                $query->orWhere('domains.domain','like',"%{$this->searchStr}%");
            }
        })
        ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
        ->layout('components.layouts.app',[
            'pageName' => 'My Users',
            'links' => ['Users', 'List']
        ]);
    }
}
