<div>
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Customer List</h4>
                    <h6>Manage your customer</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#customer-modal">
                    <i data-feather="plus-circle" class="me-2"></i>Add New Customer</a>
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
                                <th class="text-start">Name</th>
                                <th class="text-start">Email</th>
                                <th class="text-start">Phone Number</th>
                                <th class="text-start">Address</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td class="text-start">{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $customer->user->name ? $customer->user->name : '-'}}</td>
                                    <td class="text-start">{{ $customer->user->email ? $customer->user->email : '-' }}
                                    </td>
                                    <td class="text-start">{{ $customer->user->phone ? $customer->user->phone : '-' }}</td>
                                    <td class="text-start">{{ $customer->user->address ? $customer->user->address : '-'}}</td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#customer-modal"
                                                onclick="setCustomerData({{ $customer->user->id }})">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a class="p-2" href="javascript:void(0);"
                                                onclick="confirmDelete({{ $customer->user->id }})">
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

    <!-- Modal for Add/Edit Customer -->
    <div class="modal fade" id="customer-modal" tabindex="-1" aria-labelledby="customer-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4 id="modal-title">Create Customer</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <livewire:customers.form-customer />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function confirmDelete(customerId) {
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
                @this.call('deleteCustomer', customerId);
            }
        });
    }
</script>

<script>
    function showCreateModal() {
        console.log('Opening create modal');
        document.getElementById('modal-title').innerText = 'Create Customer';

        // Dispatch event untuk reset form
        const resetEvent = new CustomEvent('resetForm');
        window.dispatchEvent(resetEvent);
    }

    function setCustomerData(customerId) {
        console.log('Event will be dispatched with customerId: ', customerId);
        document.getElementById('modal-title').innerText = 'Edit Customer';

        // Dispatch event dengan ID kategori
        const event = new CustomEvent('setCustomerData', {
            detail: {
                customerId: customerId
            },
        });
        window.dispatchEvent(event);
    }
</script>
