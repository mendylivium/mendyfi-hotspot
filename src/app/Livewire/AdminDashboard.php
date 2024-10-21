<?php

namespace App\Livewire;

use App\Models\Domain;
use App\Models\Tenant;
use App\Models\User;
use App\Traits\BasicHelper;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Orangehill\Iseed\Iseed;

class AdminDashboard extends Component
{

    use WithPagination;
    use BasicHelper;
    protected $paginationTheme = 'bootstrap';

    public function mount($id = null)
    {
        if($id) {
            $domain = Domain::find($id);
            $domain && $domain->successfully_created = true;
            $domain && $domain->save();
        }
        $tenants = Tenant::where(function($query) {
            $query->whereDoesntHave('domains')
                  ->orWhereHas('domains', function($subQuery) {
                      $subQuery->where('successfully_created', false);
                  });
        })->get();

        if($tenants->count()) {
            foreach ($tenants as $tenant) {
                $tenant->delete();
            }
            $iseed = new Iseed();
            $iseed->generateSeed('tenants', null, null, 'mysql');
            $iseed->generateSeed('domains', null, null, 'mysql');
        }
    }

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
        DB::beginTransaction();
        try {

        $domain = Domain::findOrFail($id);
        $tenant = Tenant::findOrFail($domain->tenant_id);
        $tenant->delete();
        $iseed = new Iseed();
        $iseed->generateSeed('tenants', null, null, 'mysql');
        $iseed->generateSeed('domains', null, null, 'mysql');
        DB::commit();

        $this->showFlash([
            'type'      =>  'warning',
            'message'   =>  "Reseller #{$id} Deleted!"
        ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to add domain: ' . $th->getMessage()]);
        }
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
