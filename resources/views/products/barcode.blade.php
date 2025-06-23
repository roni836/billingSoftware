<x-layouts.app>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Product Barcode Generator</h2>
            <a href="{{ route('products') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Products
            </a>
        </div>

        @livewire('product-barcode', ['product_id' => $product_id])
    </div>
</x-layouts.app>