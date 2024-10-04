<div class="row">
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-info shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Earnings (Today)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($this->sales->earnToday, 2) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-success shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Earnings (Yesterday)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($this->sales->earnYesterday, 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-warning shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Earnings (This Week)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($this->sales->earnThisWeek, 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-danger shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Earnings (This Month)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($this->sales->earnThisMonth, 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-2">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            </div>
            <div class="card-body pt-0 px-1 text-xs">
                <div class="chart-area">
                    <canvas id="chartJs">Your browser does not support the canvas element.</canvas>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Stock Vouchers</h6>
                    </div>
                    <div class="card-body pt-0 px-0 text-xs">

                        <div class="table-responsive">
                            <table class="table-bordered table-striped table-sm" id="dataTable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr style="font-size:0.8rem;">
                                        <th>Name</th>
                                        <th>Stocks</th>
                                    </tr>
                                </thead>
                                <tbody class="text text-xs text-nowrap">
                                    @foreach ($this->vouchers as $voucher)
                                        <tr>
                                            <td>{{ $voucher->name }}</td>
                                            <td>{{ $voucher->stock }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            {{ $this->vouchers->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card bg-primary text-white shadow mb-2">
                    <div class="card-body">
                        <span class="text-xs"><b>Active Voucher</b></span>
                        <div class="text-white-50">{{ $this->user->active_vouchers }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card bg-success text-white shadow mb-2">
                    <div class="card-body">
                        <span class="text-xs"><b>Available Vouchers</b></span>
                        <div class="text-white-50">{{ $this->user->available_vouchers }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts-bottom')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        var salesGraph = null;
        $(function() {

            Chart.defaults.global.defaultFontFamily = 'Nunito',
                '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            function number_format(number, decimals, dec_point, thousands_sep) {
                // *     example: number_format(1234.56, 2, ',', ' ');
                // *     return: '1 234,56'
                number = (number + '').replace(',', '').replace(' ', '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }

            $.ajax({
                url: "{{ route('api.sales') }}",
                type: 'POST',
                success: function(data) {
                    const ctx = $('#chartJs');

                    console.log(data);

                    salesChart = new Chart(ctx, {
                        type: data.type,
                        data: {
                            labels: data.date_time,
                            datasets: [{
                                label: "Earnings",
                                lineTension: 0.3,
                                backgroundColor: "rgba(78, 115, 223, 0.05)",
                                borderColor: "rgba(78, 115, 223, 1)",
                                pointRadius: 3,
                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                                data: data.sales
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },

                            legend: {
                                display: false
                            },

                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem
                                            .datasetIndex].label || '';
                                        return datasetLabel + ': ' + (tooltipItem.yLabel);
                                    }
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
