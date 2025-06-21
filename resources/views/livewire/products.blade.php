<div>
  @if(session()->has('message'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
      {{ session('message') }}
    </div>
  @endif

  <button wire:click="resetInputs"
          class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded mb-4">
    Add New Product
  </button>

  <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}"
        class="bg-white p-4 rounded shadow mb-6">
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label>Name</label>
        <input wire:model="name" type="text"
               class="w-full border p-2 rounded">
      </div>
      <div>
        <label>Category</label>
        <select wire:model="category_id"
                class="w-full border p-2 rounded">
          <option value="">-- Select --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Supplier</label>
        <select wire:model="supplier_id"
                class="w-full border p-2 rounded">
          <option value="">-- Select --</option>
          @foreach($suppliers as $sup)
            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label>Stock</label>
        <input wire:model="stock" type="number"
               class="w-full border p-2 rounded">
      </div>
      <div>
        <label>Cost Price</label>
        <input wire:model="cost_price" type="text"
               class="w-full border p-2 rounded">
      </div>
      <div>
        <label>Sell Price</label>
        <input wire:model="sell_price" type="text"
               class="w-full border p-2 rounded">
      </div>
      <div>
        <label>Barcode</label>
        <input wire:model="barcode" type="text"
               class="w-full border p-2 rounded">
      </div>
      <div>
        <label>QR Code</label>
        <input wire:model="qr_code" type="text"
               class="w-full border p-2 rounded">
      </div>
      <div class="col-span-2">
        <label>Description</label>
        <textarea wire:model="description"
                  class="w-full border p-2 rounded"></textarea>
      </div>
    </div>
    <button type="submit"
            class="mt-4 bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
      {{ $updateMode ? 'Update' : 'Save' }}
    </button>
  </form>

  <table class="min-w-full bg-white rounded shadow">
    <thead>
      <tr class="bg-gray-200">
        <th class="py-2 px-4">ID</th>
        <th class="py-2 px-4">Name</th>
        <th class="py-2 px-4">Category</th>
        <th class="py-2 px-4">Supplier</th>
        <th class="py-2 px-4">Stock</th>
        <th class="py-2 px-4">Cost</th>
        <th class="py-2 px-4">Sell</th>
        <th class="py-2 px-4">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $p)
        <tr>
          <td class="border px-4 py-2">{{ $p->id }}</td>
          <td class="border px-4 py-2">{{ $p->name }}</td>
          <td class="border px-4 py-2">{{ $p->category->name }}</td>
          <td class="border px-4 py-2">{{ $p->supplier->name }}</td>
          <td class="border px-4 py-2">{{ $p->stock }}</td>
          <td class="border px-4 py-2">{{ $p->cost_price }}</td>
          <td class="border px-4 py-2">{{ $p->sell_price }}</td>
          <td class="border px-4 py-2 space-x-2">
            <button wire:click="edit({{ $p->id }})"
                    class="bg-yellow-400 hover:bg-yellow-600 text-white py-1 px-2 rounded">
              Edit
            </button>
            <button wire:click="delete({{ $p->id }})"
                    class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded">
              Del
            </button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
