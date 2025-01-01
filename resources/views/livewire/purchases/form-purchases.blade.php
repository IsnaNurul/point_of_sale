<div>
    <form wire:submit.prevent="saveDiscount">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" wire:model="name" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Code</label>
                <input type="text" class="form-control" wire:model="code" />
                @error('code')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Code</label>
                <select class="form-select" id="type" wire:model="type" required>
                    <option value="" selected>--- Select Type ---</option>
                    <option value="percent">Percent</option>
                    <option value="fixed">Fixed</option>
                </select>
                @error('type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" wire:model="description" id="" cols="30" rows="5"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Value</label>
                <input type="number" class="form-control" wire:model="value" />
                @error('value')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Start at</label>
                <input type="datetime-local" class="form-control" wire:model="start_at" />
                @error('start_at')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">End at</label>
                <input type="datetime-local" class="form-control" wire:model="end_at" />
                @error('end_at')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Limit</label>
                <input type="number" class="form-control" wire:model="limit" />
                @error('limit')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="modal-footer-btn">
            <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-submit">
                Repurchase Product
                {{--  {{ $discountId ? 'Update Discount' : 'Create Discount' }}  --}}
            </button>
        </div>
    </form>
</div>
