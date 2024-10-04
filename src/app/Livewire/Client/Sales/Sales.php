<?php

namespace App\Livewire\Client\Sales;

use App\Models\User;
use Livewire\Component;
use App\Models\SalesRecord;
use App\Traits\BasicHelper;
use App\Traits\RadiusHelper;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Sales extends Component
{
    use BasicHelper;
    use WithPagination;
    use RadiusHelper;
    
    protected $paginationTheme = 'bootstrap';

    #[Computed()]
    public function sales()
    {
        return SalesRecord::where([
            'user_id'   =>  $this->user->id
        ])
        ->paginate(20);
    }

    #[Computed()]
    public function user()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.client.sales.sales')
        ->layout('components.layouts.app',[
            'pageName' => 'Sales',
            'links' => ['Sales', 'Records']
        ]);
    }
}
