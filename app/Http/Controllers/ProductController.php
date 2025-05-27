<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Product::with(['description', 'category', 'temperatureType'])
                          ->active(); // Only show active products

            // Handle search functionality
            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            // Handle category filtering
            if ($request->has('category') && !empty($request->category) && $request->category !== 'all') {
                $query->byCategory($request->category);
            }

            // Handle temperature filtering
            if ($request->has('temperature') && !empty($request->temperature)) {
                $query->byTemperature($request->temperature);
            }

            // Handle price range filtering
            if ($request->has('min_price') && $request->has('max_price')) {
                $query->priceBetween($request->min_price, $request->max_price);
            }

            // Order by name or price
            $sortBy = $request->get('sort_by', 'product_name');
            $sortOrder = $request->get('sort_order', 'asc');
            
            if (in_array($sortBy, ['product_name', 'product_price', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            }

            // Get products with pagination
            $products = $query->paginate(12)->withQueryString();

            // Get categories for filter dropdown (if needed)
            $categories = DB::table('categories')->get();

            return view('products', compact('products', 'categories'));

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = DB::table('categories')->get();
            $temperatureTypes = DB::table('temperature_types')->get();
            
            return view('admin.products.create', compact('categories', 'temperatureTypes'));
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_price' => 'required|numeric|min:0',
                'product_status' => 'required|in:aktif,nonaktif',
                'description_id' => 'required|exists:product_descriptions,id_description',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'product_name.required' => 'Nama produk harus diisi',
                'product_price.required' => 'Harga produk harus diisi',
                'product_price.numeric' => 'Harga produk harus berupa angka',
                'product_price.min' => 'Harga produk tidak boleh kurang dari 0',
                'product_status.required' => 'Status produk harus dipilih',
                'description_id.required' => 'Deskripsi produk harus dipilih',
                'description_id.exists' => 'Deskripsi produk tidak valid',
                'product_image.image' => 'File harus berupa gambar',
                'product_image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'product_image.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            // Handle image upload if provided
            if ($request->hasFile('product_image')) {
                $imageName = time() . '.' . $request->product_image->extension();
                $request->product_image->move(public_path('images/products'), $imageName);
                $validated['product_image'] = $imageName;
            }

            Product::create($validated);

            return redirect()->route('admin.products.index')
                           ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            $product->load(['description', 'category', 'temperatureType']);
            
            // Get related products (same category)
            $relatedProducts = Product::with(['description', 'category'])
                                    ->active()
                                    ->byCategory($product->category->id_category ?? null)
                                    ->where('id_product', '!=', $product->id_product)
                                    ->limit(4)
                                    ->get();

            return view('product-detail', compact('product', 'relatedProducts'));

        } catch (\Exception $e) {
            return redirect()->route('products')
                           ->with('error', 'Produk tidak ditemukan atau terjadi kesalahan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        try {
            $categories = DB::table('categories')->get();
            $temperatureTypes = DB::table('temperature_types')->get();
            $product->load('description');
            
            return view('admin.products.edit', compact('product', 'categories', 'temperatureTypes'));
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memuat form edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_price' => 'required|numeric|min:0',
                'product_status' => 'required|in:aktif,nonaktif',
                'description_id' => 'required|exists:product_descriptions,id_description',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'product_name.required' => 'Nama produk harus diisi',
                'product_price.required' => 'Harga produk harus diisi',
                'product_price.numeric' => 'Harga produk harus berupa angka',
                'product_price.min' => 'Harga produk tidak boleh kurang dari 0',
                'product_status.required' => 'Status produk harus dipilih',
                'description_id.required' => 'Deskripsi produk harus dipilih',
                'description_id.exists' => 'Deskripsi produk tidak valid',
                'product_image.image' => 'File harus berupa gambar',
                'product_image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'product_image.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            // Handle image upload if provided
            if ($request->hasFile('product_image')) {
                // Delete old image if exists
                if ($product->product_image && file_exists(public_path('images/products/' . $product->product_image))) {
                    unlink(public_path('images/products/' . $product->product_image));
                }

                $imageName = time() . '.' . $request->product_image->extension();
                $request->product_image->move(public_path('images/products'), $imageName);
                $validated['product_image'] = $imageName;
            }

            $product->update($validated);

            return redirect()->route('admin.products.index')
                           ->with('success', 'Produk berhasil diperbarui');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Delete product image if exists
            if ($product->product_image && file_exists(public_path('images/products/' . $product->product_image))) {
                unlink(public_path('images/products/' . $product->product_image));
            }

            $product->delete();

            return redirect()->route('admin.products.index')
                           ->with('success', 'Produk berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Toggle product status (activate/deactivate)
     */
    public function toggleStatus(Product $product)
    {
        try {
            if ($product->is_active) {
                $product->deactivate();
                $message = 'Produk berhasil dinonaktifkan';
            } else {
                $product->activate();
                $message = 'Produk berhasil diaktifkan';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $product->fresh()->product_status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products by category (AJAX)
     */
    public function getByCategory(Request $request)
    {
        try {
            $categoryId = $request->get('category_id');
            
            $products = Product::with(['description', 'category'])
                              ->active()
                              ->byCategory($categoryId)
                              ->get();

            return response()->json([
                'success' => true,
                'products' => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search products (AJAX)
     */
    public function search(Request $request)
    {
        try {
            $search = $request->get('search');
            
            $products = Product::with(['description', 'category'])
                              ->active()
                              ->search($search)
                              ->limit(10)
                              ->get();

            return response()->json([
                'success' => true,
                'products' => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}