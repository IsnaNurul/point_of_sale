<div>
    <form wire:submit.prevent="savebank">
        <div class="mb-3">
            <label class="form-label">Bank Name</label>
            <input type="text" class="form-control" wire:model="bank_name" />
            @error('bank_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">No. Rekening</label>
            <input type="text" class="form-control" wire:model="rekening" />
            @error('rekening')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="modal-footer-btn">
            <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-submit">
                {{ $bankId ? 'Update Payment Method' : 'Create Payment Method' }}
            </button>
        </div>
    </form>
</div>
