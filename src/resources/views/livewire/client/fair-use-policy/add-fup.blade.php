<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Create Policy</h6>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="createPolicy">
                    <div class="row">

                        <div class="col-8">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Policy Name:</label>
                                <input type="text" wire:model="policyName"
                                    class="form-control"placeholder="Enter Profile Name" autocomplete="off">
                                @error('policyName')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text text-xs mb-0">Resets Every (Minutes):</label>
                                <input type="number" wire:model="resetsEvery" class="form-control"placeholder="Seconds"
                                    autocomplete="off">
                                @error('resetsEvery')
                                    <span class="text text-xs text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between py-3">
                                    <h6 class="m-0 text-primary">Condition</h6>
                                    <div class="card-tools">
                                        {{-- <a class="btn btn-sm btn-primary" href="{{ route('client.voucher.generate') }}"><i
                                                    class="fas fa-plus mr-1"></i>Generate</a> --}}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="text text-xs">Please Use this, <span
                                            class="text text-info">Attributes</span></p>
                                    <ul>
                                        <li class="text text-xs"><span class="text-info">"total_uptime"</span> total
                                            session time of user</li>
                                        <li class="text text-xs"><span class="text-info">"total_data"</span> total data
                                            used by user</li>
                                        <li class="text text-xs"><span class="text-info">"fup_uptime"</span> total
                                            session time of user, will resets when any of FUP bind to a profile resets
                                        </li>
                                        <li class="text text-xs"><span class="text-info">"fup_data"</span> total data
                                            used by user, will resets when any of FUP bind to a profile resets</li>
                                    </ul>
                                    <textarea wire:model="condition" cols="30" rows="10" class="form-control"></textarea>
                                    @error('condition')
                                        <span class="text text-xs text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between py-3">
                                    <h6 class="m-0 text-primary">Action</h6>
                                    <div class="card-tools">
                                        {{-- <a class="btn btn-sm btn-primary" href="{{ route('client.voucher.generate') }}"><i
                                                    class="fas fa-plus mr-1"></i>Generate</a> --}}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="text text-xs">Please Use, <span class="text text-info">Radius
                                            Attributes</span></p>
                                    <textarea wire:model="action" cols="30" rows="10" class="form-control"></textarea>
                                    @error('action')
                                        <span class="text text-xs text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                    </div>


                    @error('otherError')
                        <span class="text text-xs text-danger">{{ $message }}</span>
                    @enderror
                    <hr>
                    <div class="d-flex justify-content-start">
                        <a class="btn btn-secondary mr-2" href="{{ route('client.fairuse.list') }}">Cancel</a>
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
