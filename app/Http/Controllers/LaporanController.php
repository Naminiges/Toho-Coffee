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
        // Total transaksi (jumlah order) - TETAP semua status
        $totalPenjualan = Order::count();

        // Total pendapatan - HANYA dari pesanan dengan status 'selesai'
        $totalPendapatan = Order::where('order_status', 'selesai')->sum('total_price');

        // Jumlah total produk terjual dari orders_details - HANYA dari pesanan dengan status 'selesai'
        $produkTerjual = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->where('orders.order_status', 'selesai')
            ->sum('product_quantity');

        // Hitung total qty untuk persentase - HANYA dari pesanan dengan status 'selesai'
        $totalQty = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->where('orders.order_status', 'selesai')
            ->sum('product_quantity');

        // Produk terlaris dari orders_details - HANYA dari pesanan dengan status 'selesai'
        $produkTerlars = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->select('product_id', DB::raw('SUM(product_quantity) as total_terjual'))
            ->where('orders.order_status', 'selesai')
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
    
        // Total transaksi (jumlah order) dalam rentang tanggal - TETAP semua status
        $totalPenjualan = Order::whereBetween('order_date', [$startDate, $endDate])->count();
    
        // Total pendapatan dalam rentang tanggal - HANYA dari pesanan dengan status 'selesai'
        $totalPendapatan = Order::whereBetween('order_date', [$startDate, $endDate])
            ->where('order_status', 'selesai')
            ->sum('total_price');
    
        // Jumlah total produk terjual dari orders_details dalam rentang tanggal - HANYA dari pesanan dengan status 'selesai'
        $produkTerjual = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->where('orders.order_status', 'selesai')
            ->sum('product_quantity');
    
        // Total qty untuk perhitungan persentase - HANYA dari pesanan dengan status 'selesai'
        $totalQty = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->where('orders.order_status', 'selesai')
            ->sum('product_quantity');
    
        // Produk terlaris dari orders_details dalam rentang tanggal - HANYA dari pesanan dengan status 'selesai'
        $produkTerlars = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->select('product_id', DB::raw('SUM(product_quantity) as total_terjual'))
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->where('orders.order_status', 'selesai')
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
        // Total transaksi (jumlah order) - TETAP semua status
        $totalPenjualan = Order::whereBetween('order_date', [$startDate, $endDate])->count();
        
        // Total pendapatan - HANYA dari pesanan dengan status 'selesai'
        $totalPendapatan = Order::whereBetween('order_date', [$startDate, $endDate])
            ->where('order_status', 'selesai')
            ->sum('total_price');
        
        // Produk terjual - HANYA dari pesanan dengan status 'selesai'
        $produkTerjual = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->where('orders.order_status', 'selesai')
            ->sum('product_quantity');
    
        // Total qty untuk perhitungan persentase - HANYA dari pesanan dengan status 'selesai'
        $totalQty = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->where('orders.order_status', 'selesai')
            ->sum('product_quantity');
    
        // Produk terlaris - HANYA dari pesanan dengan status 'selesai'
        $produkTerlars = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id_orders')
            ->select('product_id', DB::raw('SUM(product_quantity) as total_terjual'))
            ->whereBetween('orders.order_date', [$startDate, $endDate])
            ->where('orders.order_status', 'selesai')
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