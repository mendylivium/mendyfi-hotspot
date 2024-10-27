<div class="row">
    <div class="col-12">
        <x-partials.flash />
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Hotspot Profiles</h6>
                <div class="card-tools">
                    <a class="btn btn-sm btn-primary" href="{{ route('client.vouchers.profile.create') }}"><i
                            class="fas fa-plus mr-1"></i>Create</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="font-size:0.8rem;">
                                <th>Profile Information</th>
                                <th>Bandwidth</th>
                                <th>Limits</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse ($this->profiles as $profile)
                                <tr>
                                    <td>
                                        <b>Name: </b><span class="text-primary">{{ $profile->name }}</span><br />
                                        <b>Description: </b><span
                                            class="text-primary">{{ $profile->description }}</span><br />
                                        <b>Price: </b><span
                                            class="text-primary">{{ $profile->price == 0 ? 'Free' : $profile->price }}</span>
                                    </td>
                                    <td>
                                        <b>Max Upload:
                                        </b><span
                                            class="text-primary">{{ $profile->max_upload >= 1 ? "{$this->convertBytes($profile->max_upload)}ps" : 'Unlimited' }}</span><br />
                                        <b>Max Download:
                                        </b><span
                                            class="text-primary">{{ $profile->max_download >= 1 ? "{$this->convertBytes($profile->max_download)}ps" : 'Unlimited' }}</span>
                                    </td>
                                    <td>
                                        <b>Data Limit:
                                        </b><span
                                            class="text-primary">{{ $profile->data_limit >= 1 ? "{$this->convertBytes($profile->data_limit)}" : 'Unlimited' }}</span><br />
                                        <b>Uptime Limit:
                                        </b><span
                                            class="text-primary">{{ $profile->uptime_limit >= 1 ? "{$this->convertSeconds($profile->uptime_limit)}" : 'None' }}</span><br />
                                        <b>Validity:
                                        </b><span
                                            class="text-primary">{{ $profile->validity >= 1 ? "{$this->convertSeconds($profile->validity)}" : 'None' }}</span>
                                    </td>
                                    <td style="min-width: 170px;width: 180px;">
                                        <div class="d-flex justify-content-center align-item-center">
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-info shadow"
                                                    href="{{ route('client.vouchers.profile.edit', $profile->id) }}"><i
                                                        class="fas fa-edit mr-2"></i>Edit</a>

                                                <button class="btn btn-sm btn-danger shadow"
                                                    wire:confirm.prompt="Are you sure?\nThis will delete also all generated voucher with this profile\n\nType {{ $profile->id }} to confirm|{{ $profile->id }}"
                                                    wire:click="deleteProfile({{ $profile->id }})"><i
                                                        class="fas fa-trash mr-2"></i>Delete</button>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">NO PROFILE</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    {{ $this->profiles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
