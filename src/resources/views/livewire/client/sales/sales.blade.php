<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Hotspot Sales Report</h6>
                <div class="card-tools">
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('client.voucher.generate') }}"><i
                            class="fas fa-plus mr-1"></i>Generate</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-striped table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="font-size:0.8rem;">
                                <th>Voucher Code</th>
                                <th>Session</th>
                                <th>Price</th>
                                <th>Transact Date</th>
                            </tr>
                        </thead>
                        <tbody class="text text-xs text-nowrap">
                            @forelse ($this->sales as $sale)
                                <tr>
                                    <td>
                                        {{ $sale->code }}
                                    </td>
                                    <td>
                                        <b>{{ $this->isRandomMac($sale->mac_address) ? 'Random ' : '' }}Mac
                                            Address: </b> {{ $sale->mac_address ?? 'N/A' }} <br />
                                        <b>Device IP: </b> {{ $sale->ip_address ?? 'N/A' }} <br />
                                        <b>Router IP: </b>
                                        {{ $sale->router_ip ?? 'N/A' }}{{ $sale->server_name ? " - {$sale->server_name}" : '' }}
                                    </td>
                                    <td>
                                        {{ number_format($sale->amount, 2) }}
                                    </td>
                                    <td>
                                        {{ Illuminate\Support\Carbon::parse($sale->transact_date)->format('M d, Y h:i:s A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">NO RECORDS</td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-4">

                </div>
            </div>
        </div>
    </div>
</div>
