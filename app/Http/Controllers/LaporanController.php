<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

        // Hitung total qty untuk persentase
        $totalQty = DB::table('orders_details')->sum('product_quantity');

        // Produk terlaris dari orders_details
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

    public function filter(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Total transaksi (jumlah order) dalam rentang tanggal
        $totalPenjualan = Order::whereBetween('order_date', [$startDate, $endDate])->count();
    
        // Total pendapatan dalam rentang tanggal
        $totalPendapatan = Order::whereBetween('order_date', [$startDate, $endDate])->sum('total_price');
    
        // Jumlah total produk terjual dari orders_details dalam rentang tanggal
        // FIX: Gunakan id_orders bukan id
        $produkTerjual = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->sum('product_quantity');
    
        // Total qty untuk perhitungan persentase
        // FIX: Gunakan id_orders bukan id
        $totalQty = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->sum('product_quantity');
    
        // Produk terlaris dari orders_details dalam rentang tanggal
        // FIX: Gunakan id_orders bukan id
        $produkTerlars = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->select('product_id', DB::raw('SUM(product_quantity) as total_terjual'))
            ->whereBetween('orders.order_date', [$startDate, $endDate])
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
            'produkTerlars',
            'startDate',
            'endDate'
        ));
    }
    
    public function print(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Menggunakan query yang sama seperti di method filter
        $totalPenjualan = Order::whereBetween('order_date', [$startDate, $endDate])->count();
        $totalPendapatan = Order::whereBetween('order_date', [$startDate, $endDate])->sum('total_price');
        
        // FIX: Gunakan id_orders bukan id
        $produkTerjual = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->sum('product_quantity');
    
        // FIX: Gunakan id_orders bukan id
        $totalQty = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->sum('product_quantity');
    
        // FIX: Gunakan id_orders bukan id
        $produkTerlars = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->select('product_id', DB::raw('SUM(product_quantity) as total_terjual'))
            ->whereBetween('orders.order_date', [$startDate, $endDate])
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
    
        return view('admin.laporan-print', compact(
            'totalPenjualan',
            'totalPendapatan',
            'produkTerjual',
            'produkTerlars',
            'startDate',
            'endDate'
        ));
    }
}