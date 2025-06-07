<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\TemperatureType;
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
            $categories = Category::all();

            // Get temperature types 
            $temperatureTypes = TemperatureType::all();

            return compact('products', 'categories', 'temperatureTypes');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    public function guestKatalog(Request $request)
    {
        try {
        $data = $this->index($request);
        return view('products', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    public function userKatalog(Request $request)
    {
        try {
        $data = $this->index($request);
        return view('user.katalog', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    private function getProductData(Request $request)
    {
        $query = Product::with(['description.category', 'description.temperatureType'])
                    ->orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        if ($request->has('category') && !empty($request->category) && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        if ($request->has('status') && !empty($request->status) && $request->status !== 'all') {
            $request->status === 'aktif' ? $query->active() : $query->inactive();
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::all();
        $temperatureType = TemperatureType::all();

        return compact('products', 'categories', 'temperatureType');
    }

    public function adminIndex(Request $request)
    {
        try {
        $data = $this->getProductData($request);
        return view('admin.manajemen-produk', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    public function staffIndex(Request $request)
    {
        try {
            $data = $this->getProductData($request);
            return view('staff.staff-produk', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = Category::all();
            $temperatureTypes = TemperatureType::all();
            
            return view('admin.tambah-produk', compact('categories', 'temperatureTypes'));
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
            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string|in:kopi,non-kopi,mix',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'temperature' => 'required|string|in:active,inactive'
            ], [
                'name.required' => 'Nama produk harus diisi',
                'name.max' => 'Nama produk maksimal 255 karakter',
                'category.required' => 'Kategori harus dipilih',
                'category.in' => 'Kategori tidak valid',
                'description.required' => 'Deskripsi produk harus diisi',
                'price.required' => 'Harga produk harus diisi',
                'price.numeric' => 'Harga produk harus berupa angka',
                'price.min' => 'Harga produk tidak boleh kurang dari 0',
                'image.required' => 'Gambar produk harus diupload',
                'image.image' => 'File harus berupa gambar',
                'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'image.max' => 'Ukuran gambar maksimal 2MB',
                'temperature.required' => 'Temperature harus dipilih',
                'temperature.in' => 'Temperature tidak valid'
            ]);

            // Get category ID based on category name
            $category = Category::where('category', $validated['category'])->first();
            if (!$category) {
                throw new \Exception('Kategori tidak ditemukan');
            }

            // Get temperature ID based on temperature value
            // Assuming 'active' means 'cold' and 'inactive' means 'hot'
            $temperatureValue = $validated['temperature'] === 'active' ? 'cold' : 'hot';
            $temperatureType = TemperatureType::where('temperature', $temperatureValue)->first();
            if (!$temperatureType) {
                throw new \Exception('Temperature type tidak ditemukan');
            }

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                
                // Store image in public/images/products directory
                $image->move(public_path('images/products'), $imageName);
                $imagePath = 'images/products/' . $imageName;
            }

            // Create ProductDescription first
            $productDescription = ProductDescription::create([
                'category_id' => $category->id_category,
                'temperature_id' => $temperatureType->id_temperature,
                'product_photo' => $imagePath,
                'product_description' => $validated['description'],
            ]);

            // Create Product
            $product = Product::create([
                'description_id' => $productDescription->id_description,
                'product_name' => $validated['name'],
                'product_price' => $validated['price'],
                'product_status' => 'aktif', // Default status is active
            ]);

            return redirect()->route('admin-manajemen-produk')
                           ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
        } catch (\Exception $e) {
            
            // Delete uploaded image if exists and there's an error
            if (isset($imagePath) && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            
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
            // Load relasi yang diperlukan
            $product->load(['description.category', 'description.temperatureType']);
            
            return view('admin.edit-produk', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('admin-manajemen-produk')
                        ->with('error', 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    public function staffEdit(Product $product)
    {
        try {
            // Load relasi yang diperlukan
            $product->load(['description.category', 'description.temperatureType']);
            
            return view('staff.staff-edit', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('staff-manajemen-produk')
                        ->with('error', 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            // Validasi sesuai dengan form di blade
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string|in:kopi,non-kopi,mix',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:active,inactive'
            ], [
                'name.required' => 'Nama produk harus diisi',
                'category.required' => 'Kategori harus dipilih',
                'description.required' => 'Deskripsi produk harus diisi',
                'price.required' => 'Harga produk harus diisi',
                'price.numeric' => 'Harga produk harus berupa angka',
                'image.image' => 'File harus berupa gambar',
                'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
                'image.max' => 'Ukuran gambar maksimal 2MB',
                'status.required' => 'Status produk harus dipilih'
            ]);

            // Load description untuk update
            $product->load('description');

            // Get category ID berdasarkan category name
            $category = Category::where('category', $validated['category'])->first();
            if (!$category) {
                throw new \Exception('Kategori tidak ditemukan');
            }

            // Handle image upload jika ada
            $imagePath = $product->description->product_photo; // Keep existing image by default
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($product->description->product_photo && file_exists(public_path($product->description->product_photo))) {
                    unlink(public_path($product->description->product_photo));
                }

                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images/products'), $imageName);
                $imagePath = 'images/products/' . $imageName;
            }

            // Update Product
            $product->update([
                'product_name' => $validated['name'],
                'product_price' => $validated['price'],
                'product_status' => $validated['status'] === 'active' ? 'aktif' : 'nonaktif'
            ]);

            // Update ProductDescription
            $product->description->update([
                'category_id' => $category->id_category,
                'product_photo' => $imagePath,
                'product_description' => $validated['description']
            ]);

            return redirect()->route('admin-manajemen-produk')
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

    public function staffUpdate(Request $request, Product $product)
    {
        try {
            // Validasi hanya untuk status
            $validated = $request->validate([
                'status' => 'required|in:active,inactive'
            ], [
                'status.required' => 'Status produk harus dipilih',
                'status.in' => 'Status tidak valid'
            ]);

            // Update hanya status produk
            $product->update([
                'product_status' => $validated['status'] === 'active' ? 'aktif' : 'nonaktif'
            ]);

            return redirect()->route('staff-manajemen-produk')
                        ->with('success', 'Status produk berhasil diperbarui');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                        ->withErrors($e->errors())
                        ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                        ->with('error', 'Terjadi kesalahan saat memperbarui status produk: ' . $e->getMessage())
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