<div>
    <div class="row">
        <div class="col-12">
            <x-partials.flash />
        </div>
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between py-3">
                    <h6 class="m-0 text-primary">Generated Vouchers</h6>
                    <div class="card-tools d-flex">
                        <input wire:model.live="searchVC" type="text" class="form-control form-control-sm mr-2"
                            placeholder="Search vouchers..." style="width: 200px;">
                        <a class="btn btn-sm btn-primary" href="{{ route('client.voucher.generate') }}">
                            <i class="fas fa-plus mr-1"></i>Generate
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-bordered table-striped table-sm" id="dataTable" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr style="font-size:0.8rem;">
                                    <th>Voucher Info</th>
                                    <th>Credit</th>
                                    <th>Generated</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text text-xs text-nowrap">
                                @forelse ($this->vouchers as $voucher)
                                    <tr>
                                        <td>
                                            <b>Code: </b> <span class="text text-info">{{ $voucher->code }}</span><br />
                                            @if(!empty($voucher->password))
                                            <b>Password: </b> <span class="text text-info">{{ $voucher->password }}</span><br />
                                            @endif
                                            <b>Profile: </b> <span
                                                class="text-primary">{{ $voucher->profile_name }}</span><br />
                                        </td>
                                        <td>
                                            <b>Data: </b><span class="text-primary">
                                                {{ $voucher->data_limit > 0 ? "{$this->convertBytes($voucher->data_limit)}" : 'Unlimited' }}</span><br />
                                            <b>Time: </b><span class="text-primary">
                                                {{ $voucher->uptime_limit > 0 ? "{$this->convertSeconds($voucher->uptime_limit)}" : 'Unlimited' }}</span><br />
                                        </td>
                                        <td>
                                            {{ Illuminate\Support\Carbon::parse($voucher->generation_date)->setTimezone(env('APP_TIMEZONE'))->format('M d, Y h:i:s A') }}
                                        </td>
                                        <td>
                                            {{ number_format($voucher->price, 2) }}
                                        </td>
                                        <td style="min-width: 170px;width: 180px;">
                                            <div class="d-flex justify-content-center align-item-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-danger shadow"
                                                        wire:confirm.prompt="Are you sure?\nThis will delete also all generated voucher with this profile\n\nType {{ $voucher->id }} to confirm|{{ $voucher->id }}"
                                                        wire:click="deleteVoucher({{ $voucher->id }})"><i
                                                            class="fas fa-trash mr-2"></i>Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">NO VOUCHER AVAILABLE</td>
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

        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between py-3">
                    <h6 class="m-0 text-primary">Vouchers by Batch</h6>
                    <div class="card-tools d-flex">
                        <input wire:model.live="searchBATCH" type="text" class="form-control form-control-sm mr-2"
                            placeholder="Search Batch..." style="width: 200px;">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-bordered table-striped table-sm" id="dataTable" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr style="font-size:0.8rem;">
                                    <th>Batch Code</th>
                                    <th>Profile Name</th>
                                    <th>Reseller</th>
                                    <th>Generation Date</th>
                                    <th>Price</th>
                                    <th>Qty.</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text text-xs text-nowrap">
                                @forelse ($this->batches as $batch)
                                    <tr>
                                        <td>
                                            {{ $batch->batch_code }}
                                        </td>
                                        <td>
                                            {{ $batch->name }}
                                        </td>
                                        <td>
                                            {{ $batch->reseller_name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ Illuminate\Support\Carbon::parse($batch->generation_date)->setTimezone(env('APP_TIMEZONE'))->format('M d, Y h:i:s A') }}
                                        </td>
                                        <td>
                                            {{ number_format($batch->price, 2) }}
                                        </td>
                                        <td>
                                            {{ $batch->count }}
                                        </td>
                                        <td style="min-width: 170px;width: 180px;">
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-sm"
                                                    x-on:click="showVoucherTemplate({{ $batch->batch_code }})">
                                                    <li class="fas fa-print mr-1"></li>Print
                                                </button>
                                                <button class="btn btn-danger btn-sm"
                                                    wire:confirm.prompt="Are you sure?\n\nType {{ substr($batch->batch_code, -5) }} to confirm|{{ substr($batch->batch_code, -5) }}"
                                                    wire:click="deleteBatch({{ $batch->batch_code }})">
                                                    <li class="fas fa-trash mr-1"></li>Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">NO VOUCHER BATCH AVAILABLE</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $this->batches->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="print-voucher-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Print Vouchers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Voucher Template</label>
                                <select id="print_template" class="form-control">
                                    <option value="0">Default</option>
                                    @foreach ($this->templates as $template)
                                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="print-btn"
                        onclick="printBatchNow()">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts-bottom')
    <script>
        let selectedBatch = null;

        function showVoucherTemplate(batch) {
            selectedBatch = batch;
            $('#print-voucher-form').modal('show');
        }

        function printBatchNow() {
            const voucherTemplate = $('#print_template').val();
            window.open('print?batch=' + selectedBatch + '&template=' + voucherTemplate);
        }
    </script>
@endpush
