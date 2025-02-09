<div class="content">
    @if (session()->has('error'))
        <div class="alert alert-solid-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                    class="fas fa-xmark"></i></button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-solid-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                    class="fas fa-xmark"></i></button>
        </div>
    @endif
    <div class="page-header">
        <div class="page-title">
            <h4>Profile</h4>
            <h6>User Profile</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="profile-set">
                <div class="profile-head p-3">
                    <div class="">
                        <h2 class="text-white">Hi, Welcome {{ Auth::user()->name }}</h2>
                    </div>
                </div>
                <div class="profile-top">
                    <div class="profile-content">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="input-blocks">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" wire:model="name" />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="input-blocks">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" wire:model="email" />
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="input-blocks">
                        <label>Phone</label>
                        <input type="number" class="form-control" wire:model="phone" />
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="input-blocks">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" wire:model="address" />
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="input-blocks">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" wire:model="username" />
                        @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="input-blocks">
                        <label class="form-label">Password</label>
                        <div class="pass-group">
                            <input type="password" class="form-control" wire:model="password" />
                            <span class="fas toggle-password fa-eye-slash"></span>
                        </div>
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-12">
                    <button type="button" wire:click="updateProfile" class="btn btn-submit me-2">Save Profile</button>
                </div>
            </div>
        </div>
    </div>
</div>
