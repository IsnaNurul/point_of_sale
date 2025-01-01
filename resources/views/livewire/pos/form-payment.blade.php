<div>
    @if ($showPaymentModal)
        <b>
            <h4 class="text-center fw-bold">Total Payment : Rp. {{ $totalCart }}</h4>
        </b>
        <form id="payment-form" wire:submit.prevent="saveTransaction">
            <div class="p-3">
                <h6>Payment Method</h6>
                <div class="mb-3">
                    <div class="row mt-3 mb-3 d-flex align-items-center justify-content-center methods">
                        <div class="col-md-6 col-lg-5 me-3"
                            style="border: 1px solid #ddd;border-radius: 10px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);background-color: #fff;cursor: pointer;"
                            id="cash-method">
                            <div class="d-flex justify-content-center" style="margin: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="m-1">
                                        <img src="assets/img/icons/cash-pay.svg" alt="Payment Method" />
                                    </div>
                                    <div class="m-1">
                                        <span>Cash</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-5 ms-3"
                            style="border: 1px solid #ddd;border-radius: 10px;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);background-color: #fff;cursor: pointer;"
                            id="debit-method">
                            <div class="d-flex justify-content-center" style="margin: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="m-1">
                                        <img src="assets/img/icons/credit-card.svg" alt="Payment Method" />
                                    </div>
                                    <div class="m-1">
                                        <span>Debit Card</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form for Cash payment (hidden initially) -->
            <div id="cash-form" class="row mb-3" style="display: block;">
                <div>
                    <h6 class="mb-2">Enter Amount to Pay</h6>
                    <input type="number" class="form-control" id="cash-amount" placeholder="Enter amount"
                        min="0" wire:model="totalCart">
                    <span id="cash-error" style="color: red; display: none;">Amount must be greater than or equal to
                        total
                        amount!</span>
                </div>
            </div>

            <!-- Form for Debit Card payment (hidden initially) -->
            <div id="debit-form" class="row mb-3" style="display: none;">
                <div>
                    <h6 class="mb-2">Select Bank</h6>
                    <select class="form-control" id="debit-bank" wire:model="rekening">
                        <option value="">Select Bank</option>
                        @foreach ($bank as $item)
                            <option value="{{ $item->rekening }}">{{ $item->bank_name }} - {{ $item->rekening }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="discount-form" class="row mb-3">
                <h6 class="mb-2">Apply Discount</h6>
                <!-- Pilihan tipe diskon -->
                <div class="col-md-12 mb-3">
                    <select class="form-control" wire:model="discount_mode" id="discount-mode">
                        <option value="">Select Discount Mode</option>
                        <option value="voucher">Code Voucher</option>
                        <option value="manual">Discount Amount</option>
                    </select>
                </div>

                <!-- Input kode voucher -->
                <div id="voucher-code-form" style="display: none;">
                    <select class="form-control" wire:model="voucherCode" id="voucher-code">
                        <option value="">Select Code Voucher</option>
                        @foreach ($vouchers as $voucher)
                            <option value="{{ $voucher->id }}">{{ $voucher->code }}</option>
                        @endforeach
                    </select>
                    <span id="voucher-error" style="color: red; display: none;">Please select a voucher!</span>
                </div>

                <!-- Form diskon manual -->
                <div id="manual-discount-form" style="display: none;">
                    <h6 class="mb-2">Input Discount Amount</h6>
                    <div class="d-flex">
                        <div class="col-md-2 mb-2">
                            <select class="form-control" wire:model="discount_type" id="discount-type">
                                <option value="">...</option>
                                <option value="percent">%</option>
                                <option value="fixed">Rp</option>
                            </select>
                        </div>
                        <div class="col-md-10">
                            <input type="number" class="form-control" id="discount-amount" placeholder="Enter discount"
                                min="0" wire:model="discount">
                            <span id="discount-type-error" style="color: red; display: none;">Please select a discount
                                type!</span>
                            <span id="discount-amount-error" style="color: red; display: none;">Please enter discount
                                amount!</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer-btn mb-3">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal" aria-label="Close">
                    Cancel
                </button>
                <button type="submit" class="btn btn-submit" id="submit-payment">Payment</button>
            </div>
        </form>
    @endif


    @if ($showSuccessModal)
        <div class="text-center">
            <div class="icon-head mb-3">
                <a href="javascript:void(0);">
                    <i data-feather="check-circle" class="feather-40 text-success"></i>
                </a>
            </div>
            <h4>Payment Completed</h4>
            <p class="fw-bold" style="font-size: 18px">#{{ $codeTransaction }}</p>

            <div class="row text-center">
                <div class="col-md-6">
                    Total Payment <br>
                    <h4>Rp. {{ $totalAmount }}</h4>
                </div>
                <div class="col-md-6">
                    Change <br>
                    <h4>Rp. {{ $changeAmount }}</h4>
                </div>
            </div>
            <div class="modal-footer d-sm-flex justify-content-between">
                <button type="button" class="btn btn-primary flex-fill" data-bs-toggle="modal"
                    data-bs-target="#print-receipt">
                    Print Receipt<i class="feather-arrow-right-circle icon-me-5"></i>
                </button>
                <button type="submit" class="btn btn-secondary flex-fill" wire:click="nextOrder">
                    Next Order<i class="feather-arrow-right-circle icon-me-5"></i>
                </button>
            </div>
        </div>
    @endif
</div>

<script>
    const totalAmount = 0;
    document.getElementById('submit-payment').disabled = true; // Disable submit until valid input

    // Event listener for cash method
    document.getElementById('cash-method').addEventListener('click', function() {
        document.getElementById('cash-form').style.display = 'block'; // Show cash form
        document.getElementById('debit-form').style.display = 'none'; // Hide debit form
        document.getElementById('cash-error').style.display = 'none'; // Hide error message
        document.getElementById('submit-payment').disabled = false; // Disable submit until valid input
    });

    // Event listener for debit method
    document.getElementById('debit-method').addEventListener('click', function() {
        document.getElementById('debit-form').style.display = 'block'; // Show debit form
        document.getElementById('cash-form').style.display = 'none'; // Hide cash form
        document.getElementById('submit-payment').disabled = false; // Enable submit for debit
    });

    // Validate the cash input and enable/disable the payment button
    document.getElementById('cash-amount').addEventListener('input', function() {
        const cashAmount = parseFloat(this.value);
        const submitButton = document.getElementById('submit-payment');

        if (cashAmount >= totalAmount) {
            document.getElementById('cash-error').style.display = 'none'; // Hide error if valid
            submitButton.disabled = false; // Enable submit button
        } else {
            document.getElementById('cash-error').style.display = 'inline'; // Show error if invalid
            submitButton.disabled = true; // Disable submit button
        }
    });

    // Adding listener to prevent form from closing on clicking modal
    document.querySelector('form').addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent the modal from closing when clicked inside
    });
