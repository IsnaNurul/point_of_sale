<div class="content">
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Product List</h4>
                <h6>Manage your products</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
        <div class="page-btn">
            <a href="{{ route('products.form') }}" class="btn btn-added"><i data-feather="plus-circle"
                    class="me-2"></i>Add
                New
                Product</a>
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
                            <th class="text-start">Product</th>
                            <th class="text-start">SKU</th>
                            <th class="text-start">Category</th>
                            <th class="text-start">Price</th>
                            <th class="text-start">Qty</th>
                            <th class="text-start">Unit</th>
                            <th class="text-start">Expired Date</th>
                            <th class="text-start">Status</th>
                            <th class="no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="text-start">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="productimgname">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                                width="50" height="50" />
                                        @else
                                            <span>No Image</span>
                                        @endif
                                        <a href="javascript:void(0);" class="ms-2">{{ $product->name ?? 'N/A' }}</a>
                                    </div>
                                </td>
                                <td class="text-start">{{ $product->sku }}</td>
                                <td class="text-start">{{ $product->category->category ?? '' }}</td>
                                <td class="text-start">Rp. {{ number_format($product->price ?? 0, 0, ',', '.') }}</td>
                                <td class="text-start {{ $product->qty < 10 ? 'text-danger' : '' }}">
                                    {{ $product->qty ?? '' }}
                                </td>                                
                                <td class="text-start">{{ $product->unit->short_name ?? '' }}</td>
                                <td class="text-start">{{ $product->expired ? \Carbon\Carbon::parse($product->expired)->format('d F Y') : '' }}</td>
                                <td class="text-start">
                                    <span
                                        class="badge {{ $product->status == 1 ? 'badge-linesuccess' : 'badge-linedanger' }}">
                                        {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2" href="{{ route('products.form', $product->id) }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>

                                        <a class="confirm-text p-2" href="javascript:void(0);"
                                            wire:click="deleteProduct({{ $product->id }})">
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
