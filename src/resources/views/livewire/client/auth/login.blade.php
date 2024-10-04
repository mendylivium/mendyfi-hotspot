<div class="row">
    {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
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
                {{-- <hr>
                <a href="index.html" class="btn btn-google btn-user btn-block">
                    <i class="fab fa-google fa-fw"></i> Login with Google
                </a> --}}

            </form>
            <hr>
            {{-- <div class="text-center">
                <a class="small" href="{{ route('client.auth.register') }}" wire:navigate>Create an Account!</a>
            </div> --}}
        </div>
    </div>
</div>
