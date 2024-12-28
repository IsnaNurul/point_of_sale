<div class="page-wrapper pos-pg-wrapper ms-0">
    <div class="content pos-design p-0">
        <div class="row align-items-start pos-wrapper">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-md-12 col-lg-8">
                <div class="pos-categories tabs_wrapper">
                    <div class="pos-products">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-3">Products</h5>
                        </div>
                        <div class="tabs_container">
                            <div class="tab_content active" data-tab="all">
                                <div class="row scroll-container">
                                    @foreach ($products as $product)
                                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                                            <div class="product-info default-cover card {{ in_array($product->id, $productInCart) ? 'active' : '' }}"
                                                wire:click="addToCart({{ $product->id }})">
                                                <a href="javascript:void(0);" class="img-bg">
                                                    <img src="assets/img/products/pos-product-01.png" alt="Products" />
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
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 ps-0">
                <aside class="product-order-list">
                    <div class="head d-flex align-items-center justify-content-between w-100">
                        <div class>
                            <h5>Order List</h5>
                            <span>Transaction ID : #{{ $transactionId->transaction_code }}</span>
                        </div>
                        <div class>
                            <a class="confirm-text" href="javascript:void(0);"><i data-feather="user"
                                    class="feather-20 text-secondary"></i></a>
                            <a wire:click="clearCart"><i data-feather="trash-2" class="feather-20 text-danger"></i></a>
                        </div>
                    </div>
                    <div class="scroll-container2">
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
                                            <a href="javascript:void(0);" class="img-bg">
                                                <img src="assets/img/products/pos-product-16.png" alt="Products" />
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
                                                @if ($cart->discount > 0)
                                                    @if ($cart->discount > 0 && $cart->discount <= 100)
                                                        <div class="d-flex justify-content-between">
                                                            <p>Disc. ({{ $cart->discount }})</p>
                                                            <p>- {{ $cart->discountNominal }}</p>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <p>Disc. ({{ $cart->discount }})</p>
                                                        </div>
                                                    @endif
                                                @endif
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
                                                class="inc d-flex justify-content-center align-items-center"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="plus"
                                                wire:click="increaseQty({{ $cart->id }})">
                                                <i data-feather="plus-circle" class="feather-14"></i>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center action">
                                            <a class="btn-icon edit-icon me-2" data-bs-toggle="modal"
                                                data-bs-target="#editDiscount{{ $cart->id }}">
                                                <i data-feather="edit" class="feather-14"></i>
                                            </a>
                                            <div class="modal fade" id="editDiscount{{ $cart->id }}" tabindex="-1"
                                                aria-labelledby="editDiscountModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editProductModalLabel">Edit
                                                                Product</h5>
                                                            <button type="button" class="btn-close"
                                                                wire:click="closeModal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <livewire:pos.form-discount :cartId="$cart->id" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                                        <td class="danger text-end">{{ $totalDiscount }}</td>
                                    </tr>
                                    <tr style="border-top: 2px solid #797979;">
                                        <td>Total</td>
                                        <td class="text-end">Rp. {{ number_format($totalCart, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="d-grid btn-block">
                            <a class="btn btn-secondary" href="javascript:void(0);">
                                Grand Total : $64,024.5
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
                                        class="feather-16"></i></span>Void</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
