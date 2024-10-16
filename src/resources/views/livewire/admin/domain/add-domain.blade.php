<div class="row">
    <div class="col-md-8 order-md-1">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Add Domain</h6>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="addDomain">
                    <div class="form-group">
                        <label class="text text-xs mb-0">User Name:</label>
                        <input type="text" wire:model="userName"
                            class="form-control"placeholder="Enter User Name" autocomplete="off">
                        @error('userName')
                            <span class="text text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="text text-xs mb-0">Password:</label>
                        <input type="password" wire:model="password"
                            class="form-control"placeholder="Enter Password" autocomplete="off">
                        @error('password')
                            <span class="text text-xs text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Domain Name:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" wire:model="domainName"
                                        placeholder="Enter Domain Name">
                                </div>
                                @error('domainName')
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
                        <a class="btn btn-secondary mr-2" href="{{ route('admin.dashboard') }}">Cancel</a>
                        <button class="btn btn-primary" type="submit">Add Domain</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
