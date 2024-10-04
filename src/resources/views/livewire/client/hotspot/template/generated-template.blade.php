<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Vouchers Templates</h6>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{ route('client.voucher.template.create') }}"><i
                            class="fas fa-plus mr-1"></i>Create</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="font-size:0.8rem;">
                                <th>Name</th>
                                <th>Created On</th>
                                <th>Updated On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse ($this->templates as $template)
                                <tr>
                                    <td>
                                        {{ $template->name }}
                                    </td>
                                    <td>
                                        {{ $template->created_at }}
                                    </td>
                                    <td>
                                        {{ $template->updated_at }}
                                    </td>
                                    <td style="min-width: 170px;width: 180px;">
                                        <div class="d-flex justify-content-center align-item-center">
                                            <div class="btn-group">

                                                <a href="{{ route('client.voucher.template.edit', $template->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <li class="fas fa-edit mr-1"></li>Edit
                                                </a>
                                                <button class="btn btn-sm btn-danger shadow"
                                                    wire:confirm.prompt="Are you sure?\n\nType {{ $template->id }} to confirm|{{ $template->id }}"
                                                    wire:click="deleteTemplate({{ $template->id }})"><i
                                                        class="fas fa-trash mr-2"></i>Delete</button>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">NO TEMPLATES CREATED</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    {{ $this->templates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
