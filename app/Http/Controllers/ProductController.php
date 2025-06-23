<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        $categories = ProductCategory::where('status', 'active')->get();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function create()
    {
        $categories = ProductCategory::where('status', 'active')->get();
        return view('products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        Log::info('Product form submitted', $request->all());
        
        $validated = $request->validate([
            'name' => 'required|min:3',
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'required|unique:products,sku',
            'description' => 'nullable',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'brand' => 'nullable',
            'model_compatibility' => 'nullable',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:1024'
        ]);
        
        try {
            $productData = $request->except('image');
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                $productData['image_path'] = $imagePath;
            }
            
            $product = Product::create($productData);
            
            Log::info('Product created successfully', ['product_id' => $product->id]);
            
            return redirect()->route('products.index')
                ->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }
    
    public function edit(Product $product)
    {
        $categories = ProductCategory::where('status', 'active')->get();
        return view('products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'description' => 'nullable',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'brand' => 'nullable',
            'model_compatibility' => 'nullable',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:1024'
        ]);
        
        try {
            $productData = $request->except('image');
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image_path) {
                    Storage::disk('public')->delete($product->image_path);
                }
                
                $imagePath = $request->file('image')->store('products', 'public');
                $productData['image_path'] = $imagePath;
            }
            
            $product->update($productData);
            
            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }
    
    public function destroy(Product $product)
    {
        try {
            // Delete product image if exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            
            $product->delete();
            
            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
}