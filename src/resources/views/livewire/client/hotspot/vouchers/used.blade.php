<div class="row">
    <div class="col-12">
        <x-partials.flash />
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Hotspot Vouchers</h6>
                <div class="card-tools d-flex gap-2">
                    <input wire:model.live="search" type="text" class="form-control form-control-sm"
                        placeholder="Search vouchers..." style="width: 200px;">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="font-size:0.8rem;">
                                <th>Voucher Info</th>
                                <th>Session</th>
                                <th>Credit Balance</th>
                                <th>Dates</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse ($this->vouchers as $voucher)
                                <tr>
                                    <td>
                                        <b>Code: </b> <span class="text text-info">{{ $voucher->code }}</span><br />
                                        <b>Profile: </b> {{ $voucher->profile_name }}<br />
                                        <b>Price: </b> {{ $voucher->price }}
                                    </td>
                                    <td>
                                        <b>{{ $this->isRandomMac($voucher->mac_address) ? 'Random ' : '' }}Mac
                                            Address: </b> {{ $voucher->mac_address ?? 'N/A' }} <br />
                                        <b>Device IP: </b> {{ $voucher->ip_address ?? 'N/A' }} <br />
                                        <b>Router IP: </b>
                                        {{ $voucher->router_ip ?? 'N/A' }}{{ $voucher->server_name ? " - {$voucher->server_name}" : '' }}
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">NO RECORD OF USED VOUCHER</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    {{ $this->vouchers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
