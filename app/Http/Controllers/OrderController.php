<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function userRiwayat(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');
        
        $query = Order::with(['orderDetails'])
            ->where('user_id', $user->id_user)
            ->orderBy('order_date', 'desc');
        
        if ($status !== 'all') {
            $statusMap = [
                'menunggu' => Order::STATUS_MENUNGGU,
                'diproses' => Order::STATUS_DIPROSES,
                'siap' => Order::STATUS_SIAP,
                'selesai' => Order::STATUS_SELESAI,
                'dibatalkan' => Order::STATUS_DIBATALKAN
            ];
            
            if (isset($statusMap[$status])) {
                $query->where('order_status', $statusMap[$status]);
            }
        }
        
        $orders = $query->paginate(10);
        
        // Manual fetch product information untuk setiap order
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                // Debug: Log struktur order detail
                \Log::info('Order Detail Attributes:', $detail->getAttributes());
                
                // Ambil data produk dari tabel products berdasarkan product_id
                if (isset($detail->product_id) && $detail->product_id) {
                    $product = \DB::table('products')
                        ->where('id_product', $detail->product_id)
                        ->first();
                    
                    if ($product) {
                        $detail->product_name = $product->product_name;
                        
                        // Ambil data product description berdasarkan description_id dari products
                        $description = \DB::table('product_descriptions')
                            ->where('id_description', $product->description_id)
                            ->first();
                        
                        if ($description) {
                            \Log::info('Found Description:', [
                                'id_description' => $description->id_description,
                                'product_photo' => $description->product_photo ?? 'NULL',
                                'category_id' => $description->category_id,
                                'temperature_id' => $description->temperature_id
                            ]);
                            
                            // Set data dari description
                            $detail->product_photo = $description->product_photo;
                            $detail->product_description = $description->product_description ?? null;
                            
                            // Ambil data category
                            if ($description->category_id) {
                                $category = \DB::table('categories')
                                    ->where('id_category', $description->category_id)
                                    ->first();
                                $detail->category_name = $category ? $category->category : 'N/A';
                                
                                \Log::info('Category lookup:', [
                                    'category_id' => $description->category_id,
                                    'found_category' => $category ? $category->category : 'NOT FOUND'
                                ]);
                            } else {
                                $detail->category_name = 'N/A';
                                \Log::warning('No category_id in description');
                            }
                            
                            // Ambil data temperature type
                            if ($description->temperature_id) {
                                $temperature = \DB::table('temperature_types')
                                    ->where('id_temperature', $description->temperature_id)
                                    ->first();
                                $detail->temperature_name = $temperature ? $temperature->temperature : 'N/A';
                                
                                \Log::info('Temperature lookup:', [
                                    'temperature_id' => $description->temperature_id,
                                    'found_temperature' => $temperature ? $temperature->temperature : 'NOT FOUND'
                                ]);
                            } else {
                                $detail->temperature_name = 'N/A';
                                \Log::warning('No temperature_id in description');
                            }
                        } else {
                            \Log::warning('Description not found for description_id: ' . $product->description_id);
                            $detail->product_photo = 'default-product.jpg';
                            $detail->category_name = 'N/A';
                            $detail->temperature_name = 'N/A';
                        }
                    } else {
                        \Log::warning('Product not found for product_id: ' . $detail->product_id);
                        $detail->product_name = 'Produk Tidak Ditemukan';
                        $detail->product_photo = 'default-product.jpg';
                        $detail->category_name = 'N/A';
                        $detail->temperature_name = 'N/A';
                    }
                } else {
                    \Log::warning('No product_id in order detail');
                    $detail->product_name = 'Produk Tidak Tersedia';
                    $detail->product_photo = 'default-product.jpg';
                    $detail->category_name = 'N/A';
                    $detail->temperature_name = 'N/A';
                }
            }
        }
        
        return view('user.riwayat', compact('orders', 'status'));
    }
    
    public function userDetailPesanan($orderId)
    {
        $user = Auth::user();
        
        $order = Order::with(['orderDetails'])
            ->where('id_orders', $orderId)
            ->where('user_id', $user->id_user)
            ->firstOrFail();
        
        // Manual fetch product information untuk detail pesanan
        foreach ($order->orderDetails as $detail) {
            if ($detail->product_id) {
                // Ambil data produk dari tabel products
                $product = \DB::table('products')
                    ->where('id_product', $detail->product_id)
                    ->first();
                
                if ($product) {
                    $detail->product_name = $product->product_name;
                    
                    // Ambil data product description berdasarkan description_id dari products
                    $description = \DB::table('product_descriptions')
                        ->where('id_description', $product->description_id)
                        ->first();
                    
                    if ($description) {
                        // Set product_photo dari description (nama file saja)
                        $detail->product_photo = $description->product_photo;
                        $detail->product_description = $description->product_description;
                        
                        // Ambil data category
                        if ($description->category_id) {
                            $category = \DB::table('categories')
                                ->where('id_category', $description->category_id)
                                ->first();
                            $detail->category_name = $category ? $category->category : 'N/A';
                        } else {
                            $detail->category_name = 'N/A';
                        }
                        
                        // Ambil data temperature type
                        if ($description->temperature_id) {
                            $temperature = \DB::table('temperature_types')
                                ->where('id_temperature', $description->temperature_id)
                                ->first();
                            $detail->temperature_name = $temperature ? $temperature->temperature : 'N/A';
                        } else {
                            $detail->temperature_name = 'N/A';
                        }
                    } else {
                        $detail->product_photo = null;
                        $detail->product_description = null;
                        $detail->category_name = 'N/A';
                        $detail->temperature_name = 'N/A';
                    }
                } else {
                    $detail->product_name = 'Produk Tidak Ditemukan';
                    $detail->product_photo = null;
                    $detail->category_name = 'N/A';
                    $detail->temperature_name = 'N/A';
                }
            } else {
                $detail->product_name = 'Produk Tidak Tersedia';
                $detail->product_photo = null;
                $detail->category_name = 'N/A';
                $detail->temperature_name = 'N/A';
            }
        }
        
        return view('user.detail-pesanan', compact('order'));
    }
    
    public function updateStatus(Request $request, $orderId)
    {
        $user = Auth::user();
        
        $order = Order::where('id_orders', $orderId)
                     ->where('user_id', $user->id_user)
                     ->firstOrFail();
        
        // Hanya bisa mengambil pesanan jika status 'siap'
        if ($order->order_status === 'siap') {
            $order->update([
                'order_status' => 'selesai',
                'order_complete' => now()
            ]);
            
            return redirect()->back()->with('success', 'Pesanan berhasil diambil!');
        }
        
        return redirect()->back()->with('error', 'Pesanan tidak dapat diambil saat ini.');
    }
}