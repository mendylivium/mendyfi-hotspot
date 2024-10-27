<div class="row">
    <div class="col-12">
        <x-partials.flash />
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Resellers</h6>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{ route('client.reseller.add') }}"><i
                            class="fas fa-plus mr-1"></i>Add Reseller</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" wire:model.live.debounce.500ms="searchStr" placeholder="Enter Name"
                            class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="font-size:0.8rem;">
                                <th>Id</th>
                                <th>Detail</th>
                                <th>Vouchers</th>
                                <th colspan="3">Sales</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse ($this->resellers as $reseller)
                                <tr class="text {{ $reseller->status != 'suspended' ?: 'text-danger' }}">
                                    <td>{{ $reseller->id }}</td>
                                    <td>
                                        <b>Name: </b> <span class="text-primary">{{ $reseller->name }}</span> <br />
                                        <b>Status: </b> <span class="text-primary">{{ $reseller->status }}</span>
                                    </td>
                                    <td>
                                        <b>Available: </b> <span
                                            class="text-primary">{{ $reseller->available_vouchers }}</span> </br>
                                        <b>Active: </b> <span
                                            class="text-primary">{{ $reseller->active_vouchers }}</span> </br>
                                    </td>
                                    <td>
                                        <b>Today:</b> <span
                                            class="text-primary">{{ number_format($reseller->earnToday, 2) }}</span>
                                        <br />
                                        <b>Yesterday:</b> <span
                                            class="text-primary">{{ number_format($reseller->earnYesterday, 2) }}</span>
                                    </td>
                                    <td>
                                        <b>This Week:</b> <span
                                            class="text-primary">{{ number_format($reseller->earnThisWeek, 2) }}</span>
                                        <br />
                                        <b>This Month:</b> <span
                                            class="text-primary">{{ number_format($reseller->earnThisMonth, 2) }}</span>
                                    </td>
                                    <td>
                                        <b>Last Month:</b> <span
                                            class="text-primary">{{ number_format($reseller->earnLastMonth, 2) }}</span>
                                        <br />
                                        <b>Total:</b> <span
                                            class="text-primary">{{ number_format($reseller->total_sales, 2) }}</span>
                                    </td>
                                    <td style="width:5px;">
                                        <div class="btn-group btn-group-sm d-flex justify-content-center">
                                            <a href="{{ route('client.reseller.edit', $reseller->id) }}"
                                                class="btn btn-info btn-sm"><i class="fa fas fa-edit mr-2"></i>Edit</a>
                                            <button class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $reseller->id }})"
                                                wire:confirm.prompt="Are you sure?\nThis will delete also all vouchers under this reseller\n\nType {{ $reseller->id }} to confirm|{{ $reseller->id }}"><i
                                                    class="fas fa-trash mr-2"></i>Delete</button>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">NO REGISTERED RESELLER</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    {{ $this->resellers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
