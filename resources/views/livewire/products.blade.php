<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Spare Parts Inventory</h2>
        <div class="flex items-center">
            <div class="mr-4">
                <input type="text" wire:model.debounce.300ms="search" placeholder="Search products..." class="px-4 py-2 border rounded-lg">
            </div>
            <div class="mr-4">
                <select wire:model="categoryFilter" class="px-4 py-2 border rounded-lg">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Product
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-3 px-4 bg-gray-100 font-semibold text-gray-600 uppercase text-sm text-left">Image</th>
                    <th class="py-3 px-4 bg-gray-100 font-semibold text-gray-600 uppercase text-sm text-left">SKU</th>
                    <th class="py-3 px-4 bg-gray-100 font-semibold text-gray-600 uppercase text-sm text-left">Name</th>
                    <th class="py-3 px-4 bg-gray-100 font-semibold text-gray-600 uppercase text-sm text-left">Category</th>
                    <th class="py-3 px-4 bg-gray-100 font-semibold text-gray-600 uppercase text-sm text-left">Price</th>
                    <th class="py-3 px-4 bg-gray-100 font-semibold text-gray-600 uppercase text-sm text-left">Stock</th>
                    <th class="py-3 px-4 bg-gray-100 font-semibold text-gray-600 uppercase text-sm text-left">Status</th>
                    <th class="py-3 px-4 bg-gray-100 font-semibold text-gray-600 uppercase text-sm text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                <tr>
                    <td class="py-3 px-4">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded">
                        @else
                            <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        @endif
                    </td>
                    <td class="py-3 px-4">{{ $product->sku }}</td>
                    <td class="py-3 px-4">{{ $product->name }}</td>
                    <td class="py-3 px-4">{{ $product->category->name }}</td>
                    <td class="py-3 px-4">₹{{ number_format($product->selling_price, 2) }}</td>
                    <td class="py-3 px-4">
                        <span class="{{ $product->quantity <= $product->reorder_level ? 'text-red-600 font-bold' : '' }}">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('products.barcode', $product->id) }}" class="text-green-500 hover:text-green-700 mr-2">
                            <i class="fas fa-barcode"></i>
                        </a>
                        <button wire:click="openDeleteConfirmation({{ $product->id }})" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-3 px-4 text-center text-gray-500">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    @if($isDeleteConfirmationOpen)
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Delete Product
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this product? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="delete()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" wire:click="closeDeleteConfirmation()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
