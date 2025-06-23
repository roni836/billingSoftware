<div>
    <div class="bg-white shadow-md rounded p-6">
        <h2 class="text-xl font-bold mb-4">Generate Barcode for {{ $product->name }}</h2>
        
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
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <form wire:submit.prevent="generateBarcode">
                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Number of Labels:</label>
                        <input type="number" wire:model="quantity" id="quantity" min="1" max="100" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="labelSize" class="block text-gray-700 text-sm font-bold mb-2">Label Size:</label>
                        <select wire:model="labelSize" id="labelSize" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="2x1">2" x 1" (Small)</option>
                            <option value="3x2">3" x 2" (Medium)</option>
                            <option value="4x3">4" x 3" (Large)</option>
                        </select>
                        @error('labelSize') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="barcodeType" class="block text-gray-700 text-sm font-bold mb-2">Barcode Type:</label>
                        <select wire:model="barcodeType" id="barcodeType" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="code128">Code 128</option>
                            <option value="qrcode">QR Code</option>
                            <option value="ean13">EAN-13</option>
                            <option value="code39">Code 39</option>
                        </select>
                        @error('barcodeType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="showPrice" id="showPrice" class="mr-2">
                            <label for="showPrice" class="text-gray-700 text-sm font-bold">Show Price on Label</label>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="showSku" id="showSku" class="mr-2">
                            <label for="showSku" class="text-gray-700 text-sm font-bold">Show SKU on Label</label>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Generate Barcode
                        </button>
                    </div>
                </form>
                
                <div class="mt-6">
                    <div class="border-t pt-4">
                        <h3 class="font-bold mb-2">Product Details</h3>
                        <p><span class="font-semibold">SKU:</span> {{ $product->sku }}</p>
                        <p><span class="font-semibold">Price:</span> ₹{{ number_format($product->selling_price, 2) }}</p>
                        <p><span class="font-semibold">Category:</span> {{ $product->category->name }}</p>
                    </div>
                </div>
            </div>
              <div>
                @if($barcodeImageUrl)
                    <div class="border p-4 rounded">
                        <h3 class="font-bold mb-2">Generated Barcode</h3>
                        <div class="mb-4 overflow-auto">
                            <iframe src="{{ $barcodeImageUrl }}" class="w-full h-64 border"></iframe>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ $barcodeImageUrl }}" target="_blank" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Open PDF
                            </a>
                            <button wire:click="printBarcode" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Print
                            </button>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-full">
                        <div class="text-center text-gray-500 p-6 bg-gray-100 rounded-lg">
                            <i class="fas fa-barcode text-5xl mb-4"></i>
                            <p class="mb-4">Generated barcode will appear here</p>
                              <div class="text-sm text-left bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <h4 class="font-bold text-blue-800 mb-2">Troubleshooting Tips:</h4>
                                <ul class="list-disc pl-5 text-blue-700">
                                    <li>Make sure you have run <code class="bg-gray-200 px-1 rounded">php artisan storage:link</code></li>
                                    <li>Check that the <code class="bg-gray-200 px-1 rounded">storage/app/public/barcodes</code> directory exists</li>
                                    <li>Try a different barcode type (Code 128 is most reliable)</li>
                                    <li>Ensure your SKU is valid for the selected barcode type</li>
                                    <li>Check your internet connection (Labelary API is external)</li>
                                </ul>
                                
                                <div class="mt-3">
                                    <p class="mb-2">Or try our direct barcode generator:</p>
                                    <a href="{{ route('products.generate-barcode', ['product' => $product->id, 'type' => $barcodeType]) }}" target="_blank" 
                                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline">
                                        Generate Simple Barcode
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('print-barcode', event => {
                const url = event.detail.url;
                if (url) {
                    const printWindow = window.open(url, '_blank');
                    if (printWindow) {
                        printWindow.addEventListener('load', function() {
                            printWindow.print();
                        });
                    }
                }
            });
        });
    </script>
    @endpush
</div>