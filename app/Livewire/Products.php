<?php
namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

class Products extends Component
{
    public $products, $name, $category_id, $supplier_id,
    $barcode, $qr_code, $cost_price,
    $sell_price, $stock, $description, $product_id;
    public $updateMode = false;

    public function render()
    {
        $this->products = Product::with(['category', 'supplier'])->get();
        $categories     = Category::all();
        $suppliers      = Supplier::all();
        return view('livewire.products', compact('categories', 'suppliers'));
    }

    private function resetInputs()
    {
        foreach (['name', 'category_id', 'supplier_id', 'barcode', 'qr_code', 'cost_price', 'sell_price', 'stock', 'description'] as $f) {
            $this->$f = null;
        }
        $this->product_id = null;
    }

    public function store()
    {
        $this->validate([
            'name'        => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'cost_price'  => 'required|numeric',
            'sell_price'  => 'required|numeric',
            'stock'       => 'required|integer',
        ]);

        Product::create([
            'name'        => $this->name,
            'category_id' => $this->category_id,
            'supplier_id' => $this->supplier_id,
            'barcode'     => $this->barcode,
            'qr_code'     => $this->qr_code,
            'cost_price'  => $this->cost_price,
            'sell_price'  => $this->sell_price,
            'stock'       => $this->stock,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Product added.');
        $this->resetInputs();
    }

    public function edit($id)
    {
        $p = Product::findOrFail($id);
        foreach ($p->toArray() as $k => $v) {
            $this->$k = $v;
        }
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
            'name'        => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'cost_price'  => 'required|numeric',
            'sell_price'  => 'required|numeric',
            'stock'       => 'required|integer',
        ]);

        Product::find($this->product_id)->update([
            'name'        => $this->name,
            'category_id' => $this->category_id,
            'supplier_id' => $this->supplier_id,
            'barcode'     => $this->barcode,
            'qr_code'     => $this->qr_code,
            'cost_price'  => $this->cost_price,
            'sell_price'  => $this->sell_price,
            'stock'       => $this->stock,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Product updated.');
        $this->resetInputs();
        $this->updateMode = false;
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Product deleted.');
    }
}
