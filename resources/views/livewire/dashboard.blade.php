<div class="content">
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash1.svg" alt="img" /></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>
                        <span class="counters" data-count="{{ $data['total_transaction'] }}">0</span>
                    </h5>
                    <h6>Total Transaction</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash1 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash2.svg" alt="img" /></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>
                        Rp. <span class="counters" data-count="{{ $data['total_sale_today'] }}">Rp.
                            {{ $data['total_sale_today'] }}</span>
                    </h5>
                    <h6>Total Sales Today</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash1 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash2.svg" alt="img" /></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>
                        Rp. <span class="counters" data-count="{{ $data['total_sale'] }}">Rp.
                            {{ $data['total_sale'] }}</span>
                    </h5>
                    <h6>Total Overall Sales</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-widget dash2 w-100">
                <div class="dash-widgetimg">
                    <span><img src="assets/img/icons/dash3.svg" alt="img" /></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5>
                        Rp.<span class="counters" data-count="{{ $data['avg_sale_overall'] }}">Rp.
                            {{ $data['avg_sale_overall'] }}</span>
                    </h5>
                    <h6>Avarage Sales</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-counts">
                    <h4>{{ $data['customer'] }}</h4>
                    <h5>Customers</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das1">
                <div class="dash-counts">
                    <h4>{{ $data['cashier'] }}</h4>
                    <h5>Cashier</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das2">
                <div class="dash-counts">
                    <h4>{{ $data['product'] }}</h4>
                    <h5>Product</h5>
                </div>
                <div class="dash-imgs">
                    <img src="assets/img/icons/file-text-icon-01.svg" class="img-fluid" alt="icon" />
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="dash-count das3">
                <div class="dash-counts">
                    <h4>{{ $data['voucher'] }}</h4>
                    <h5>Voucher</h5>
                </div>
                <div class="dash-imgs">
                    <i data-feather="file"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row sales-board">
        <!-- Total Sales Chart -->
        <div class="col-md-12 col-lg-6 col-sm-12 col-12">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Total Transaction</h5>
                    <div class="graph-sets">
                        <div class="dropdown dropdown-wraper">
                            <button class="btn btn-white btn-sm dropdown-toggle d-flex align-items-center"
                                type="button" id="year-selector" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="calendar" class="feather-14"></i> <span id="selected-year">Year</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="year-selector">
                                @foreach ($data['monthly_sales'] as $year => $sales)
                                    <li><a href="javascript:void(0);" class="dropdown-item" id="dropdown-item"
                                            data-year="{{ $year }}">{{ $year }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart_sales"></div>
                </div>
            </div>
        </div>

        <!-- Sales Analytics Chart -->
        <div class="col-md-12 col-lg-6 col-sm-12 col-12">
            <div class="card flex-fill default-cover">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Sales Analytics</h5>
                    <div class="graph-sets">
                        <div class="dropdown dropdown-wraper">
                            <button class="btn btn-white btn-sm dropdown-toggle d-flex align-items-center"
                                type="button" id="year-selector-sales" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="calendar" class="feather-14"></i> <span
                                    id="selected-year-sales">{{ $currentYear }}</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="year-selector-sales">
                                @foreach ($data['salesAnalyticsChart'] as $year => $sales)
                                    <li><a href="javascript:void(0);" class="dropdown-item" id="dropdown-item2"
                                            data-year="{{ $year }}">{{ $year }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="salesAnalyticsChart"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <!-- Best Seller Section -->
        <div class="col-sm-12 col-md-12 col-xl-4 d-flex">
            <div class="card flex-fill default-cover w-100 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Best Seller</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless best-seller">
                            <tbody>
                                @foreach ($bestSellers as $bestSeller)
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                <a href="product-list.html" class="product-img">
                                                    <img src="{{ asset('storage/' . $bestSeller['image']) }}"
                                                        alt="product" />
                                                </a>
                                                <div class="info">
                                                    <a href="product-list.html">{{ $bestSeller['name'] }}</a>
                                                    <p class="dull-text">Rp.
                                                        {{ number_format($bestSeller['price'], 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="head-text">Sales</p>
                                            {{ $bestSeller['total_sales'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions Section -->
        <div class="col-sm-12 col-md-12 col-xl-8 d-flex">
            <div class="card flex-fill default-cover w-100 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Recent Transactions</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless recent-transactions">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Order Details</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentTransactions as $transaction)
                                    <tr>
                                        <td>#{{ $transaction['transaction_id'] }}</td>
                                        <td>{{ $transaction['order_details'] }}</td>
                                        <td>{{ $transaction['payment_method'] ? $transaction['payment_method'] : 'unpaid' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-outline-{{ $transaction['status'] == 'success' ? 'success' : ($transaction['status'] == 'hold' ? 'warning' : 'danger') }}">
                                                {{ $transaction['status'] }}
                                            </span>
                                        </td>
                                        <td>Rp. {{ number_format($transaction['amount'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-4 d-flex">
            <div class="card flex-fill default-cover mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Recent Products</h4>
                    <div class="view-all-link">
                        <a href="{{ route('products') }}" class="view-all d-flex align-items-center">
                            View All<span class="ps-2 d-flex align-items-center"><i data-feather="arrow-right"
                                    class="feather-16"></i></span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive dataview">
                        <table class="table dashboard-recent-products">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Products</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentProducts as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="productimgname">
                                            <a href="#" class="product-img">
                                                <img src="{{ asset('storage/' . $product->image ?? 'assets/img/products/default-img.png') }}"
                                                    alt="{{ $product->name }}"
                                                    style="width: 50px; height: 50px; object-fit: cover;" />
                                            </a>
                                            <a href="#">{{ $product->name }}</a>
                                        </td>
                                        <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No recent products available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-xl-8 d-flex">
            <div class="card flex-fill default-cover w-100 mb-4">
                <div class="card-header">
                    <h4 class="card-title">Expired Products</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive dataview">
                        <table class="table dashboard-expired-products">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all" />
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Stock</th>
                                    <th>Expired Date</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expiredProducts as $product)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" />
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="productimgname">
                                                <a href="javascript:void(0);" class="product-img stock-img">
                                                    <img src="{{ asset('storage/' . $product->image) }}"
                                                        alt="product" />
                                                </a>
                                                <a href="javascript:void(0);">{{ $product->name }}</a>
                                            </div>
                                        </td>
                                        <td><a href="javascript:void(0);">{{ $product->sku }}</a></td>
                                        <td>{{ $product->qty }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($product->expired)->format('d M Y') }}</td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2" href="#">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a class="confirm-text p-2" href="javascript:void(0);">
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

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let chart; // Menyimpan chart Apex
        const monthlySalesData = @json($data['monthly_sales']);

        // Fungsi untuk merender chart berdasarkan data yang diberikan
        function renderChart(data, categories, title) {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Sales Count',
                    data: data
                }],
                xaxis: {
                    categories: categories
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return Math.round(value); // Remove decimals
                        }
                    },
                    min: 0, // Set nilai minimum sumbu Y
                    max: Math.max(...data) + 5, // Menambahkan padding di atas data tertinggi
                    tickAmount: Math.max(5, Math.floor(Math.max(...data) /
                        10)), // Menghitung tick secara dinamis
                },
                title: {
                    text: title,
                    align: 'center'
                },
                colors: ['#556ee6']
            };

            if (chart) {
                chart.updateOptions(options);
            } else {
                chart = new ApexCharts(document.querySelector("#chart_sales"), options);
                chart.render();
            }
        }

        // Fungsi untuk memperbarui data berdasarkan tahun yang dipilih
        function updateMonthlyData(year) {
            if (!monthlySalesData[year]) return; // Tidak ada data untuk tahun tersebut

            const selectedYearData = monthlySalesData[year];

            let transactionCounts = [];
            let categories = [];

            selectedYearData.forEach(monthData => {
                categories.push(monthData.month);
                transactionCounts.push(monthData.transaction_count);
            });

            renderChart(transactionCounts, categories, `Total Transaction for Year ${year}`);
        }

        // Siapkan data awal (per tahun)
        let transactionCounts = [];
        let categories = [];

        // Siapkan kategori dan data transaksi per tahun
        Object.keys(monthlySalesData).forEach(year => {
            categories.push(year); // Tambahkan tahun sebagai kategori
            const totalYearlyCount = monthlySalesData[year].reduce((total, monthData) => total +
                monthData.transaction_count, 0);
            transactionCounts.push(totalYearlyCount); // Jumlahkan transaksi per tahun
        });

        // Render grafik awal dengan data per tahun
        renderChart(transactionCounts, categories, 'Total Transaction By Year');

        // Menambahkan event listener untuk dropdown
        document.querySelectorAll('#dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const selectedYear = this.getAttribute('data-year');
                document.getElementById('selected-year').textContent =
                    selectedYear; // Update tombol dengan tahun yang dipilih
                updateMonthlyData(selectedYear); // Update grafik untuk tahun yang dipilih
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let chart; // Store the Apex chart
        const salesData = @json($data['salesAnalyticsChart']); // Data passed from Laravel
        const currentYear = @json($currentYear); // Current year

        // Function to render chart with data for the selected year
        function renderChart(data, categories, title) {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Total Sales',
                    data: data
                }],
                xaxis: {
                    categories: categories
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return Math.round(value); // Membulatkan angka menjadi integer
                        }
                    },
                    min: 0,
                    max: Math.max(...data) + 100000, // Add padding for highest data point
                    tickAmount: Math.max(5, Math.floor(Math.max(...data) / 100000)),
                },
                title: {
                    text: title,
                    align: 'center'
                },
                colors: ['#28a745'] // Chart color
            };

            if (chart) {
                chart.updateOptions(options);
            } else {
                chart = new ApexCharts(document.querySelector("#salesAnalyticsChart"), options);
                chart.render();
            }
        }

        // Function to update data for a selected year
        function updateSalesData(year) {
            if (!salesData[year]) return; // No data for selected year

            const selectedYearData = salesData[year];

            let totalSales = [];
            let categories = [];

            selectedYearData.forEach(monthData => {
                categories.push(monthData.month); // Month names
                totalSales.push(monthData.total_sales); // Total sales per month
            });

            renderChart(totalSales, categories, `Total Sales for Year ${year}`);
        }

        // Prepare initial data for current year
        let totalSales = [];
        let categories = [];
        const selectedYearData = salesData[currentYear];

        selectedYearData.forEach(monthData => {
            categories.push(monthData.month);
            totalSales.push(monthData.total_sales);
        });

        // Render initial chart with data for the current year
        renderChart(totalSales, categories, `Total Sales for Year ${currentYear}`);

        // Event listener for year selection from dropdown
        document.querySelectorAll('#dropdown-item2').forEach(item => { // Mengganti #item dengan .dropdown-item
            item.addEventListener('click', function() {
                const selectedYear = this.getAttribute('data-year');
                console.log(selectedYear);
                document.getElementById('selected-year-sales').textContent =
                    selectedYear; // Update button text
                updateSalesData(selectedYear); // Update chart with new year data
            });
        });

    });
</script>
