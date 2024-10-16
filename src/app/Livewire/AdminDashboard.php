<?php

namespace App\Livewire;

use App\Models\Domain;
use App\Models\Tenant;
use App\Traits\BasicHelper;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class AdminDashboard extends Component
{

    use WithPagination;
    use BasicHelper;
    protected $paginationTheme = 'bootstrap';

    #[Computed()]
    public function  domain_counts()
    {
       return Tenant::whereHas('domains')->count();
    }

    #[Computed()]
    public function  domains()
    {
       return Domain::get();
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function delete($id)
    {
        $domain = Domain::findOrFail($id);
        $tenant = Tenant::findOrFail($domain->tenant_id);
        $tenant->delete();
        $this->showFlash([
            'type'      =>  'warning',
            'message'   =>  "Reseller #{$id} Deleted!"
        ]);
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard')
        ->layout('components.layouts.app',[
            'pageName' => 'Dashboard',
            'links' => ['Dashboard']
        ]);
    }
}
