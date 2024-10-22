<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Policies</h6>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{ route('client.fairuse.add') }}"><i
                            class="fas fa-plus mr-1"></i>Add Policy</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="font-size:0.8rem;">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Resets</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse ($this->policies as $policy)
                                <tr>
                                    <td>{{ $policy->id }}</td>
                                    <td>{{ $policy->name }}</td>
                                    <td>{{ $policy->resets_every }} Mins</td>
                                    <td style="min-width: 170px;width: 180px;">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('client.fairuse.edit', $policy->id) }}"
                                                class="btn btn-info">
                                                <li class="fas fa-edit mr-2"></li>Edit
                                            </a>
                                            <button class="btn btn-danger" wire:click="delete({{ $policy->id }})">
                                                <li class="fas fa-trash mr-2"></li>Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">NO FUP</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
