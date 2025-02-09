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
                    <ul class="table-top-head">
                        {{-- <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                    src="assets/img/icons/pdf.svg" alt="img" /></a>
                        </li> --}}
                        <li>
                            <a class="btn btn-outline-success" href="{{ route('pos.export.excel') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Excel"><img src="assets/img/icons/excel.svg" alt="img" />Export Excel</a>
                        </li>
                        {{-- <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i data-feather="printer"
                                    class="feather-rotate-ccw"></i></a>
                        </li> --}}
                    </ul>
                </div>

                <div class="p-3 tabs_wrapper">
                    <div class="pos-products">
                        <div class="page-header">
                            <div class="page-btn">
                            </div>

                        </div>
                        <div class="card table-list-card">
                            <div class="card-body">
                                <div class="table-responsive product-list">
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th class="text-start">Transaction Id</th>
                                                <th class="text-start">Date</th>
                                                <th class="text-start">Cashier</th>
                                                <th class="text-start">Total Qty</th>
                                                <th class="text-start">Sub Total</th>
                                                <th class="text-start">Discount</th>
                                                <th class="text-start">Total Price</th>
                                                <th class="text-start">Payment Amount</th>
                                                <th class="text-start">Change</th>
                                                <th class="text-start">Payment Method</th>
                                                <th class="text-start">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales as $sale)
                                                <tr>
                                                    <td class="text-start">#{{ $sale->transaction_code }}</td>
                                                    <td class="text-start">{{ $sale->created_at }}</td>
                                                    <td class="text-start">{{ $sale->user->name }}</td>
                                                    <td class="text-start">{{ $sale->total_qty }}</td>
                                                    <td class="text-start">
                                                        {{ number_format($sale->sub_total, 0, ',', '.') }}</td>
                                                    <td class="text-start">
                                                        {{ number_format($sale->discount, 0, ',', '.') }}</td>
                                                    <td class="text-start">
                                                        {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                                    <td class="text-start">
                                                        {{ $sale->payment_ammount ? number_format($sale->payment_ammount, 0, ',', '.') : '-' }}
                                                    </td>
                                                    @if ($sale->payment_ammount)
                                                        <td class="text-start">
                                                            {{ number_format($sale->payment_ammount - $sale->total_price, 0, ',', '.') }}</td>
                                                    @else
                                                        <td class="text-start">-</td>
                                                    @endif
                                                    @if ($sale->payment_method == 'debit')
                                                        <td class="text-start"><b>{{ $sale->bank_name }} -
                                                                {{ $sale->rekening }}</b></td>
                                                    @elseif ($sale->payment_method == 'cash')
                                                        <td class="text-start"><b>{{ $sale->payment_method }}</b></td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                    <td class="text-start">
                                                        <span
                                                            class="badge badge-{{ $sale->status === 'success' ? 'success' : ($sale->status === 'hold' ? 'warning' : 'danger') }}">
                                                            {{ $sale->status }}
                                                        </span>
                                                    </td>
                                                    <td class="action-table-data text-center">
                                                        <div class="edit-delete-action">
                                                            <a class="me-2 p-2" data-bs-toggle="modal"
                                                                data-bs-target="#product-modal"
                                                                onclick="transactionDetail({{ $sale->id }})">
                                                                <i data-feather="eye" class="feather-edit"></i>
                                                            </a>

                                                            {{-- <a class="p-2">
                                                                <i data-feather="download" class="feather-edit"></i>
                                                            </a> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
        <div class="modal-dialog sales-details-modal">
            <div class="modal-content">
                <div class="page-wrapper details-blk">
                    <div class="content p-0">
                        <div class="page-header p-4 mb-0">
                            <div class="add-item d-flex">
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <livewire:pos.transaction-detail />

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

    function transactionDetail(SaleId) {
        console.log('Event will be dispatched with categoryId: ', SaleId);

        // Dispatch event dengan ID kategori
        const event = new CustomEvent('transactionDetail', {
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
