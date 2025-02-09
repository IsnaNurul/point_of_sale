<div>
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Discount List</h4>
                    <h6>Manage your discount</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#discount-modal">
                    <i data-feather="plus-circle" class="me-2"></i>Add New Discount</a>
            </div>
        </div>

        @if (session()->has('error'))
            <div class="alert alert-solid-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                        class="fas fa-xmark"></i></button>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-solid-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                        class="fas fa-xmark"></i></button>
            </div>
        @endif


        <div class="card table-list-card">
            <div class="card-body">
                <div class="table-top">
                </div>

                <div class="table-responsive product-list">
                    <table class="table" id="example">
                        <thead>
                            <tr>
                                {{--  <th class="no-sort">
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all" />
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>  --}}
                                <th class="text-start">No</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Start At</th>
                                <th>End At</th>
                                <th>Limit</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($discounts as $discount)
                                <tr>
                                    {{--  <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" />
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>  --}}
                                    <td class="text-start">{{ $loop->iteration }}</td>
                                    <td>{{ $discount->name }}</td>
                                    <td class="fw-bold">{{ $discount->code }}</td>
                                    <td>{{ $discount->type === 'percent' ? 'Percent' : 'Fixed' }}</td>
                                    <td>{{ $discount->value }}</td>
                                    <td>{{ \Carbon\Carbon::parse($discount->start_at)->locale('id')->isoFormat('D MMMM YYYY HH:mm') ?? '' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($discount->end_at)->locale('id')->isoFormat('D MMMM YYYY HH:mm') ?? '' }}
                                    </td>
                                    <td>{{ $discount->limit }} Transaction</td>
                                    <td>
                                        <span
                                            class="badge {{ $discount->status == 1 ? 'badge-linesuccess' : 'badge-linedanger' }}"
                                            wire:click="toggleStatus({{ $discount->id }})" style="cursor: pointer;"
                                            title="Click to toggle status">
                                            {{ $discount->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#discount-modal"
                                                onclick="setDiscountData({{ $discount->id }})">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a class="confirm-text p-2"
                                                wire:click="deleteDiscount({{ $discount->id }})">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>
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

    <!-- Modal for Add/Edit Discount -->
    <div class="modal fade" id="discount-modal" tabindex="-1" aria-labelledby="discount-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4 id="modal-title">Create Discount</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <livewire:discount.form-discount />
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
        document.getElementById('modal-title').innerText = 'Create Discount';

        // Dispatch event untuk reset form
        const resetEvent = new CustomEvent('resetForm');
        window.dispatchEvent(resetEvent);
    }

    function setDiscountData(discountId) {
        console.log('Event will be dispatched with discountId: ', discountId);
        document.getElementById('modal-title').innerText = 'Edit Discount';

        // Dispatch event dengan ID kategori
        const event = new CustomEvent('setDiscountData', {
            detail: {
                discountId: discountId
            },
        });
        window.dispatchEvent(event);
    }
</script>
