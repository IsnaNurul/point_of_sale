<?php

namespace App\Livewire;

use App\Models\Cashier;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\SaleTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $data = [];
    public $recentProducts = [];
    public $monthly_sales_data = [];
    public $currentYear;
    public $expiredProducts = [];
    public $bestSellers = []; // For Best Seller Products
    public $recentTransactions = [];

    public function mount()
    {
        $this->data['customer'] = Customer::count();
        $this->data['cashier'] = Cashier::count();
        $this->data['product'] = Product::count();
        $this->data['voucher'] = Discount::count();
        $this->data['total_transaction'] = SaleTransaction::count();
        $this->data['total_sale'] = SaleTransaction::sum('total_price');
        $this->data['avg_sale_overall'] = $this->data['total_transaction'] > 0
            ? round($this->data['total_sale'] / $this->data['total_transaction'], 0) // Membulatkan hingga 2 desimal
            : 0;
        $this->recentProducts = Product::orderBy('created_at', 'desc')->take(5)->get();
        $this->expiredProducts = Product::where('expired', '<', Carbon::now())
            ->get();
        $today = \Carbon\Carbon::today(); // Get today's date
        $this->data['total_sale_today'] = SaleTransaction::whereDate('created_at', $today)->sum('total_price');

        $this->data['monthly_sales'] = SaleTransaction::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as transaction_count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'year' => $item->year,
                    'month' => date('F', mktime(0, 0, 0, $item->month, 10)), // Convert to month name
                    'transaction_count' => $item->transaction_count
                ];
            })
            ->groupBy('year') // Mengelompokkan data berdasarkan tahun
            ->toArray();

        // Mengambil data total penjualan per tahun dan bulan
        $this->data['salesAnalyticsChart'] = SaleTransaction::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total_sales')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')  // Urutkan berdasarkan tahun
            ->orderBy('month', 'asc')  // Urutkan berdasarkan bulan
            ->get()
            ->map(function ($item) {
                return [
                    'year' => $item->year,
                    'month' => date('F', mktime(0, 0, 0, $item->month, 10)), // Mengubah angka bulan menjadi nama bulan
                    'total_sales' => $item->total_sales
                ];
            })
            ->groupBy('year')  // Mengelompokkan berdasarkan tahun
            ->toArray();

        // Default year selection (current year)
        $currentYear = date('Y');
        $this->data['currentYearSales'] = $this->data['salesAnalyticsChart'][$currentYear] ?? [];
        $this->currentYear = $currentYear;

        $this->bestSellers = SaleItem::select('productId', DB::raw('SUM(qty) as total_sales'))
            ->groupBy('productId')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $product = Product::find($item->productId);
                return [
                    'name' => $product->name,
                    'image' => $product->image,
                    'total_sales' => $item->total_sales,
                    'price' => $product->price
                ];
            });

        // Recent Transactions
        $this->recentTransactions = SaleTransaction::latest()
            ->take(6)
            ->get()
            ->map(function ($transaction) {
                $paymentMethod = $transaction->payment_method;
                return [
                    'transaction_id' => $transaction->transaction_code,
                    'order_details' => $transaction->sale_item->pluck('product.name')->implode(', '),
                    'payment_method' => $paymentMethod,
                    'status' => $transaction->status,
                    'amount' => $transaction->total_price
                ];
            });
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
