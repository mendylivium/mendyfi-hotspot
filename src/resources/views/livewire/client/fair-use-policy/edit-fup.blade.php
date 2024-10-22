<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between py-3">
                <h6 class="m-0 text-primary">Edit Policy</h6>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="savePolicy">
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
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
