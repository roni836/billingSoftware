<div>
  @if(session()->has('message'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
      {{ session('message') }}
    </div>
  @endif

  <form wire:submit.prevent="store" class="bg-white p-4 rounded shadow">
    <div class="grid grid-cols-3 gap-4 mb-4">
      <div>
        <label>Customer</label>
        <input wire:model="customer_name" type="text"
               class="w-full border p-2 rounded" placeholder="Optional">
      </div>
      <div>
        <label>Date</label>
        <input wire:model="sold_at" type="date"
               class="w-full border p-2 rounded">
      </div>
      <div>
        <label>Total</label>
        <input wire:model="total" type="text" readonly
               class="w-full border bg-gray-100 p-2 rounded">
      </div>
    </div>

    <table class="w-full mb-4">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2">Product</th>
          <th class="p-2">Qty</th>
          <th class="p-2">Price</th>
          <th class="p-2">Subtotal</th>
          <th class="p-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($rows as $i => $row)
          <tr>
            <td class="border p-2">
              <select wire:model="rows.{{ $i }}.product_id"
                      wire:change="updatedRows"
                      class="w-full">
                <option value="">--</option>
                @foreach($products as $p)
                  <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
              </select>
            </td>
            <td class="border p-2">
              <input type="number"
                     wire:model.lazy="rows.{{ $i }}.quantity"
                     wire:change="updatedRows"
                     class="w-16">
            </td>
            <td class="border p-2">
              <input type="text"
                     wire:model.lazy="rows.{{ $i }}.price"
                     wire:change="updatedRows"
                     class="w-24">
            </td>
            <td class="border p-2">
              {{ $rows[$i]['subtotal'] = $rows[$i]['quantity'] * $rows[$i]['price'] }}
            </td>
            <td class="border p-2">
              <button type="button"
                      wire:click="removeRow({{ $i }})"
                      class="text-red-600">✕</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <button type="button" wire:click="addRow"
            class="bg-blue-500 text-white py-1 px-3 rounded mb-4">
      + Add Item
    </button>

    <button type="submit"
            class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
      Save Sale
    </button>
  </form>
</div>
