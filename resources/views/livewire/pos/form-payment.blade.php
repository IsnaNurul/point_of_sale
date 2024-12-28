<div>
    @if ($showPaymentModal)
     <b><p class="text-end">Total Payment : Rp. {{ $totalCart }}</p></b>
        <form id="payment-form" wire:submit.prevent="saveTransaction">
            <h6>Payment Method</h6>
            <div class="mb-3">
                <div class="row mt-3 mb-3 d-flex align-items-center justify-content-center methods">
                    <div class="col-md-6 col-lg-6"
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
                    <div class="col-md-6 col-lg-6"
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

            <!-- Form for Cash payment (hidden initially) -->
            <div id="cash-form" class="row mb-3" style="display: none;">
                <h6 class="mb-2">Enter Amount to Pay</h6>
                <input type="number" class="form-control" id="cash-amount" placeholder="Enter amount" min="0"
                    wire:model="totalCart">
                <span id="cash-error" style="color: red; display: none;">Amount must be greater than or equal to total
                    amount!</span>
            </div>

            <!-- Form for Debit Card payment (hidden initially) -->
            <div id="debit-form" class="row mb-3" style="display: none;">
                <h6 class="mb-2">Select Bank</h6>
                <select class="form-control" id="debit-bank" wire:model="rekening">
                    <option value="">Select Bank</option>
                    @foreach ($bank as $item)
                        <option value="{{ $item->rekening }}">{{ $item->bank_name }} - {{ $item->rekening }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Discount Form -->
            <div id="discount-form" class="row mb-3">
                <h6 class="mb-2">Apply Discount</h6>
                <div class="col-md-6">
                    <select class="form-control" wire:model="discount_type" id="discount-type">
                        <option value="">Type Discount</option>
                        <option value="percent">Percent</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="number" class="form-control" id="discount-amount" placeholder="Enter discount"
                        min="0" wire:model="discount">
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
                    Total Payment <br> <h4>Rp. {{ $totalAmount }}</h4>
                </div>
                <div class="col-md-6">
                    Change <br> <h4>Rp. {{ $changeAmount }}</h4>
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
