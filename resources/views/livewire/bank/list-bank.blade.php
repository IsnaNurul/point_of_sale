<div>
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Payment Method List</h4>
                    <h6>Manage your payment method</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#bank-modal">
                    <i data-feather="plus-circle" class="me-2"></i>Add New Method</a>
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
                                <th class="text-start">No</th>
                                <th>Bank Name</th>
                                <th class="text-start">Rekening</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bank as $item)
                                <tr>
                                    <td class="text-start">{{ $loop->iteration }}</td>
                                    <td>{{ $item->bank_name }}</td>
                                    <td class="text-start">{{ $item->rekening }}</td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#bank-modal"
                                                onclick="setitemData({{ $item->id }})">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a class="p-2" href="javascript:void(0);"
                                                onclick="confirmDelete({{ $item->id }})">
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

    <!-- Modal for Add/Edit bank -->
    <div class="modal fade" id="bank-modal" tabindex="-1" aria-labelledby="bank-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4 id="modal-title">Create bank</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <livewire:bank.form-bank />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(bankId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fd7e14',
            cancelButtonColor: '#FF0000',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('deletebank', bankId);
            }
        });
    }
</script>
<script>
    function showCreateModal() {
        console.log('Opening create modal');
        document.getElementById('modal-title').innerText = 'Create bank';

        // Dispatch event untuk reset form
        const resetEvent = new CustomEvent('resetForm');
        window.dispatchEvent(resetEvent);
    }

    function setitemData(bankId) {
        console.log('Event will be dispatched with bankId: ', bankId);
        document.getElementById('modal-title').innerText = 'Edit bank';

        // Dispatch event dengan ID kategori
        const event = new CustomEvent('setbankData', {
            detail: {
                bankId: bankId
            },
        });
        window.dispatchEvent(event);
    }
</script>
