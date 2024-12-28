<div>
    <form wire:submit.prevent="saveUnit">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" wire:model="name" />
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Short Name</label>
            <input type="text" class="form-control" wire:model="short_name" />
            @error('short_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" wire:model="status" required>
                <option value=1>Active</option>
                <option value=0>Inactive</option>
            </select>
        </div>
        <div class="modal-footer-btn">
            <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-submit">
                {{--  Create Unit  --}}
                {{ $unitId ? 'Update Unit' : 'Create Unit' }}
            </button>
        </div>
    </form>
</div>
