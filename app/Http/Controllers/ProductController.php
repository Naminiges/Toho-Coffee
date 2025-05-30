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
            $query = Product::with(['description.category', 'description.temperatureType'])
                          ->whereHas('description', function($q) {
                              // Only show active products (assuming aktif means active)
                              return $q->whereIn('category_id', [1, 2]); // Adjust as needed
                          })
                          ->where('product_status', 'aktif');

            // Handle search functionality
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('product_name', 'LIKE', "%{$searchTerm}%")
                      ->orWhereHas('description', function($subQ) use ($searchTerm) {
                          $subQ->where('product_description', 'LIKE', "%{$searchTerm}%");
                      });
                });
            }

            // Handle category filtering
            if ($request->has('category') && !empty($request->category) && $request->category !== 'all') {
                $query->whereHas('description', function($q) use ($request) {
                    $q->where('category_id', $request->category);
                });
            }

            // Handle temperature filtering
            if ($request->has('temperature') && !empty($request->temperature)) {
                $query->whereHas('description', function($q) use ($request) {
                    $q->where('temperature_id', $request->temperature);
                });
            }

            // Handle price range filtering
            if ($request->has('min_price') && $request->has('max_price')) {
                $query->whereBetween('product_price', [$request->min_price, $request->max_price]);
            }

            // Order by name or price
            $sortBy = $request->get('sort_by', 'product_name');
            $sortOrder = $request->get('sort_order', 'asc');
            
            if (in_array($sortBy, ['product_name', 'product_price', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            }

            // Get products with pagination
            $products = $query->paginate(12)->withQueryString();

            // Get categories for filter dropdown
            $categories = DB::table('categories')->get();
            $temperatureTypes = DB::table('temperature_types')->get();

            return view('products', compact('products', 'categories', 'temperatureTypes'));

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
                'category_id' => 'required|exists:categories,id_category',
                'temperature_id' => 'required|exists:temperature_types,id_temperature',
                'product_description' => 'required|string',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'product_name.required' => 'Nama produk harus diisi',
                'product_price.required' => 'Harga produk harus diisi',
                'product_price.numeric' => 'Harga produk harus berupa angka',
                'product_price.min' => 'Harga produk tidak boleh kurang dari 0',
                'product_status.required' => 'Status produk harus dipilih',
                'category_id.required' => 'Kategori produk harus dipilih',
                'temperature_id.required' => 'Tipe temperatur harus dipilih',
                'product_description.required' => 'Deskripsi produk harus diisi',
                'product_image.image' => 'File harus berupa gambar',
                'product_image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'product_image.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            DB::beginTransaction();

            // Handle image upload if provided
            $imageName = null;
            if ($request->hasFile('product_image')) {
                $imageName = time() . '_' . $request->file('product_image')->getClientOriginalName();
                $request->file('product_image')->move(public_path('images'), $imageName);
            }

            // Create product description first
            $descriptionId = DB::table('product_descriptions')->insertGetId([
                'category_id' => $validated['category_id'],
                'temperature_id' => $validated['temperature_id'],
                'product_photo' => $imageName ?? 'default-product.jpg',
                'product_description' => $validated['product_description']
            ]);

            // Create product
            Product::create([
                'description_id' => $descriptionId,
                'product_name' => $validated['product_name'],
                'product_price' => $validated['product_price'],
                'product_status' => $validated['product_status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect()->route('admin.products.index')
                           ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
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
            $product->load(['description.category', 'description.temperatureType']);
            
            // Get related products (same category)
            $relatedProducts = Product::with(['description.category', 'description.temperatureType'])
                                    ->where('product_status', 'aktif')
                                    ->whereHas('description', function($q) use ($product) {
                                        $q->where('category_id', $product->description->category_id ?? null);
                                    })
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
                'category_id' => 'required|exists:categories,id_category',
                'temperature_id' => 'required|exists:temperature_types,id_temperature',
                'product_description' => 'required|string',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            DB::beginTransaction();

            // Handle image upload if provided
            $imageName = $product->description->product_photo;
            if ($request->hasFile('product_image')) {
                // Delete old image if exists and not default
                if ($imageName && $imageName !== 'default-product.jpg' && file_exists(public_path('images/' . $imageName))) {
                    unlink(public_path('images/' . $imageName));
                }

                $imageName = time() . '_' . $request->file('product_image')->getClientOriginalName();
                $request->file('product_image')->move(public_path('images'), $imageName);
            }

            // Update product description
            DB::table('product_descriptions')
                ->where('id_description', $product->description_id)
                ->update([
                    'category_id' => $validated['category_id'],
                    'temperature_id' => $validated['temperature_id'],
                    'product_photo' => $imageName,
                    'product_description' => $validated['product_description']
                ]);

            // Update product
            $product->update([
                'product_name' => $validated['product_name'],
                'product_price' => $validated['product_price'],
                'product_status' => $validated['product_status'],
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect()->route('admin.products.index')
                           ->with('success', 'Produk berhasil diperbarui');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
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
            DB::beginTransaction();

            // Delete product image if exists
            $imageName = $product->description->product_photo ?? null;
            if ($imageName && $imageName !== 'default-product.jpg' && file_exists(public_path('images/' . $imageName))) {
                unlink(public_path('images/' . $imageName));
            }

            // Delete product (will cascade delete description due to foreign key)
            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                           ->with('success', 'Produk berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
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
            $newStatus = $product->product_status === 'aktif' ? 'nonaktif' : 'aktif';
            $product->update(['product_status' => $newStatus]);

            $message = $newStatus === 'aktif' ? 'Produk berhasil diaktifkan' : 'Produk berhasil dinonaktifkan';

            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $newStatus
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
            
            $products = Product::with(['description.category', 'description.temperatureType'])
                              ->where('product_status', 'aktif')
                              ->whereHas('description', function($q) use ($categoryId) {
                                  $q->where('category_id', $categoryId);
                              })
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
            
            $products = Product::with(['description.category', 'description.temperatureType'])
                              ->where('product_status', 'aktif')
                              ->where(function($q) use ($search) {
                                  $q->where('product_name', 'LIKE', "%{$search}%")
                                    ->orWhereHas('description', function($subQ) use ($search) {
                                        $subQ->where('product_description', 'LIKE', "%{$search}%");
                                    });
                              })
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