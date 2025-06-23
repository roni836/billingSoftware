<x-layouts.app>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Spare Parts Inventory</h2>
            <div class="flex items-center">
                <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
                    Add New Product
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
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
                            <div class="flex items-center">
                                <a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
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
    </div>
</x-layouts.app>