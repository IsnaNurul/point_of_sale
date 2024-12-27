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
                        <a href="product-list.html" class="btn btn-secondary"><i data-feather="arrow-left"
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

        <form wire:submit.prevent="save">
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
                                                <input type="text" wire:model.defer="sku" class="form-control">
                                                @error('sku')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" wire:model.defer="name" class="form-control">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <div class="add-newplus">
                                                    <label class="form-label">Category</label>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                        data-bs-target="#add-units-category"><i
                                                            data-feather="plus-circle"
                                                            class="plus-down-add"></i><span>Add New</span></a>
                                                </div>
                                                <select wire:model.defer="categoryId" class="select">
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
                                                    <input type="number" wire:model.defer="price" class="form-control">
                                                    @error('price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="input-blocks add-product">
                                                    <label>Quantity</label>
                                                    <input type="number" wire:model.defer="qty" class="form-control">
                                                    @error('qty')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <div class="add-newplus">
                                                        <label class="form-label">Unit</label>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#add-unit"><i data-feather="plus-circle"
                                                                class="plus-down-add"></i><span>Add New</span></a>
                                                    </div>
                                                    <select wire:model.defer="unitId" class="select">
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
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="input-blocks add-product">
                                                <label>Discount Type</label>
                                                <select class="select">
                                                    <option>Choose</option>
                                                    <option>Percentage</option>
                                                    <option>Fixed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-12">
                                            <div class="input-blocks add-product">
                                                <label>Discount Value (%)</label>
                                                <input type="number" wire:model.defer="discount"
                                                    class="form-control">
                                                @error('discount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-blocks summer-description-box transfer mb-3">
                                                <label>Description</label>
                                                <textarea wire:model.defer="description" class="form-control" rows="5"></textarea>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
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
                                                                        <input type="file" />
                                                                        <div class="image-uploads">
                                                                            <i data-feather="plus-circle"
                                                                                class="plus-down-add me-0"></i>
                                                                            <h4>Add Images</h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="phone-img">
                                                                    <img src="{{ asset('assets/img/products/phone-add-1.png') }}"
                                                                        alt="image" />
                                                                    <a href="javascript:void(0);"><i data-feather="x"
                                                                            class="x-square-add remove-product"></i></a>
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
                </div>
            </div>
    </div>
    <div class="col-lg-12">
        <div class="btn-addproduct mb-4">
            <button type="button" class="btn btn-cancel me-2">
                Cancel
            </button>
            <button type="submit" class="btn btn-submit">
                Save Product
            </button>
        </div>
    </div>
    </form>
</div>
</div>
