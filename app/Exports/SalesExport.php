<?php

namespace App\Exports;

use App\Models\SaleTransaction;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Mengambil data transaksi
        $transactions = SaleTransaction::with('sale_item', 'user')->orderBy('created_at', 'desc')->get();

        $data = [];

        foreach ($transactions as $transaction) {
            $data[] = [
                'Transaction Id' => $transaction->transaction_code,
                'Date' => $transaction->created_at->format('Y-m-d H:i:s'),
                'Cashier' => $transaction->user->name,
                'Total Qty' => $transaction->total_qty,
                'Sub Total' => $transaction->sub_total,
                'Discount' => $transaction->discount,
                'Total Price' => $transaction->total_price,
                'Payment Amount' => $transaction->payment_ammount,
                'Change' => $transaction->payment_ammount ? $transaction->payment_ammount - $transaction->total_price : '',
                'Payment Method' => $transaction->payment_method,
                'Status' => ucfirst($transaction->status),
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Transaction Id',
            'Date',
            'Cashier',
            'Total Product',
            'Sub Total',
            'Discount',
            'Total Price',
            'Payment Amount',
            'Change',
            'Payment Method',
            'Status',
        ];
    }
}
