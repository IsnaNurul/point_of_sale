<div>
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Purchases List</h4>
                    <h6>Manage your purchases</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg"
                            alt="img" /></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                            src="assets/img/icons/excel.svg" alt="img" /></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i data-feather="printer"
                            class="feather-rotate-ccw"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                            class="feather-rotate-ccw"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#purchases-modal">
                    <i data-feather="plus-circle" class="me-2"></i>Repurchases Product</a>
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
                                <th>Product</th>
                                <th>Qty Added</th>
                                <th>Added By User</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        {{--  <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox" />
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $category->category }}</td>
                                    <td>{{ \Carbon\Carbon::parse($category->created_at)->locale('id')->isoFormat('D MMMM YYYY') ?? '' }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $category->status === 'Active' ? 'badge-linesuccess' : 'badge-linedanger' }}">
                                            {{ $category->status }}
                                        </span>
                                    </td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#purchases-modal"
                                                onclick="setCategoryData({{ $category->id }})">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a class="confirm-text p-2"
                                                wire:click="deleteCategory({{ $category->id }})">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>  --}}
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--  <!-- Modal for Add/Edit Category -->
    <div class="modal fade" id="purchases-modal" tabindex="-1" aria-labelledby="purchases-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4 id="modal-title">Repurchases Product</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <livewire:purchases.form-purchases />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}

</div>
{{--  <script>
    function showCreateModal() {
        console.log('Opening create modal');
        document.getElementById('modal-title').innerText = 'Create Category';

        // Dispatch event untuk reset form
        const resetEvent = new CustomEvent('resetForm');
        window.dispatchEvent(resetEvent);
    }

    function setCategoryData(categoryId) {
        console.log('Event will be dispatched with categoryId: ', categoryId);
        document.getElementById('modal-title').innerText = 'Edit Category';

        // Dispatch event dengan ID kategori
        const event = new CustomEvent('setCategoryData', {
            detail: {
                categoryId: categoryId
            },
        });
        window.dispatchEvent(event);
    }
</script>  --}}
