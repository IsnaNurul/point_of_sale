<div>
    <form wire:submit.prevent="saveSupplier">
        <div class="row">
            <div class="mb-3 col-md-12">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" wire:model="name" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" wire:model="username" />
                @error('username')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" wire:model="password" />
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Phone Number</label>
                <input type="number" class="form-control" wire:model="phone" />
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" wire:model="email" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" wire:model="address" id="" cols="30" rows="5"></textarea>
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="modal-footer-btn">
            <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-submit">
                {{ $supplierId ? 'Update Supplier' : 'Create Supplier' }}
            </button>
        </div>
    </form>
</div>
