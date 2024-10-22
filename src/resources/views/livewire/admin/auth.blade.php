<div class="row">
    {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Mendyfi | Admin Page</h1>
            </div>
            <form wire:submit.prevent="login">
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" placeholder="Username"
                        wire:model="username">
                    @error('username')
                        <span class="text text-xs text-block text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-user" wire:model="password"
                        placeholder="Password">
                    @error('password')
                        <span class="text text-xs text-block text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-primary btn-user btn-block" type="submit">
                    <span wire:loading>
                        <li class="spinner-border spinner-border-sm"></li>
                    </span>
                    <span wire:loading.attr="hidden">Login</span>

                </button>
            </form>
            <hr>
            <div class="d-flex justify-content-center items-center">
                <span class="text-xs">Copyright &copy; 2024 | Developed by <a href="//fb.me/mendylivium"
                        target="_blank">Rommel
                        Mendiola</a></span>
            </div>

        </div>
    </div>
</div>
