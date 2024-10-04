<div class="row">
    <div class="col-md-8 order-md-1">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Add Reseller</h6>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="addReseller">
                    <div class="form-group">
                        <label class="text text-xs mb-0">Full Name:</label>
                        <input type="text" wire:model="resellerName"
                            class="form-control"placeholder="Enter Reseller Name" autocomplete="off">
                        @error('resellerName')
                            <span class="text text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="text text-xs mb-0">Address:</label>
                        <input type="text" wire:model="resellerAddress"
                            class="form-control"placeholder="Enter Addess" autocomplete="off">
                        @error('resellerAddress')
                            <span class="text text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Contact Number:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:model="resellerMobile"
                                        placeholder="Enter Mobile No.">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <li class="fas fa-mobile"></li>
                                        </span>
                                    </div>
                                </div>
                                @error('resellerMobile')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Contact Email:</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" wire:model="resellerEmail"
                                        placeholder="Enter Email">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <li class="fas fa-at"></li>
                                        </span>
                                    </div>
                                </div>
                                @error('resellerEmail')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Status:</label>
                                <select class="form-control wire" wire:model="resellerStatus">
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    @error('otherError')
                        <span class="text text-xs text-danger">{{ $message }}</span>
                    @enderror
                    <hr>
                    <div class="d-flex justify-content-start">
                        <a class="btn btn-secondary mr-2" href="{{ route('client.reseller.list') }}">Cancel</a>
                        <button class="btn btn-primary" type="submit">Add Reseler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
