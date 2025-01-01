<div>
    <div class="table-responsive product-list mb-5">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            @if (isset($product->product->image))
                                <img src="{{ asset('storage/' . $product->product->image) }}" alt="Product Image" width="50"
                                    height="50" />
                            @endif
                            <a href="javascript:void(0);">{{ $product->product->name ?? 'N/A' }}</a>
                        </td>
                        <td>{{ $product->qty }}</td>
                        <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
