<div>
    <div class="table-responsive product-list mb-5">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->product ? $product->product->name : 'No Product' }}</td>
                        <td>{{ $product->qty }}</td>
                        <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
