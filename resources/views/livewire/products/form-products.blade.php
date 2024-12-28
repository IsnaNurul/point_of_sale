<div>
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>{{ $productId ? 'Edit Product' : 'New Product' }}</h4>
                    <h6>{{ $productId ? 'Update product details' : 'Create new product' }}</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <div class="page-btn">
                        <a href="{{ route('products') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                                class="me-2"></i>Back to
                            Product</a>
                    </div>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
        </div>

        <form wire:submit.prevent="save" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body add-product pb-0">
                    <div class="accordion-card-one accordion" id="accordionExample">
                        <div class="accordion-item">
                            <div class="accordion-header" id="headingOne">
                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                    aria-controls="collapseOne">
                                    <div class="addproduct-icon">
                                        <h5>
                                            <i data-feather="info" class="add-info"></i><span>Product Information</span>
                                        </h5>
                                        <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                class="chevron-down-add"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="input-blocks add-product list">
                                                <label>SKU</label>
                                                <input type="text" wire:model="sku" class="form-control">
                                                @error('sku')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" wire:model="name" class="form-control">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <div class="add-newplus">
                                                    <label class="form-label">Category</label>
                                                </div>
                                                <select wire:model="categoryId" class="form-select">
                                                    <option value="">Choose</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('categoryId')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="addservice-info">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="input-blocks add-product">
                                                    <label>Price</label>
                                                    <input type="number" wire:model="price" class="form-control">
                                                    @error('price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="input-blocks add-product">
                                                    <label>Quantity</label>
                                                    <input type="number" wire:model="qty" class="form-control">
                                                    @error('qty')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <div class="add-newplus">
                                                        <label class="form-label">Unit</label>
                                                    </div>
                                                    <select wire:model="unitId" class="form-select">
                                                        <option value="">Choose</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}">{{ $unit->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('unitId')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="input-blocks add-product">
                                        <label>Status</label>
                                        <select class="form-select" wire:model="status">
                                            <option value="" selected>Choose</option>
                                            <option value=1>Active</option>
                                            <option value=0>InActive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-blocks summer-description-box transfer mb-3">
                                        <label>Description</label>
                                        <textarea wire:model="description" class="form-control" rows="5"></textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="accordion-card-one accordion" id="accordionExample3">
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="headingThree">
                                            <div class="accordion-button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseThree" aria-controls="collapseThree">
                                                <div class="addproduct-icon list">
                                                    <h5>
                                                        <i data-feather="image"
                                                            class="add-info"></i><span>Images</span>
                                                    </h5>
                                                    <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                            class="chevron-down-add"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapseThree" class="accordion-collapse collapse show"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionExample3">
                                            <div class="accordion-body">
                                                <div class="text-editor add-list add">
                                                    <div class="col-lg-12">
                                                        <div class="add-choosen">
                                                            <div class="input-blocks">
                                                                <div class="image-upload">
                                                                    <input type="file" wire:model="image" />
                                                                    <!-- Menghubungkan input file dengan Livewire -->
                                                                    <div class="image-uploads">
                                                                        <i data-feather="plus-circle"
                                                                            class="plus-down-add me-0"></i>
                                                                        <h4>Add Images</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if ($image)
                                                                <div class="phone-img">
                                                                    <img src="{{ $image->temporaryUrl() }}"
                                                                        alt="image" />
                                                                    <a href="javascript:void(0);"
                                                                        wire:click="removeImage"><i data-feather="x"
                                                                            class="x-square-add remove-product"></i></a>
                                                                </div>
                                                            @endif
                                                            @if ($productId)
                                                                <div class="phone-img">
                                                                    @if ($existingImage)
                                                                        <img src="{{ asset('storage/' . $existingImage) }}"
                                                                            alt="Existing Image">
                                                                        <a href="javascript:void(0);"
                                                                            wire:click="removeImage"><i
                                                                                data-feather="x"
                                                                                class="x-square-add remove-product"></i></a>
                                                                    @else
                                                                        <p>No image available</p>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="btn-addproduct mb-4">
                    <button type="button" class="btn btn-cancel me-2">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-submit">
                        {{ $productId ? 'Edit Product' : 'Save Product' }}
                    </button>
                </div>
            </div>
    </div>
    </form>
</div>
</div>
