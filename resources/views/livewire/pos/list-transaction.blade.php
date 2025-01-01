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

    .table-list-card table tr:hover {
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .badge {
        padding: 5px 10px;
        font-size: 0.85em;
        border-radius: 12px;
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

                <div class="p-3 tabs_wrapper">
                    <div class="pos-products">
                        <div class="page-header">
                            <div class="page-btn">
                            </div>

                        </div>
                        <div class="card table-list-card">
                            <div class="card-body">
                                <div class="table-top">
                                    <div>
                                        
                                    </div>
                                    <ul class="table-top-head">
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                                    src="assets/img/icons/pdf.svg" alt="img" /></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                                                    src="assets/img/icons/excel.svg" alt="img" /></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i
                                                    data-feather="printer" class="feather-rotate-ccw"></i></a>
                                        </li>
                                    </ul>

                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="no-sort">
                                                    <label class="checkboxs">
                                                        <input type="checkbox" id="select-all" />
                                                        <span class="checkmarks"></span>
                                                    </label>
                                                </th>
                                                <th>Transaction Id</th>
                                                <th>Date</th>
                                                <th>Total Product</th>
                                                <th>Sub Total</th>
                                                <th>Discount</th>
                                                <th>Total Price</th>
                                                <th>Payment Method</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="sales-list">
                                            @if ($sales->isEmpty())
                                                <tr>
                                                    <td colspan="10" class="text-center">No transactions found</td>
                                                </tr>
                                            @else
                                                @foreach ($sales as $sale)
                                                    <tr>
                                                        <td>
                                                            <label class="checkboxs">
                                                                <input type="checkbox" />
                                                                <span class="checkmarks"></span>
                                                            </label>
                                                        </td>
                                                        <td>#{{ $sale->transaction_code }}</td>
                                                        <td>{{ $sale->created_at }}</td>
                                                        <td>{{ $sale->total_qty }}</td>
                                                        <td>{{ number_format($sale->sub_total, 0, ',', '.') }}</td>
                                                        <td>{{ number_format($sale->discount, 0, ',', '.') }}</td>
                                                        <td>{{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                                        <td><b>{{ $sale->payment_method }}</b></td>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $sale->status === 'success' ? 'success' : ($sale->status === 'hold' ? 'warning' : 'danger') }}">
                                                                {{ $sale->status }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="action-set" href="javascript:void(0);"
                                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="javascript:void(0);" class="dropdown-item"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#sales-details-new"><i
                                                                            data-feather="eye"
                                                                            class="info-img"></i>Sale
                                                                        Detail</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#edit-sales-new"><i
                                                                            data-feather="edit"
                                                                            class="info-img"></i>Edit
                                                                        Sale</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#showpayment"><i
                                                                            data-feather="dollar-sign"
                                                                            class="info-img"></i>Show
                                                                        Payments</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#createpayment"><i
                                                                            data-feather="plus-circle"
                                                                            class="info-img"></i>Create Payment</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        class="dropdown-item"><i
                                                                            data-feather="download"
                                                                            class="info-img"></i>Download pdf</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        class="dropdown-item confirm-text mb-0"><i
                                                                            data-feather="trash-2"
                                                                            class="info-img"></i>Delete
                                                                        Sale</a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal form -->
    <div class="modal fade" id="product-modal" tabindex="-1" aria-labelledby="product-modal-label"
        data-bs-backdrop="static" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
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
</div>

<script>
    function showCreateModal() {
        console.log('Opening create modal');
        document.getElementById('modal-title').innerText = 'Create Category';

        // Dispatch event untuk reset form
        const resetEvent = new CustomEvent('resetForm');
        window.dispatchEvent(resetEvent);
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
