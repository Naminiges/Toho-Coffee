<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
