<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductForm extends Component
{
    use WithFileUploads;

    public $name;
    public $category_id;
    public $sku;
    public $description;
    public $purchase_price;
    public $selling_price;
    public $quantity;
    public $reorder_level = 10;
    public $brand;
    public $model_compatibility;
    public $status = 'active';
    public $image;
    public $image_path;
    public $product_id;
    
    // For new category form
    public $showCategoryForm = false;
    public $newCategoryName;
    public $newCategoryDescription;
    public $newCategoryStatus = 'active';

    protected $rules = [
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
    ];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($product_id = null)
    {
        if ($product_id) {
            $this->product_id = $product_id;
            $this->loadProduct();
        }
    }

    public function loadProduct()
    {
        try {
            $product = Product::findOrFail($this->product_id);
            
            $this->name = $product->name;
            $this->category_id = $product->category_id;
            $this->sku = $product->sku;
            $this->description = $product->description;
            $this->purchase_price = $product->purchase_price;
            $this->selling_price = $product->selling_price;
            $this->quantity = $product->quantity;
            $this->reorder_level = $product->reorder_level;
            $this->brand = $product->brand;
            $this->model_compatibility = $product->model_compatibility;
            $this->status = $product->status;
            $this->image_path = $product->image_path;
        } catch (\Exception $e) {
            Log::error('Error loading product: ' . $e->getMessage());
            session()->flash('error', 'Error loading product: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.product-form', [
            'categories' => ProductCategory::where('status', 'active')->orderBy('name')->get()
        ]);
    }

    public function toggleCategoryForm()
    {
        $this->showCategoryForm = !$this->showCategoryForm;
        $this->resetCategoryForm();
    }

    public function resetCategoryForm()
    {
        $this->newCategoryName = '';
        $this->newCategoryDescription = '';
        $this->newCategoryStatus = 'active';
    }

    public function saveCategory()
    {
        $this->validate([
            'newCategoryName' => 'required|min:3|unique:product_categories,name',
            'newCategoryDescription' => 'nullable',
            'newCategoryStatus' => 'required|in:active,inactive',
        ]);

        try {
            $category = ProductCategory::create([
                'name' => $this->newCategoryName,
                'description' => $this->newCategoryDescription,
                'status' => $this->newCategoryStatus,
            ]);

            $this->category_id = $category->id;
            $this->toggleCategoryForm();
            
            session()->flash('message', 'Category created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            session()->flash('error', 'Error creating category: ' . $e->getMessage());
        }
    }

    public function saveProduct()
    {
        try {
            Log::info('Product save method called');
            
            // Modify validation rules for update
            if ($this->product_id) {
                $this->rules['sku'] = 'required|unique:products,sku,' . $this->product_id;
            }
            
            $validatedData = $this->validate();
            
            $productData = [
                'name' => $this->name,
                'category_id' => $this->category_id,
                'sku' => $this->sku,
                'description' => $this->description,
                'purchase_price' => $this->purchase_price,
                'selling_price' => $this->selling_price,
                'quantity' => $this->quantity,
                'reorder_level' => $this->reorder_level,
                'brand' => $this->brand,
                'model_compatibility' => $this->model_compatibility,
                'status' => $this->status,
            ];

            // Handle image upload
            if ($this->image) {
                Log::info('Processing image upload');
                // Delete old image if exists
                if ($this->product_id) {
                    $product = Product::find($this->product_id);
                    if ($product && $product->image_path) {
                        Storage::disk('public')->delete($product->image_path);
                    }
                }
                
                $imagePath = $this->image->store('products', 'public');
                Log::info('Image stored at: ' . $imagePath);
                $productData['image_path'] = $imagePath;
            }

            // Create or update product
            $product = Product::updateOrCreate(['id' => $this->product_id], $productData);
            Log::info('Product saved successfully', ['product_id' => $product->id]);

            session()->flash('message', $this->product_id ? 'Product Updated Successfully.' : 'Product Created Successfully.');
            
            if (!$this->product_id) {
                // If it was a new product, clear the form
                $this->resetForm();
            }
            
            return redirect()->route('products');
        } catch (\Exception $e) {
            Log::error('Error saving product: ' . $e->getMessage());
            session()->flash('error', 'Error saving product: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->category_id = '';
        $this->sku = '';
        $this->description = '';
        $this->purchase_price = '';
        $this->selling_price = '';
        $this->quantity = '';
        $this->reorder_level = 10;
        $this->brand = '';
        $this->model_compatibility = '';
        $this->status = 'active';
        $this->image = null;
        $this->image_path = null;
    }
}