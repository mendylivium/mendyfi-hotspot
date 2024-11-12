<div class="row">
    <div class="col-12">
        <x-partials.flash />
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Configuration</h6>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-6">
                        <div class="form-group">
                            <label class="text text-xs mb-0">RADIUS IP [PUBLIC / WAN]:</label>
                            <input type="text" wire:model="radiusPublicIP" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="text text-xs mb-0">RADIUS SECRET:</label>
                            <input type="text" class="form-control" value="{{ $this->user->api_secret }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text text-xs mb-0">Mikrotik Realm:</label>
                            <input type="text" wire:model="mktikRealm" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text text-xs mb-0">Other (NAS Identification):</label>
                            <input type="text" wire:model="otherRealm" class="form-control" readonly>
                        </div>
                    </div>

                </div>
                <span>
                    <b>Note:</b>If you are behind CGNAT, the IP {{ $radiusPublicIP }} may not work. You can use the
                    local IP of this system instead..
                </span>
            </div>
            <div class="card-footer">
                @php
                    $rand = rand(1111, 9999);
                @endphp
                <button class="btn btn-sm btn-warning"
                    wire:confirm.prompt="This will reject devices that uses the old Config. \n\nPlease type {{ $rand }} tp proceed|{{ $rand }}"
                    wire:click="recreate">
                    <li class="fas fa-sync-alt mr-1">
                    </li>
                    Recreate
                </button>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">External Portal</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <label class="text text-xs mb-0">TPLINK-EAP Stand Alone:</label>
                        <input type="text" class="form-control"
                            value="http://{{ $radiusPublicIP }}:8090/tplink-{{ $this->user->username }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">

        <form wire:submit.prevent="changeUserName">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between py-3">
                    <h6 class="m-0 text-primary">Change Username</h6>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text text-xs mb-0">UserName</label>
                                <input type="text" wire:model="userName" class="form-control">
                                @error('userName')
                                    <span class="text text-danger text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Current Password</label>
                                <input type="password" wire:model="currentPassword2" class="form-control">
                                @error('currentPassword2')
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
                        Change Username
                    </button>
                </div>
            </div>
        </form>

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
