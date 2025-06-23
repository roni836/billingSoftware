<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Products extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $isDeleteConfirmationOpen = false;
    public $product_id;

    protected $listeners = ['refresh' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        try {
            Log::info('Products render method called');
            
            $query = Product::query();
            
            if (!empty($this->search)) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%')
                      ->orWhere('brand', 'like', '%' . $this->search . '%');
                });
            }
            
            if (!empty($this->categoryFilter)) {
                $query->where('category_id', $this->categoryFilter);
            }
            
            $products = $query->with('category')->latest()->paginate(10);
            $categories = ProductCategory::where('status', 'active')->orderBy('name')->get();
            
            Log::info('Products count: ' . $products->count());
            
            return view('livewire.products', [
                'products' => $products,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            Log::error('Error in render method: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return view('livewire.products', [
                'products' => collect(),
                'categories' => ProductCategory::where('status', 'active')->orderBy('name')->get()
            ])->with('error', 'Error loading products: ' . $e->getMessage());
        }
    }

    public function openDeleteConfirmation($id)
    {
        $this->product_id = $id;
        $this->isDeleteConfirmationOpen = true;
    }

    public function closeDeleteConfirmation()
    {
        $this->isDeleteConfirmationOpen = false;
    }

    public function delete()
    {
        try {
            Log::info('Deleting product', ['id' => $this->product_id]);
            $product = Product::findOrFail($this->product_id);
            
            // Delete product image if exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            
            $product->delete();
            Log::info('Product deleted successfully');
            
            session()->flash('message', 'Product Deleted Successfully.');
            $this->closeDeleteConfirmation();
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            session()->flash('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
}
