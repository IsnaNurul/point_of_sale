<style>
    .order-body {
        height: 50vh;
        overflow: auto;
    }

    .order-body .default-cover {
        border: 3px solid #f3f6f9;
        box-shadow: 0 4px 60px 0 rgba(231, 231, 231, 0.47);
        border-radius: 8px;
    }

    .order-body .record {
        font-size: 13px;
    }

    .order-body .record td {
        padding-bottom: 15px;
    }

    .order-body .record tr:last-child td {
        padding-bottom: 0;
    }

    .order-body .record .colon {
        padding: 0 10px;
        color: #092c4c;
    }

    .order-body .record .text {
        color: #5b6670;
        white-space: nowrap;
    }

    .order-body p {
        font-size: 15px;
        background-color: #fafbfe;
        border-radius: 8px;
    }
</style>
<div class="page-wrapper pos-pg-wrapper ms-0">
    <div class="content pos-design p-0">
        <div class="row align-items-start pos-wrapper">
            @if (session()->has('error'))
                <div class="p-3">
                    <div class="alert alert-solid-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                class="fas fa-xmark"></i></button>
                    </div>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-solid-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                            class="fas fa-xmark"></i></button>
                </div>
            @endif
            <div class="col-md-12 col-lg-12">
                <div class="btn-row d-sm-flex align-items-center">
                    <a href="{{ route('pos') }}" class="btn btn-secondary mb-xs-3" data-bs-target="#orders"><span
                            class="me-1 d-flex align-items-center"><i data-feather="shopping-cart"
                                class="feather-16"></i></span>POS</a>
                    <a href="{{ route('hold') }}" class="btn btn-info"><span class="me-1 d-flex align-items-center"><i
                                data-feather="rotate-cw" class="feather-16"></i></span>Hold ({{ $holdCount }})</a>
                    <a href="{{ route('transaction') }}" class="btn btn-primary" data-bs-target="#recents"><span
                            class="me-1 d-flex align-items-center"><i data-feather="refresh-ccw"
                                class="feather-16"></i></span>Transaction</a>
                </div>

                <div class="pos-categories tabs_wrapper">
                    <div class="pos-products">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-3">Transaction Hold</h5>
                        </div>
                        <div class="row">
                            @foreach ($holds as $hold)
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-4">
                                    <div class="order-body">
                                        <div class="default-cover p-4 mb-4">
                                            <span class="badge bg-secondary d-inline-block mb-4">Transaction ID :
                                                #{{ $hold->transaction_code }}</span>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 record mb-3">
                                                    <table>
                                                        <tr class="mb-3">
                                                            <td>Cashier</td>
                                                            <td class="colon">:</td>
                                                            <td class="text">{{ $hold->user->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td class="colon">:</td>
                                                            <td class="text fw-bold">
                                                                {{ number_format($hold->total_price, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-sm-12 col-md-6 record mb-3">
                                                    <table>
                                                        <tr>
                                                            <td>Date</td>
                                                            <td class="colon">:</td>
                                                            <td class="text">{{ $hold->created_at }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                                {{-- <a class="btn btn-warning btn-icon flex-fill"
                                                    href="{{ route('hold-pos', $hold->id) }}">Next</a> --}}
                                                <a data-bs-toggle="modal" data-bs-target="#category-modal"
                                                    onclick="setTotalCart({{ $hold->id }})"
                                                    class="btn btn-info btn-icon flex-fill">Payment</a>
                                                <a data-bs-toggle="modal" data-bs-target="#product-modal"
                                                    onclick="setProductModal({{ $hold->id }})"
                                                    class="btn btn-success btn-icon flex-fill">Products</a>
                                                <a class="btn btn-danger btn-icon flex-fill"
                                                    onclick="setCancel({{ $hold->id }})">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal form -->
    <div class="modal fade" id="product-modal" tabindex="-1" aria-labelledby="product-modal-label"
        data-bs-backdrop="static" aria-hidden="true" role="dialog">
        <div class="modal-dialog sales-details-modal">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4 id="modal-title">List Product</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <livewire:pos.modal-product />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal form -->
    <div class="modal fade" id="category-modal" tabindex="-1" aria-labelledby="category-modal-label"
        data-bs-backdrop="static" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-body custom-modal-body">
                            <livewire:pos.form-payment />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showCreateModal() {
        console.log('Opening create modal');
        document.getElementById('modal-title').innerText = 'Create Category';

        // Dispatch event untuk reset form
        const resetEvent = new CustomEvent('resetForm');
        window.dispatchEvent(resetEvent);
    }

    function setTotalCart(totalCart) {
        console.log('Event will be dispatched with categoryId: ', totalCart);

        // Dispatch event dengan ID kategori
        const event = new CustomEvent('setTotalCart', {
            detail: {
                totalCart: totalCart
            },
        });
        window.dispatchEvent(event);
    }

    function setProductModal(SaleId) {
        console.log('Event will be dispatched with categoryId: ', SaleId);

        // Dispatch event dengan ID kategori
        const event = new CustomEvent('setProductModal', {
            detail: {
                SaleId: SaleId
            },
        });
        window.dispatchEvent(event);
    }

    function setCancel(SaleId) {
        console.log('Event will be dispatched with categoryId: ', SaleId);

        // Dispatch event dengan ID kategori
        const event = new CustomEvent('setCancel', {
            detail: {
                SaleId: SaleId
            },
        });
        window.dispatchEvent(event);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('product-modal');

        modal.addEventListener('hidden.bs.modal', () => {
            console.log('Modal closed, resetting data...');

            // Dispatch event untuk reset data di modal
            const resetEvent = new CustomEvent('resetForm');
            window.dispatchEvent(resetEvent);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('category-modal');

        modal.addEventListener('hidden.bs.modal', () => {
            console.log('Modal closed, resetting data...');

            // Dispatch event untuk reset data di modal
            const resetEvent = new CustomEvent('resetForm');
            window.dispatchEvent(resetEvent);
        });
    });
</script>
