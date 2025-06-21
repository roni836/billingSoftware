<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Livewire\Component;

class Purchases extends Component
{
    public $suppliers, $products;
    public $supplier_id, $purchased_at, $rows = [], $total = 0;

    public function mount()
    {
        $this->suppliers = Supplier::all();
        $this->products  = Product::all();
        $this->addRow();
        $this->purchased_at = now()->toDateString();
    }

    public function render()
    {
        return view('livewire.purchases');
    }

    public function addRow()
    {
        $this->rows[] = ['product_id' => null, 'quantity' => 1, 'price' => 0, 'subtotal' => 0];
    }

    public function removeRow($i)
    {
        unset($this->rows[$i]);
        $this->rows = array_values($this->rows);
        $this->calcTotal();
    }

    public function updatedRows()
    {
        $this->calcTotal();
    }

    public function calcTotal()
    {
        $this->total = collect($this->rows)->sum('subtotal');
    }

    public function store()
    {
        $this->validate([
            'supplier_id'       => 'required',
            'purchased_at'      => 'required|date',
            'rows.*.product_id' => 'required',
            'rows.*.quantity'   => 'required|integer|min:1',
            'rows.*.price'      => 'required|numeric|min:0',
        ]);

        $purchase = Purchase::create([
            'supplier_id'  => $this->supplier_id,
            'purchased_at' => $this->purchased_at,
            'total'        => $this->total,
        ]);

        foreach ($this->rows as $r) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id'  => $r['product_id'],
                'quantity'    => $r['quantity'],
                'price'       => $r['price'],
                'subtotal'    => $r['subtotal'],
            ]);
            $prod = Product::find($r['product_id']);
            $prod->increment('stock', $r['quantity']);
        }

        session()->flash('message', 'Purchase recorded.');
        return redirect()->route('purchases');
    }
}
