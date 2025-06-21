<?php

// app/Http/Livewire/Sales.php
namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Livewire\Component;

class Sales extends Component
{
    public $products;
    public $customer_name, $sold_at, $rows = [], $total = 0;

    public function mount()
    {
        $this->products = Product::all();
        $this->addRow();
        $this->sold_at = now()->toDateString();
    }

    public function render()
    {
        return view('livewire.sales');
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
            'sold_at'           => 'required|date',
            'rows.*.product_id' => 'required',
            'rows.*.quantity'   => 'required|integer|min:1',
            'rows.*.price'      => 'required|numeric|min:0',
        ]);

        $sale = Sale::create([
            'customer_name' => $this->customer_name,
            'sold_at'       => $this->sold_at,
            'total'         => $this->total,
        ]);

        foreach ($this->rows as $r) {
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $r['product_id'],
                'quantity'   => $r['quantity'],
                'price'      => $r['price'],
                'subtotal'   => $r['subtotal'],
            ]);
            $prod = Product::find($r['product_id']);
            $prod->decrement('stock', $r['quantity']);
        }

        session()->flash('message', 'Sale recorded.');
        return redirect()->route('sales');
    }
}
