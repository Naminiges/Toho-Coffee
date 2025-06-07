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

    public function toggleRole(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Toggle status
            $newRole = $user->role === 'user' ? 'staff' : 'user';
            $user->role = $newRole;
            $user->save();
            
            $statusText = $newRole === 'user' ? 'menjadi user' : 'menjadi staff';
            $userName = $user->name;
            
            return redirect()->back()->with('success', "Akun {$userName} berhasil {$statusText}.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah role akun.');
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
        // Total pendapatan dari orders dengan status 'selesai' saja
        $totalPendapatan = Order::where('order_status', 'selesai')->sum('total_price');

        // Total pesanan (jumlah baris orders) - tetap semua status
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

        // Chart data untuk orders dengan status 'selesai' saja
        $sales_chart_data = DB::table('orders')
            ->selectRaw('DATE(order_date) as date, SUM(total_price) as total')
            ->where('order_status', 'selesai') // Tambahkan filter status selesai
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

            // Ambil data penjualan hanya untuk status 'selesai'
            $dailySales = DB::table('orders')
                ->whereDate('order_date', $date)
                ->where('order_status', 'selesai') // Tambahkan filter status selesai
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
            'sales_chart_data',
            'labels',
            'sales'
        ));
    }
}