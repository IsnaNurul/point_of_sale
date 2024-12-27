<div>
    <form wire:submit.prevent="updateCategory">
        <div class="mb-3">
            <label for="category-name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category-name" wire:model="category_name" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" wire:model="status" required>
                <option value="Active" {{ $status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="modal-footer-btn">
            <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-submit">Update Category</button>
        </div>
    </form>

</div>