</script>

<script>
    // Listen for changes in discount mode selection
    document.getElementById('discount-mode').addEventListener('change', function() {
        const mode = this.value;
        const voucherForm = document.getElementById('voucher-code-form');
        const manualForm = document.getElementById('manual-discount-form');

        if (mode === 'voucher') {
            voucherForm.style.display = 'block'; // Tampilkan input kode voucher
            manualForm.style.display = 'none'; // Sembunyikan form diskon manual
        } else if (mode === 'manual') {
            manualForm.style.display = 'block'; // Tampilkan form diskon manual
            voucherForm.style.display = 'none'; // Sembunyikan input kode voucher
        } else {
            // Jika tidak dipilih apa pun, sembunyikan keduanya
            voucherForm.style.display = 'none';
            manualForm.style.display = 'none';
        }
    });
</script>

<script>
    document.getElementById('submit-payment').addEventListener('click', function(event) {
        let isValid = true;

        // Validasi metode diskon
        const discountMode = document.getElementById('discount-mode').value;
        const voucherCode = document.getElementById('voucher-code').value;
        const discountType = document.getElementById('discount-type').value;
        const discountAmount = document.getElementById('discount-amount').value;

        // Reset pesan error
        document.getElementById('voucher-error').style.display = 'none';
        document.getElementById('discount-type-error').style.display = 'none';
        document.getElementById('discount-amount-error').style.display = 'none';

        if (discountMode === 'voucher' && !voucherCode) {
            document.getElementById('voucher-error').style.display = 'block';
            isValid = false;
        }

        if (discountMode === 'manual') {
            if (!discountType) {
                document.getElementById('discount-type-error').style.display = 'block';
                isValid = false;
            }
            if (!discountAmount || discountAmount <= 0) {
                document.getElementById('discount-amount-error').style.display = 'block';
                isValid = false;
            }
        }

        if (!isValid) {
            event.preventDefault(); // Mencegah form submit jika ada error
        }
    });

    // Function to check for required fields in the discount form
    function validateDiscountForm() {
        const discountType = document.getElementById('discount-type').value;
        const discountAmount = document.getElementById('discount-amount').value;
        const discountTypeError = document.getElementById('discount-type-error');
        const discountAmountError = document.getElementById('discount-amount-error');
        let isValid = true;

        // Validate discount type
        if (!discountType) {
            discountTypeError.style.display = 'inline'; // Show error message
            isValid = false;
        } else {
            discountTypeError.style.display = 'none'; // Hide error message
        }

        // Validate discount amount
        if (!discountAmount || discountAmount <= 0) {
            discountAmountError.style.display = 'inline'; // Show error message
            isValid = false;
        } else {
            discountAmountError.style.display = 'none'; // Hide error message
        }

        return isValid; // Return if the form is valid or not
    }

    // Event listener for form submission
    document.getElementById('payment-form').addEventListener('submit', function(event) {
        if (!validateDiscountForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
</script>
