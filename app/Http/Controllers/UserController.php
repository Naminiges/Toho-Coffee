<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

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
        $stats = [
            'total_orders'     => Order::count(),
            'total_revenue'    => Order::sum('total_price'),
            'total_users'      => User::where('role', 'user')->count(),
            'total_customers'  => User::where('role', 'user')->count(),
            'total_staff'      => User::where('role', 'staff')->count(),
            'total_products'   => Product::count(),
        ];

        $sales_chart_data = json_encode([
            ['label' => 'Jan', 'value' => 100000],
            ['label' => 'Feb', 'value' => 150000],
            ['label' => 'Mar', 'value' => 120000],
            ['label' => 'Apr', 'value' => 180000],
        ]);

    $top_products = Product::take(3)->get();


        return view('admin.dashboard', compact('stats', 'sales_chart_data', 'top_products'));
    }
}