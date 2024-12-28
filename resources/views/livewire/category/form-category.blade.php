<div>
    <form wire:submit.prevent="saveCategory">
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" class="form-control" wire:model="category" />
            @error('category')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" wire:model="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <div class="modal-footer-btn">
            <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-submit">
                {{ $categoryId ? 'Update Category' : 'Create Category' }}
            </button>
        </div>
    </form>
</div>
