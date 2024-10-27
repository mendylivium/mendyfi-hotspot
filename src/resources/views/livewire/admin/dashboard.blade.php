<div class="row">
    <div class="col-12">
        <x-partials.flash />
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card border-info shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $this->info }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Users</h6>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.adduser') }}"><i
                            class="fas fa-plus mr-1"></i>Add User</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" wire:model.live.debounce.500ms="searchStr"
                            placeholder="Enter UserName, ID or Domain" class="form-control">
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse($this->myTenants as $tenant)
                                <tr>
                                    <td>{{ $tenant->id }}</td>
                                    <td>{{ $tenant->username }}</td>
                                    <td>{{ $tenant->domain }}</td>
                                    <td>{{ $tenant->status }}</td>
                                    <td style="min-width: 170px;width: 180px;">
                                        <div class="d-flex justify-content-center align-item-center">
                                            <div class="btn-group">

                                                <div class="btn-group">
                                                    <a class="btn btn-sm btn-info shadow"
                                                        href="{{ route('admin.edituser', $tenant->id) }}"><i
                                                            class="fas fa-edit mr-2"></i>Edit</a>
                                                    <button class="btn btn-sm btn-danger shadow"
                                                        wire:confirm.prompt="Are you sure?\n\nType {{ substr($tenant->id, -2) }} to confirm|{{ substr($tenant->id, -2) }}"
                                                        wire:click="deleteTenant('{{ $tenant->id }}')"><i
                                                            class="fas fa-trash mr-2"></i>Delete</button>
                                                </div>
                                            </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">NO USER FOUND</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                <div class="d-flex justify-content-end mt-4">
                    {{ $this->myTenants->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
