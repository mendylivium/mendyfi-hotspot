<div class="container">
    <div class="d-flex justify-content-center align-middle">
        <div class="row">
            <div class="col-4 col-lg-8 mr-a">

                <div class="card box-shadow">
                    <div class="card-header bg-primary">
                        <marquee direction="left" height="100%">
                            <h3>{{ $portalTitle }}</h3>
                        </marquee>
                    </div>
                    <div class="card-body">
                        <div wire:loading class="text-center">
                            Please Wait ...
                        </div>
                        <form wire:submit.prevent="verify" wire:loading.remove>
                            <div class="row">
                                <div class="col-12">
                                    <input class="form-control-md plch-center" style="margin-bottom: 1em; width: 100%;"
                                        type="text" placeholder="Voucher" wire:model="code" />

                                </div>
                                @if (request()->has('pass'))
                                    <div class="col-12">
                                        <input class="form-control-md plch-center"
                                            style="margin-bottom: 1em;width: 100%;" name="password"
                                            placeholder="Password" />
                                    </div>
                                @endif
                                <div class="col-12">
                                    <button type="submit" class="btn btn-md bg-success pd-5"
                                        style="margin-bottom: 0.5em;width: 100%;">Connect</button>
                                </div>
                            </div>




                            @if ($errors->any())
                                <hr>
                                <div class="alert bg-danger text-center" style="margin-bottom: 0.5em;padding-top:3px">
                                    <span id="err_text">{{ $errors->first() }}</span>
                                </div>
                            @endif
                        </form>

                    </div>
                </div>
                <div class="card box-shadow">
                    <div class="card-header bg-warning">
                        <h3>WIFI RATES</h3>
                    </div>
                    <table id="customers" align="center" border="1">
                        <tr>
                            <th>
                                <h3>PRICE</h3>
                            </th>
                            <th>
                                <h3>TIME</h3>
                            </th>
                        </tr>

                        @foreach ($this->rates as $rate)
                            <tr>
                                <td>{{ $rate->name }}</td>
                                <td>{{ number_format($rate->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div style="color:#FFF;">
                    <center>
                        &copy; 2024 - Powered by Mendyfi<br />
                    </center>
                </div>
            </div>
        </div>
    </div>
    <form id="form" method="post" action="//{{ request()->get('target') }}/portal/auth" hidden>
        <input type="text" name="username" wire:model="code" />
        <input type="password" name="password" wire:model="password" />
        <input type="text" id="cid" name="clientMac" value="{{ request()->get('clientMac') }}" />
    </form>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('submit', data => {
                form.submit();
            });
        });
    </script>
</div>
