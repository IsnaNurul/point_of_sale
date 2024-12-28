<div>
    <form wire:submit.prevent="discountUpdate">
        <div class="mb-3">
            <label for="discount" class="form-label">Discount</label>
            <div class="input-group">
                <span class="input-group-text" style="cursor: pointer;">
                    {{ $discountType === 'rp' ? 'Rp' : 'Rp' }}
                </span>
                <input type="number" class="form-control" id="discount" wire:model="discount"
                    oninput="limitDiscount(this, '{{ $discountType }}')">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<script>
    function limitDiscount(input, discountType) {
        // Konversi nilai input ke angka
        let value = parseFloat(input.value);

        // Jika tipe diskon adalah persen dan nilai lebih dari 100, batasi ke 100
        if (discountType === 'percent' && value > 100) {
            input.value = 100;
        }

        // Pastikan nilai tidak negatif
        if (value < 0) {
            input.value = 0;
        }
    }
</script>
