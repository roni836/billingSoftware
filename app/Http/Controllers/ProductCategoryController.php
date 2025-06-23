<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::latest()->paginate(10);
        return view('product-categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('product-categories.create');
    }
    
    public function store(Request $request)
    {
        Log::info('Category form submitted', $request->all());
        
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);
        
        try {
            $category = ProductCategory::create($validated);
            
            Log::info('Category created successfully', ['category_id' => $category->id]);
            
            return redirect()->route('product-categories.index')
                ->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Error creating category: ' . $e->getMessage());
        }
    }
    
    public function edit(ProductCategory $productCategory)
    {
        return view('product-categories.edit', compact('productCategory'));
    }
    
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);
        
        try {
            $productCategory->update($validated);
            
            return redirect()->route('product-categories.index')
                ->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Error updating category: ' . $e->getMessage());
        }
    }
    
    public function destroy(ProductCategory $productCategory)
    {
        try {
            // Check if category has products
            if ($productCategory->products()->count() > 0) {
                return back()->with('error', 'Cannot delete category because it has products associated with it');
            }
            
            $productCategory->delete();
            
            return redirect()->route('product-categories.index')
                ->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            
            return back()->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}