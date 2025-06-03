<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // Total transaksi (jumlah order)
        $totalPenjualan = Order::count();

        // Total pendapatan
        $totalPendapatan = Order::sum('total_price');

        // Jumlah total produk terjual dari orders_details
        $produkTerjual = DB::table('orders_details')->sum('product_quantity');

        // Produk terlaris dari orders_details
        $produkTerlars = DB::table('orders_details')
            ->select('product_id', DB::raw('SUM(product_quantity) as total_terjual'))
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $product = Product::with('description.category')->find($item->product_id);
                return [
                    'nama_produk' => $product->product_name ?? 'Tidak diketahui',
                    'kategori' => $product->description->category->category ?? '-',
                    'qty_terjual' => $item->total_terjual,
                    'total_pendapatan' => $item->total_terjual * ($product->product_price ?? 0),
                ];
            });

            $totalQty = DB::table('orders_details')->sum('product_quantity');

            $produkTerlars = DB::table('orders_details')
                ->select('product_id', DB::raw('SUM(product_quantity) as total_terjual'))
                ->groupBy('product_id')
                ->orderByDesc('total_terjual')
                ->take(5)
                ->get()
                ->map(function ($item) use ($totalQty) {
                    $product = Product::with('description.category')->find($item->product_id);
                    $pendapatan = $item->total_terjual * ($product->product_price ?? 0);
                    return [
                        'nama_produk' => $product->product_name ?? 'Tidak diketahui',
                        'kategori' => $product->description->category->category ?? '-',
                        'qty_terjual' => $item->total_terjual,
                        'total_pendapatan' => $pendapatan,
                        'persentase' => $totalQty > 0 ? round(($item->total_terjual / $totalQty) * 100) : 0,
                    ];
                });

        return view('admin.laporan', compact(
            'totalPenjualan',
            'totalPendapatan',
            'produkTerjual',
            'produkTerlars'
        ));
    }
}
