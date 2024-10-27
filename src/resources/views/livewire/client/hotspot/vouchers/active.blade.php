<div class="row">
    <div class="col-12">
        <x-partials.flash />
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Hotspot Vouchers</h6>
                <div class="card-tools">
                    <input wire:model.live="search" type="text" class="form-control form-control-sm"
                        placeholder="Search active vouchers..." style="width: 200px;">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="font-size:0.8rem;">
                                <th>Voucher Info</th>
                                <th colspan="2">Session</th>
                                <th>Credit Balance</th>
                                <th>Dates</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse ($this->voucher as $voucher)
                                <tr>
                                    <td>
                                        <b>Code: </b> <span class="text text-info">{{ $voucher->code }}</span><br />
                                        <b>Profile: </b> <span
                                            class="text-primary">{{ $voucher->profile_name }}</span><br />
                                        <b>Price: </b> <span class="text-primary">{{ $voucher->price }}</span>
                                    </td>
                                    <td>
                                        <b>{{ $this->isRandomMac($voucher->mac_address) ? 'Random ' : '' }}Mac
                                            Address: </b> {{ $voucher->mac_address ?? 'N/A' }} <br />
                                        <b>Device IP: </b> {{ $voucher->ip_address ?? 'N/A' }} <br />
                                        <b>Router IP: </b>
                                        {{ $voucher->router_ip ?? 'N/A' }}{{ $voucher->server_name ? " - {$voucher->server_name}" : '' }}
                                    </td>
                                    <td>
                                        <b>Download: </b> {{ $this->convertBytes($voucher->session_download) }} <br>
                                        <b>Upload: </b> {{ $this->convertBytes($voucher->session_upload) }}
                                    </td>
                                    <td>
                                        <b>Data: </b>
                                        {{ $voucher->data_limit > 0 ? "{$this->convertBytes($voucher->data_credit)}" : 'Unlimited' }}<br />
                                        <b>Time: </b>
                                        {{ $voucher->uptime_limit > 0 ? "{$this->convertSeconds($voucher->uptime_credit)}" : 'Unlimited' }}<br />
                                    </td>
                                    <td>
                                        <b>Generated: </b>
                                        {{ Illuminate\Support\Carbon::parse($voucher->generation_date)->format('M d, Y h:i:s A') }}
                                        <br />
                                        <b>Used On: </b>
                                        {{ $voucher->used_date ? Illuminate\Support\Carbon::parse($voucher->used_date)->format('M d, Y h:i:s A') : 'Not Yet' }}
                                        <br />
                                        <b>Expired On: </b>
                                        {{ $voucher->used_date ? Illuminate\Support\Carbon::parse($voucher->expire_date)->format('M d, Y h:i:s A') : 'Not Yet' }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-danger"
                                                wire:confirm.prompt="Are you sure?\n\nType {{ substr($voucher->id, -5) }} to confirm|{{ substr($voucher->id, -5) }}"
                                                wire:click="disconnect({{ $voucher->id }})"><i
                                                    class="fas fa-ban mr-2"></i>Disconnect</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">NO ACTIVE VOUCHERS/USER FOUND</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    {{ $this->voucher->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
