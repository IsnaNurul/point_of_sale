<div class="page-wrapper pos-pg-wrapper ms-0">
    <style>
        .scroll-container {
            max-height: 600px;
            /* Atur sesuai kebutuhan Anda */
            overflow-y: auto;
            padding-right: 10px;
            /* Tambahan untuk spacing jika diperlukan */
            scrollbar-width: thin;
            /* Untuk browser modern */
        }

        .scroll-container::-webkit-scrollbar {
            width: 8px;
            /* Lebar scrollbar */
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background-color: #ccc;
            /* Warna scrollbar */
            border-radius: 4px;
        }

        .scroll-container::-webkit-scrollbar-thumb:hover {
            background-color: #aaa;
            /* Warna scrollbar saat hover */
        }

        .select2-container .select2-selection--single {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 8px;
            height: 38px;
            padding: 5px 10px;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 36px;

        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            color: #495057;
            font-size: 14px;
            padding-left: 10px;
        }

        .select2-container span b {
            display: none;
        }
    </style>
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
            <div class="col-md-12 col-lg-7">
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
                        <div class="row mb-3">
                            <div class="col-4">
                                <h5 class="">List Products</h5>
                            </div>
                            <div class="col-8 d-flex justify-content-end align-items-end">
                                <!-- Search form -->
                                <div class="input-group w-50 me-4 mb-3">
                                    <input type="text" class="form-control" placeholder="Search Products..."
                                        wire:model.lazy="search">
                                    <span class="input-group-text btn-searchset">
                                        <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img" />
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="tabs_container">
                            <div class="tab_content active" data-tab="all">
                                <div class="row scroll-container">
                                    @forelse ($products as $product)
                                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                                            <div class="product-info default-cover card"
                                                wire:click="addToCart({{ $product->id }})">
                                                <a href="javascript:void(0);" class="img-bg" style="overflow: hidden">
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Products"
                                                        class="product-img"
                                                        style="max-width: 100%; height: auto; object-fit: cover;border-radius:8px;" width="50px" />
                                                    <span><i data-feather="check" class="feather-16"></i></span>
                                                </a>
                                                <h6 class="cat-name">
                                                    <a href="javascript:void(0);">{{ $product->category->category }}</a>
                                                </h6>
                                                <h6 class="product-name">
                                                    <a href="javascript:void(0);">{{ $product->name ?? '' }}</a>
                                                </h6>
                                                <div class="d-flex align-items-center justify-content-between price">
                                                    <span>{{ $product->qty ?? '' }} Pcs</span>
                                                    <p>{{ number_format($product->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center mt-5 mb-5">
                                            <p>Product Not Found.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 ps-0">
                <aside class="product-order-list">
                    <div class="head d-flex align-items-center justify-content-between w-100">
                        <div class="">
                            <h5>Order List</h5>
                            <span>Transaction ID : #{{ $cart->id ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span>{{ now()->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="customer-info block-section">
                    </div>
                    {{-- <div class="scroll-container2">
                        <div class="product-added block-section">
                            <div class="head-text d-flex align-items-center justify-content-between">
                                <h6 class="d-flex align-items-center mb-0">
                                    Product Added<span class="count">{{ $cartsCount }}</span>
                                </h6>
                            </div>
                            <div class="product-wrap">
                                @foreach ($carts as $cart)
                                    <div class="product-list d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                            data-bs-target="#products">
                                            <a href="javascript:void(0);" class="img-bg" style="overflow: hidden">
                                                <img src="{{ asset('storage/' . $cart->product->image) }}"
                                                    alt="Products"
                                                    style="max-width: 100%; height: auto; object-fit: cover;border-radius:8px;wi" />
                                            </a>
                                            <div class="info">
                                                <span>{{ $cart->product->sku }}</span>
                                                <h6>
                                                    <a href="javascript:void(0);">{{ $cart->product->name ?? '' }}</a>
                                                </h6>
                                                <div class="d-flex justify-content-between mb-0">
                                                    <p> {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                                    <p class="ms-3">x {{ $cart->qty }}</p>
                                                    <p class="ms-3">
                                                        {{ number_format($cart->price, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    @if ($cart->discount > 0)
                                                        @if ($cart->discount_type == 'percent')
                                                            <div class="d-flex justify-content-between">
                                                                <p class="me-3">Disc. ({{ $cart->discount }})</p>
                                                                <p class="me-3">- {{ $cart->discountNominal }}</p>
                                                            </div>
                                                        @else
                                                            <div>
                                                                <p>Disc. ({{ $cart->discount }})</p>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if ($cart->noted)
                                                        <div>
                                                            <p>** {{ $cart->noted }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="qty-item text-center">
                                            <a href="javascript:void(0);"
                                                class="dec d-flex justify-content-center align-items-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="minus"
                                                wire:click="decreaseQty({{ $cart->id }})">
                                                <i data-feather="minus-circle" class="feather-14"></i>
                                            </a>
                                            <input type="text" class="form-control text-center" name="qty"
                                                value="{{ $cart->qty }}" readonly />
                                            <a href="javascript:void(0);"
                                                class="inc d-flex justify-content-center align-items-center {{ $cart->qty >= $cart->product->qty ? 'disabled' : '' }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="plus"
                                                wire:click="increaseQty({{ $cart->id }})">
                                                <i data-feather="plus-circle" class="feather-14"></i>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center action">
                                            <a class="btn-icon edit-icon me-2" data-bs-toggle="modal"
                                                data-bs-target="#category-modal"
                                                onclick="addDiscount({{ $cart->id }})">
                                                <i data-feather="edit" class="feather-14"></i>
                                            </a>
                                            <a class="btn-icon delete-icon"
                                                wire:click="deleteCartItem({{ $cart->id }})">
                                                <i data-feather="trash-2" class="feather-14"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="block-section">
                            <div class="order-total">
                                <table class="table table-responsive table-borderless">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end">Rp. {{ number_format($subTotalCart, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="danger">Discount</td>
                                        <td class="danger text-end">{{ number_format($totalDiscount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr style="border-top: 2px solid #797979;">
                                        <td>Total</td>
                                        <td class="text-end">Rp. {{ number_format($totalCart, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="d-grid btn-block">
                            <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#category-modal"
                                onclick="setTotalCart({{ $totalCart }})">
                                <p style="font-size: 20px">Rp. {{ number_format($totalCart, 0, ',', '.') }}</p>
                            </a>
                        </div>
                        <div class="btn-row d-sm-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" wire:click="holdOrder"
                                class="btn btn-info btn-icon flex-fill" data-bs-toggle="modal"
                                data-bs-target="#hold-order"><span class="me-1 d-flex align-items-center"><i
                                        data-feather="pause" class="feather-16"></i></span>Hold</a>
                            <a href="javascript:void(0);" wire:click="clearCart"
                                class="btn btn-danger btn-icon flex-fill"><span
                                    class="me-1 d-flex align-items-center"><i data-feather="trash-2"
                                        class="feather-16"></i></span>Clear</a>
                        </div>
                    </div> --}}
                </aside>
            </div>
        </div>
    </div>
</div>
