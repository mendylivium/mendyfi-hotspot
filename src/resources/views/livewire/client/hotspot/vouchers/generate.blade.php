<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Generate Hotspot Vouchers</h6>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="generate">
                    <div class="row">

                        <div class="col-12">

                            <div class="form-group">
                                <label class="text text-xs mb-0">Select Reseller (optional):</label>
                                <div class="input-group">
                                    <select wire:model="resellerId" class="form-control">
                                        <option value="0">- None -</option>
                                        @foreach ($this->resellers as $reseller)
                                            <option value="{{ $reseller->id }}">{{ $reseller->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <a href="{{ route('client.reseller.list') }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                @error('resellerId')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <hr>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Voucher Code Prefix:</label>
                                <input type="text" wire:model="voucherPrefix"
                                    class="form-control"placeholder="Enter Voucher Prefix" autocomplete="off">
                                @error('voucherPrefix')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Character Pattern:</label>
                                <select wire:model="voucherPattern" class="form-control">
                                    <option value="1">ABCD1234</option>
                                    <option value="2">abcd1234</option>
                                    <option value="3">ABCDEFGH</option>
                                    <option value="4">abcdefgh</option>
                                    <option value="5">abcdEFGH</option>
                                    <option value="6">12345678</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Character Length:</label>
                                <input type="number" wire:model="voucherPatternLength"
                                    class="form-control"placeholder="Enter Character Length" autocomplete="off">
                                @error('voucherPatternLength')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Password Pattern:</label>
                                <select wire:model="passwordPattern" class="form-control">
                                    <option value="0">NO PASSWORD</option>
                                    <option value="1">ABCD1234</option>
                                    <option value="2">abcd1234</option>
                                    <option value="3">ABCDEFGH</option>
                                    <option value="4">abcdefgh</option>
                                    <option value="5">abcdEFGH</option>
                                    <option value="6">12345678</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Password Length:</label>
                                <input type="number" wire:model="voucherPasswordLength"
                                    class="form-control"placeholder="Enter Character Length" autocomplete="off">
                                @error('voucherPasswordLength')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Profile:</label>
                                <div class="input-group">

                                    <select wire:model="voucherProfile" class="form-control">
                                        <option value="0">- Select -</option>
                                        @foreach ($this->profiles as $profile)
                                            <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <a href="{{ route('client.vouchers.profiles') }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                @error('voucherProfile')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Quantity:</label>
                                <input type="number" wire:model="voucherQty"
                                    class="form-control"placeholder="Enter Character Length" autocomplete="off">
                                @error('voucherQty')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @error('otherError')
                        <span class="text text-xs text-danger">{{ $message }}</span>
                    @enderror
                    <hr>
                    <div class="d-flex justify-content-start">
                        <a class="btn btn-secondary mr-2" href="{{ route('client.vouchers.list') }}">Cancel</a>
                        <button class="btn btn-primary" type="submit">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
