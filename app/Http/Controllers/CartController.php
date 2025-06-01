<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');

        $cartItem = Cart::where('user_id', $user->id_user)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->item_quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id_user,
                'product_id' => $productId,
                'item_quantity' => 1
            ]);
        }

        // Set session untuk menampilkan popup
        session()->flash('cart_added', true);
        session()->flash('added_product_name', $request->input('product_name', 'Produk'));

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function showCart()  
    {
        $user = Auth::user();
        $items = Cart::with(['product','product.temperatureType'])->where('user_id', $user->id_user)->get();
        return view('user.keranjang', compact('items'));
    }

    public function updateQuantity(Request $request, $id)
    {
        // Gunakan id_cart sebagai primary key dan user_id sebagai foreign key
        $item = Cart::where('id_cart', $id)->where('user_id', Auth::user()->id_user)->firstOrFail();

        if ($request->action === 'increase') {
            $item->item_quantity += 1; // Sesuaikan dengan field yang benar
        } elseif ($request->action === 'decrease' && $item->item_quantity > 1) {
            $item->item_quantity -= 1; // Sesuaikan dengan field yang benar
        }

        $item->save();
        return back()->with('success', 'Kuantitas diperbarui.');
    }

    public function removeItem($id)
    {
        // Gunakan id_cart sebagai primary key dan user_id sebagai foreign key
        Cart::where('id_cart', $id)->where('user_id', Auth::user()->id_user)->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $user = Auth::user();
        
        // Ambil data keranjang dengan relasi ke product dan product_descriptions
        $cartItems = Cart::with([
            'product', 
            'product.temperatureType:id_temperature,temperature',
            'product.description'
        ])->where('user_id', $user->id_user)->get();

        // Redirect jika keranjang kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('user-keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Hitung subtotal, ppn, dan total
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->product_price * $item->item_quantity;
        });
        
        $ppn = $subtotal * 0.1;
        $total = $subtotal + $ppn;

        return view('user.checkout', compact('cartItems', 'subtotal', 'ppn', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'member_bank' => 'required|string|max:255',
            'bank_number' => 'required|string|max:255',
            'pickup_time' => 'required|date|after:now',
            'transfer_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Ambil data keranjang
            $cartItems = Cart::with('product')->where('user_id', $user->id_user)->get();
            
            if ($cartItems->isEmpty()) {
                DB::rollBack();
                return redirect()->route('user-keranjang')->with('error', 'Keranjang belanja Anda kosong.');
            }

            // Hitung total
            $subtotal = $cartItems->sum(fn($item) => $item->product->product_price * $item->item_quantity);
            $ppn = $subtotal * 0.1;
            $total = $subtotal + $ppn;

            // Handle upload bukti transfer TERLEBIH DAHULU
            $transferProofPath = '';
            if ($request->hasFile('transfer_proof')) {
                $file = $request->file('transfer_proof');
                $extension = $file->getClientOriginalExtension();
                
                // Generate temporary filename dulu
                $tempFileName = 'TEMP-' . time() . '.' . $extension;
                
                // Pastikan direktori ada
                $uploadPath = public_path('images/proof');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Pindahkan file ke direktori tujuan dengan nama temp
                $file->move($uploadPath, $tempFileName);
                $transferProofPath = 'images/proof/' . $tempFileName;
            }

            // Buat order baru dengan semua data yang diperlukan
            $order = Order::create([
                'orders_code' => 'TEMP-' . substr(time(), -6), // Temporary code pendek
                'staff_name' => '',
                'user_id' => $user->id_user,
                'member_name' => $validated['name'],
                'member_notes' => $validated['notes'] ?? '',
                'member_bank' => $validated['member_bank'],
                'proof_payment' => $transferProofPath, // Langsung isi dengan path file
                'order_status' => 'menunggu',
                'total_price' => $total,
                'order_date' => now(),
                'order_complete' => null
            ]);

            // Generate order code yang benar setelah order dibuat (lebih pendek)
            $orderCode = 'ORD-' . $order->id_orders . '-' . date('ymd') . substr(uniqid(), -4);
            
            // Rename file dengan nama yang benar dan update order
            if ($transferProofPath) {
                $extension = pathinfo($transferProofPath, PATHINFO_EXTENSION);
                $newFileName = 'ORD-' . $order->id_orders . '.' . $extension;
                $newPath = 'images/proof/' . $newFileName;
                
                // Rename file
                rename(public_path($transferProofPath), public_path($newPath));
                
                // Update order dengan order code dan path file yang benar
                $order->update([
                    'orders_code' => $orderCode,
                    'proof_payment' => $newPath
                ]);
            } else {
                // Jika tidak ada file, tetap update order code
                $order->update(['orders_code' => $orderCode]);
            }

            // Buat order details untuk setiap item di keranjang
            foreach ($cartItems as $cartItem) {
                OrderDetail::create([
                    'order_id' => $order->id_orders,
                    'pickup_telephone' => $validated['phone'],
                    'pickup_email' => $validated['email'],
                    'pickup_place' => 'TOHO Coffee - Cabang Utama',
                    'pickup_time' => $validated['pickup_time'],
                    'pickup_method' => 'pickup',
                    'payment_method' => 'transfer',
                    'payment_status' => 'pending',
                    'bank_number' => $validated['bank_number'],
                    'product_id' => $cartItem->product_id,
                    'product_price' => $cartItem->product->product_price,
                    'product_quantity' => $cartItem->item_quantity
                ]);
            }

            // Hapus items dari keranjang setelah checkout berhasil
            Cart::where('user_id', $user->id_user)->delete();

            DB::commit();

            return redirect()->route('user-riwayat')->with('success', 'Pesanan berhasil dibuat dengan kode: ' . $orderCode);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Hapus file yang sudah diupload jika ada error
            if (isset($transferProofPath) && file_exists(public_path($transferProofPath))) {
                unlink(public_path($transferProofPath));
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    public function getUserCartItems()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id_user)
                        ->pluck('product_id')
                        ->toArray();
        
        return $cartItems;
    }
}
