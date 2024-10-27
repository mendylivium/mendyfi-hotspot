<div class="row">
    <div class="col-12">
        <x-partials.flash />
    </div>
    <div class="col-lg-6">
        <form wire:submit.prevent="editSettings">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between py-3">
                    <h6 class="m-0 text-primary">Configuration</h6>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label class="text text-xs mb-0">Radius Interim</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model="radiusInterim" placeholder="Seconds">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    Seconds
                                </span>
                            </div>
                        </div>
                        @error('radiusInterim')
                            <span class="text text-xs text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <span>
                        <b>INTERIM UPDATE</b>: This configuration determines the frequency at which your router, modem,
                        or
                        NAS will send updates to the RADIUS server.<br /><br />
                        <b>Note:</b> If your system has limited CPU or RAM resources, it's recommended to set a higher
                        interval, especially if you're expecting a large number of hotspot users.
                    </span>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-warning">
                        <li class="fas fa-sync-alt mr-1">
                        </li>
                        Apply Update
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-6">
        <form wire:submit.prevent="changePass">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between py-3">
                    <h6 class="m-0 text-primary">Change Password</h6>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Current Password</label>
                                <input type="password" wire:model="currentPassword" class="form-control">
                                @error('currentPassword')
                                    <span class="text text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="text text-xs mb-0">New Password</label>
                                <input type="password" wire:model="password" class="form-control">
                                @error('password')
                                    <span class="text text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Confirm New Password</label>
                                <input type="password" wire:model="password_confirmation" class="form-control">
                                @error('password_confirmation')
                                    <span class="text text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @error('otherError')
                        <span class="text text-danger text-xs">{{ $message }}</span>
                    @enderror

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-warning">
                        <li class="fas fa-sync-alt mr-1">
                        </li>
                        Change Pass
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
