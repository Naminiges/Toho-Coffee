<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function landingPage()
    {
        try {
            $products = Product::with(['description', 'category', 'temperatureType'])
                            ->active()
                            ->take(4)
                            ->get();

            return view('welcome', compact('products'));
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan saat memuat: ' . $e->getMessage());
        }
    }


    /**
     * Display customers (users with role 'user') for admin management
     */
    public function adminCustomers(Request $request)
    {
        $query = User::where('role', 'user');
        
        // Search functionality (optional)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $customers = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.manajemen-pelanggan', compact('customers'));
    }
    
    /**
     * Display staff (users with role 'staff') for admin management
     */
    public function adminStaff(Request $request)
    {
        $query = User::where('role', 'staff');
        
        // Search functionality (optional)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $staffs = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.manajemen-staff', compact('staffs'));
    }
    
    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Toggle status
            $newStatus = $user->user_status === 'aktif' ? 'nonaktif' : 'aktif';
            $user->user_status = $newStatus;
            $user->save();
            
            $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
            $userName = $user->name;
            
            return redirect()->back()->with('success', "Akun {$userName} berhasil {$statusText}.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status akun.');
        }
    }
    
    /**
     * Bulk action for multiple users (optional feature)
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id_user'
        ]);
        
        try {
            $action = $request->action;
            $userIds = $request->user_ids;
            $status = $action === 'activate' ? 'aktif' : 'nonaktif';
            
            $affected = User::whereIn('id_user', $userIds)->update(['user_status' => $status]);
            
            $actionText = $action === 'activate' ? 'diaktifkan' : 'dinonaktifkan';
            
            return redirect()->back()->with('success', "{$affected} akun berhasil {$actionText}.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses aksi bulk.');
        }
    }

    public function adminDashboard()
    {
        // Total pendapatan dari orders
        $totalPendapatan = Order::sum('total_price');

        // Total pesanan (jumlah baris orders)
        $totalPesanan = Order::count();

        // Total pelanggan (user dengan role = user)
        $totalPelanggan = User::where('role', 'user')->count();

        // Total produk tersedia (produk aktif)
        $produkTersedia = Product::where('product_status', 'aktif')->count();

        $stats = [
            'total_revenue' => $totalPendapatan,
            'total_orders' => $totalPesanan,
            'total_customers' => $totalPelanggan,
            'total_products' => $produkTersedia,
        ];

        // Produk terlaris
        $produkTerlars = DB::table('orders_details')
            ->select('product_id', DB::raw('SUM(product_quantity) as total_terjual'))
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $product = Product::find($item->product_id);
                return [
                    'nama_produk' => $product->product_name ?? '-',
                    'qty' => $item->total_terjual,
                ];
            });

            $top_products = DB::table('orders_details')
            ->select('product_id', DB::raw('SUM(product_quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $product = Product::find($item->product_id);
                return [
                    'name' => $product->product_name ?? '-',
                    'total_sold' => (int) $item->total_sold,
                ];
            });

            $top_product = $top_products->first();
            $top_product_name = null;

            if ($top_product) {
                $product = Product::where('product_name', $top_product['name'])->first();

                if ($product) {
                    $top_product_name = $product->product_name . ' (' . $top_product['total_sold'] . ' terjual)';
                }
            }

            $sales_chart_data = DB::table('orders')
            ->selectRaw('DATE(order_date) as date, SUM(total_price) as total')
            ->whereBetween('order_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->translatedFormat('d M'),
                    'total' => (float) $item->total,
                ];
            });

            $sevenDays = collect();
            $salesData = collect();

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $dayName = Carbon::now()->subDays($i)->translatedFormat('l');

                $sevenDays->push($dayName);

                $dailySales = DB::table('orders')
                    ->whereDate('order_date', $date)
                    ->sum('total_price');

                $salesData->push((float) $dailySales);
            }

            // Simpan hasil ke variabel yang akan dikirim ke view
            $labels = $sevenDays;
            $sales = $salesData;

        return view('admin.dashboard', compact(
        'totalPendapatan',
        'totalPesanan',
        'totalPelanggan',
        'produkTersedia',
        'stats',
        'produkTerlars',
        'sales_chart_data',
        'top_product_name',
        'top_products',
        'labels',
        'sales' // tambahkan ini!
    ));
    }
}