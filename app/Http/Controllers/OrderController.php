<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Optimized method to load order details with all related data in minimal queries
     */
    private function loadOrdersWithDetails($orders)
    {
        // Extract all product IDs from all order details
        $productIds = $orders->flatMap(function($order) {
            return $order->orderDetails->pluck('product_id')->filter();
        })->unique()->values();

        if ($productIds->isEmpty()) {
            return $orders;
        }

        // Single query to get all products with their descriptions, categories, and temperatures
        $productsData = DB::table('products as p')
            ->leftJoin('product_descriptions as pd', 'p.description_id', '=', 'pd.id_description')
            ->leftJoin('categories as c', 'pd.category_id', '=', 'c.id_category')
            ->leftJoin('temperature_types as tt', 'pd.temperature_id', '=', 'tt.id_temperature')
            ->whereIn('p.id_product', $productIds)
            ->select([
                'p.id_product',
                'p.product_name',
                'pd.product_photo',
                'pd.product_description',
                'c.category',
                'tt.temperature'
            ])
            ->get()
            ->keyBy('id_product');

        // Apply the data to order details
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                if ($detail->product_id && isset($productsData[$detail->product_id])) {
                    $productData = $productsData[$detail->product_id];
                    
                    $detail->product_name = $productData->product_name;
                    $detail->product_photo = $productData->product_photo ?? 'default-product.jpg';
                    $detail->product_description = $productData->product_description;
                    $detail->category_name = $productData->category ?? 'N/A';
                    $detail->temperature_name = $productData->temperature ?? 'N/A';
                } else {
                    $this->setDefaultProductData($detail);
                }
            }
            
            // Set order status information
            $order->status_text = $this->getStatusText($order->order_status);
            $order->status_badge_class = $this->getStatusBadgeClass($order->order_status);
            
            // Calculate total amount if needed
            if (!isset($order->total_amount)) {
                $order->total_amount = $order->orderDetails->sum(function($detail) {
                    return $detail->product_price * $detail->product_quantity;
                });
            }
            
            // Set customer name
            $order->customer_name = $order->member_name ?? ($order->user ? $order->user->name : 'Guest');
        }

        return $orders;
    }

    /**
     * Set default product data when product is not found
     */
    private function setDefaultProductData($detail)
    {
        $detail->product_name = 'Produk Tidak Tersedia';
        $detail->product_photo = 'default-product.jpg';
        $detail->product_description = null;
        $detail->category_name = 'N/A';
        $detail->temperature_name = 'N/A';
    }

    /**
     * User - Riwayat Pesanan (OPTIMIZED)
     */
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
        
        // Use optimized loading method
        $this->loadOrdersWithDetails($orders);
        
        return view('user.riwayat', compact('orders', 'status'));
    }

    /**
     * User - Detail Pesanan (OPTIMIZED)
     */
    public function userDetailPesanan($orderId)
    {
        $user = Auth::user();
        
        $order = Order::with(['orderDetails'])
            ->where('id_orders', $orderId)
            ->where('user_id', $user->id_user)
            ->firstOrFail();
        
        // Load single order details efficiently
        $this->loadOrdersWithDetails(collect([$order]));
        
        return view('user.detail-pesanan', compact('order'));
    }

    /**
     * Admin - Manajemen Pesanan (OPTIMIZED)
     */
    public function adminManajemenPesanan(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');
        $date = $request->get('date');
        
        $query = Order::with(['orderDetails', 'user'])
            ->orderBy('order_date', 'desc');
        
        // Apply filters
        if ($status !== 'all') {
            $statusMap = [
                'pending' => Order::STATUS_MENUNGGU,
                'processing' => Order::STATUS_DIPROSES,
                'ready' => Order::STATUS_SIAP,
                'completed' => Order::STATUS_SELESAI,
                'cancelled' => Order::STATUS_DIBATALKAN
            ];
            
            if (isset($statusMap[$status])) {
                $query->where('order_status', $statusMap[$status]);
            }
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id_orders', 'like', '%' . $search . '%')
                ->orWhere('member_name', 'like', '%' . $search . '%')
                ->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }
        
        if ($date) {
            $query->whereDate('order_date', $date);
        }
        
        $orders = $query->paginate(10);
        
        // Use optimized loading method
        $this->loadOrdersWithDetails($orders);
        
        return view('admin.manajemen-pesanan', compact('orders', 'status'));
    }

    /**
     * Staff Dashboard (OPTIMIZED)
     */
    public function staffDashboard(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');
        $date = $request->get('date');
        
        $query = Order::with(['orderDetails', 'user'])
            ->orderBy('order_date', 'desc');
        
        // Apply same filters as admin
        if ($status !== 'all') {
            $statusMap = [
                'pending' => Order::STATUS_MENUNGGU,
                'processing' => Order::STATUS_DIPROSES,
                'ready' => Order::STATUS_SIAP,
                'completed' => Order::STATUS_SELESAI,
                'cancelled' => Order::STATUS_DIBATALKAN
            ];
            
            if (isset($statusMap[$status])) {
                $query->where('order_status', $statusMap[$status]);
            }
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id_orders', 'like', '%' . $search . '%')
                ->orWhere('member_name', 'like', '%' . $search . '%')
                ->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }
        
        if ($date) {
            $query->whereDate('order_date', $date);
        }
        
        $orders = $query->paginate(10);
        
        // Use optimized loading method
        $this->loadOrdersWithDetails($orders);
        
        return view('staff.staff-dashboard', compact('orders', 'status'));
    }

    /**
     * Update Order Status - Optimized
     */
    public function updateOrderStatus(Request $request, $orderId)
    {
        try {
            $request->validate([
                'status' => 'required|in:menunggu,diproses,siap,selesai,dibatalkan'
            ]);
            
            $order = Order::findOrFail($orderId);
            
            // Single update query
            $updateData = [
                'order_status' => $request->status,
                'staff_name' => Auth::user()->name,
            ];

            if ($request->status === 'diproses') {
                $order->orderDetails()->update(['payment_status' => 'lunas']);
            }
            
            if ($request->status === 'selesai') {
                $updateData['order_complete'] = now();
            }
            
            $order->update($updateData);
            
            // Return JSON for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status pesanan berhasil diperbarui!',
                    'status_text' => $this->getStatusText($request->status),
                    'status_class' => $this->getStatusBadgeClass($request->status)
                ]);
            }
            
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
            
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui status pesanan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Admin Detail Pesanan (OPTIMIZED)
     */
    public function adminDetailPesanan($orderId)
    {
        $order = Order::with(['orderDetails', 'user'])
            ->findOrFail($orderId);
        
        // Load order details efficiently
        $this->loadOrdersWithDetails(collect([$order]));
        
        // Additional detail page specific data
        $order->customer_email = $order->orderDetails->first()->pickup_email ?? 'N/A';
        $order->customer_phone = $order->orderDetails->first()->pickup_telephone ?? 'N/A';
        
        // Generate timeline data
        $timeline = $this->generateOrderTimeline($order);
        
        return view('admin.detail-pesanan', compact('order', 'timeline'));
    }

    /**
     * Staff Detail Pesanan (OPTIMIZED)
     */
    public function staffDetailPesanan($orderId)
    {
        $order = Order::with(['orderDetails', 'user'])
            ->findOrFail($orderId);
        
        // Load order details efficiently
        $this->loadOrdersWithDetails(collect([$order]));
        
        // Additional detail page specific data
        $order->customer_email = $order->orderDetails->first()->pickup_email ?? 'N/A';
        $order->customer_phone = $order->orderDetails->first()->pickup_telephone ?? 'N/A';
        
        // Generate timeline data
        $timeline = $this->generateOrderTimeline($order);
        
        return view('staff.staff-detail', compact('order', 'timeline'));
    }

    /**
     * Update Status (User)
     */
    public function updateStatus($orderId)
    {
        $user = Auth::user();
        
        $order = Order::where('id_orders', $orderId)
                     ->where('user_id', $user->id_user)
                     ->firstOrFail();
        
        if ($order->order_status === 'siap') {
            $order->update([
                'order_status' => 'selesai',
                'order_complete' => now()
            ]);
            
            return redirect()->back()->with('success', 'Pesanan berhasil diambil!');
        }
        
        return redirect()->back()->with('error', 'Pesanan tidak dapat diambil saat ini.');
    }

    /**
     * Invoice (OPTIMIZED)
     */
    public function invoice($orderId)
    {
        $user = Auth::user();
        
        if ($user->role === 'admin' || $user->role === 'staff') {
            $order = Order::with(['orderDetails', 'user'])->findOrFail($orderId);
        } else {
            $order = Order::with(['orderDetails'])
                ->where('id_orders', $orderId)
                ->where('user_id', $user->id_user)
                ->firstOrFail();
        }
        
        // Load order details efficiently
        $this->loadOrdersWithDetails(collect([$order]));
        
        // Calculate totals
        $subtotal = $order->orderDetails->sum(function($detail) {
            return $detail->product_price * $detail->product_quantity;
        });
        
        $taxRate = 0.10;
        $taxAmount = $subtotal * $taxRate;
        $grandTotal = $subtotal + $taxAmount;
        
        // Customer and payment info
        $customerInfo = [
            'name' => $order->member_name ?? ($order->user ? $order->user->name : 'Guest'),
            'email' => $order->orderDetails->first()->pickup_email ?? 'N/A',
            'phone' => $order->orderDetails->first()->pickup_telephone ?? 'Tidak tersedia',
            'address' => $order->orderDetails->first()->pickup_place ?? 'TOHO Coffee - Cabang Utama'
        ];
        
        $paymentInfo = [
            'method' => $order->orderDetails->first()->payment_method ?? 'Transfer Bank',
            'bank_number' => $order->orderDetails->first()->bank_number ?? 'Tidak tersedia',
            'payment_status' => $order->orderDetails->first()->payment_status ?? 'Belum Lunas',
            'bank_name' => $order->member_bank ?? 'Transfer Bank'
        ];
        
        $invoiceData = [
            'order' => $order,
            'customer' => $customerInfo,
            'payment' => $paymentInfo,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'grand_total' => $grandTotal,
            'invoice_number' => 'INV-' . str_pad($order->id_orders, 5, '0', STR_PAD_LEFT),
            'invoice_date' => $order->order_date->format('d/M/Y'),
            'due_date' => $order->order_date->addDays(1)->format('d/M/Y')
        ];
        
        return view('invoice', $invoiceData);
    }

    // Helper methods remain the same
    public function getStatusBadgeClass($status)
    {
        $statusClasses = [
            Order::STATUS_MENUNGGU => 'status-pending',
            Order::STATUS_DIPROSES => 'status-processing',
            Order::STATUS_SIAP => 'status-ready',
            Order::STATUS_SELESAI => 'status-completed',
            Order::STATUS_DIBATALKAN => 'status-cancelled'
        ];
        
        return $statusClasses[$status] ?? 'status-pending';
    }

    public function getStatusText($status)
    {
        $statusTexts = [
            Order::STATUS_MENUNGGU => 'Menunggu',
            Order::STATUS_DIPROSES => 'Diproses',
            Order::STATUS_SIAP => 'Siap',
            Order::STATUS_SELESAI => 'Selesai',
            Order::STATUS_DIBATALKAN => 'Dibatalkan'
        ];
        
        return $statusTexts[$status] ?? 'Tidak Diketahui';
    }

    private function generateOrderTimeline($order)
    {
        $timeline = [];
        
        $timeline[] = [
            'date' => $order->order_date->format('Y-m-d H:i'),
            'text' => 'Pesanan Dibuat',
            'completed' => true
        ];
        
        if ($order->orderDetails->first() && $order->orderDetails->first()->payment_status === 'Lunas') {
            $timeline[] = [
                'date' => $order->order_date->addMinutes(5)->format('Y-m-d H:i'),
                'text' => 'Pembayaran Dikonfirmasi',
                'completed' => true
            ];
        }
        
        $currentStatus = $order->order_status;
        
        if (in_array($currentStatus, [Order::STATUS_DIPROSES, Order::STATUS_SIAP, Order::STATUS_SELESAI])) {
            $timeline[] = [
                'date' => $order->order_date->addMinutes(30)->format('Y-m-d H:i'),
                'text' => 'Pesanan Diproses',
                'completed' => true
            ];
        }
        
        if (in_array($currentStatus, [Order::STATUS_SIAP, Order::STATUS_SELESAI])) {
            $timeline[] = [
                'date' => $order->order_date->addHour()->format('Y-m-d H:i'),
                'text' => 'Pesanan Siap Diambil',
                'completed' => true
            ];
        }
        
        if ($currentStatus === Order::STATUS_SELESAI) {
            $completeTime = $order->order_complete ?? $order->order_date->addHours(2);
            $timeline[] = [
                'date' => $completeTime->format('Y-m-d H:i'),
                'text' => 'Pesanan Selesai',
                'completed' => true
            ];
        }
        
        if ($currentStatus === Order::STATUS_DIBATALKAN) {
            $timeline[] = [
                'date' => $order->updated_at->format('Y-m-d H:i'),
                'text' => 'Pesanan Dibatalkan',
                'completed' => true
            ];
        }
        
        return $timeline;
    }

    public function __construct()
    {
        view()->composer('*', function ($view) {
            $view->with('orderHelper', $this);
        });
    }
}