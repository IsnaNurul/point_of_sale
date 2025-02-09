<div class="card">
    <div class="card-body">
        <div class="invoice-box table-height"
            style="
  max-width: 1600px;
  width: 100%;
  overflow: auto;
  padding: 0;
  font-size: 14px;
  line-height: 24px;
  color: #555;
">
            <h5 class="order-text">Order Summary</h5>
            <div class="table-responsive product-list">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Sub Total</th>
                            <th>Discount</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saleItems as $item)
                            <tr>
                                <td>
                                    <div class="productimgname">
                                        <a href="javascript:void(0);" class="product-img stock-img">
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="product" />
                                        </a>
                                        <a href="javascript:void(0);">{{ $item->product->name }}</a>
                                    </div>
                                </td>
                                <td>{{ $item->product->price }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->product->unit->short_name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->discountNominal }}</td>
                                <td>{{ $item->price - $item->discountNominal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-lg-4 ms-auto mt-0">
                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                        <ul>
                            <li>
                                <h4>Sub Total</h4>
                                <h5>{{ number_format($items['subTotal'] ?? 0, 0, ',', '.') }}</h5>
                            </li>
                            <li>
                                <h4>Discount</h4>
                                <h5>{{ number_format($items['totalDiscount'] ?? 0, 0, ',', '.') }}</h5>
                            </li>
                            <li>
                                <h4>Grand Total</h4>
                                <h5>{{ number_format($items['grandTotal'] ?? 0, 0, ',', '.') }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
