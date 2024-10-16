<div class="row">
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-info shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Domains</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $this->domain_counts }}
                        </div>
                    </div>
                    <div class="col-auto">
                        {{-- <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Domains</h6>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.domain.add') }}"><i
                            class="fas fa-plus mr-1"></i>Add Domain</a>
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
                                <th>User Name</th>
                                <th>Domain</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse ($this->domains as $domain)
                                <tr class="text">
                                    <td>{{ $domain->id }}</td>
                                    <td><b>{{ $domain->user_name }}</b></td>
                                    <td>{{$domain->domain}}</td>
                                    <td style="width:5%;">
                                        <div class="btn-group btn-group-sm d-flex justify-content-center">
                                            {{-- <a href="" class="btn btn-info btn-sm">
                                                <i class="fas fa-edit mr-2"></i>Edit
                                            </a> --}}
                                            <button class="btn btn-danger btn-sm"
                                                    wire:click="delete({{ $domain->id }})"
                                                    wire:confirm.prompt="Are you sure?\nThis will delete also all vouchers under this reseller\n\nType {{ $domain->id }} to confirm|{{ $domain->id }}">
                                                <i class="fas fa-trash mr-2"></i>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">NO REGISTERED Domain</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                <div class="d-flex justify-content-end mt-4">
                    {{-- {{ $this->resellers->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row"> --}}
{{-- </div> --}}

@push('scripts-bottom')

@endpush
