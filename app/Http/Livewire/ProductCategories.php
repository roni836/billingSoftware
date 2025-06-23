<?php

namespace App\Http\Livewire;

use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ProductCategories extends Component
{
    use WithPagination;

    public $name;
    public $description;
    public $status = 'active';
    public $category_id;
    public $search = '';
      public $isOpen = false;
    public $isDeleteConfirmationOpen = false;

    protected $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable',
        'status' => 'required|in:active,inactive',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->resetInputFields();
    }    public function render()
    {
        try {
            \Illuminate\Support\Facades\Log::info('Category render method called, modal state: ' . ($this->isOpen ? 'open' : 'closed'));
            
            $query = ProductCategory::query();
            
            if (!empty($this->search)) {
                $query->where('name', 'like', '%' . $this->search . '%');
            }
            
            $categories = $query->latest()->paginate(10);
            
            \Illuminate\Support\Facades\Log::info('Categories count: ' . $categories->count());
            
            return view('livewire.product-categories', [
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in ProductCategories render: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
            
            session()->flash('error', 'Error loading categories: ' . $e->getMessage());
            
            return view('livewire.product-categories', [
                'categories' => collect()
            ]);
        }
    }public function create()
    {
        try {
            // Force reset everything
            $this->resetErrorBag();
            $this->resetValidation();
            $this->resetInputFields();
            
            // Log the modal state
            \Illuminate\Support\Facades\Log::info('Category modal open state before: ' . ($this->isOpen ? 'true' : 'false'));
            
            // Set the state directly
            $this->isOpen = true;
            
            // Log the modal state after
            \Illuminate\Support\Facades\Log::info('Category modal open state after: ' . ($this->isOpen ? 'true' : 'false'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in category create method: ' . $e->getMessage());
            session()->flash('error', 'Error opening category form: ' . $e->getMessage());
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function openDeleteConfirmation($id)
    {
        $this->category_id = $id;
        $this->isDeleteConfirmationOpen = true;
    }

    public function closeDeleteConfirmation()
    {
        $this->isDeleteConfirmationOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->status = 'active';
        $this->category_id = null;
    }    public function store()
    {
        try {
            \Illuminate\Support\Facades\Log::info('Category store method called');
            
            \Illuminate\Support\Facades\Log::info('Validating category data', [
                'name' => $this->name,
                'status' => $this->status
            ]);
            
            $validatedData = $this->validate();
            
            \Illuminate\Support\Facades\Log::info('Category validation passed');
            
            $category = ProductCategory::updateOrCreate(['id' => $this->category_id], [
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            
            \Illuminate\Support\Facades\Log::info('Category saved successfully', ['category_id' => $category->id]);
            
            session()->flash('message', $this->category_id ? 'Category Updated Successfully.' : 'Category Created Successfully.');
            
            $this->closeModal();
            $this->resetInputFields();
            
            // Use $this->dispatchBrowserEvent instead of emit
            $this->dispatchBrowserEvent('category-saved');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in category store: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
            session()->flash('error', 'Error saving category: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            Log::info('Editing category', ['id' => $id]);
            $category = ProductCategory::findOrFail($id);
            
            $this->category_id = $id;
            $this->name = $category->name;
            $this->description = $category->description;
            $this->status = $category->status;

            $this->openModal();
        } catch (\Exception $e) {
            Log::error('Error editing category: ' . $e->getMessage());
            session()->flash('error', 'Error loading category: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        try {
            Log::info('Deleting category', ['id' => $this->category_id]);
            $category = ProductCategory::findOrFail($this->category_id);
            
            // Check if category has products
            $productCount = $category->products()->count();
            if ($productCount > 0) {
                Log::warning('Cannot delete category with products', ['product_count' => $productCount]);
                session()->flash('error', 'Cannot delete category because it has ' . $productCount . ' product(s) associated with it.');
                $this->closeDeleteConfirmation();
                return;
            }
            
            $category->delete();
            Log::info('Category deleted successfully');
            
            session()->flash('message', 'Category Deleted Successfully.');
            $this->closeDeleteConfirmation();
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            session()->flash('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}