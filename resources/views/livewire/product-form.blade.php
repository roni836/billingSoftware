<div>
    <form wire:submit.prevent="saveProduct">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-1 md:col-span-2">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                <input type="text" wire:model.defer="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="flex justify-between items-center">
                    <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                    <button type="button" wire:click="toggleCategoryForm" class="text-blue-500 text-xs hover:text-blue-700">
                        + Add New Category
                    </button>
                </div>
                
                @if(!$showCategoryForm)
                <select wire:model.defer="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                @else
                <div class="bg-gray-50 p-3 rounded border">
                    <div class="mb-2">
                        <label for="newCategoryName" class="block text-gray-700 text-sm font-bold mb-1">Category Name:</label>
                        <input type="text" wire:model.defer="newCategoryName" id="newCategoryName" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 text-sm leading-tight focus:outline-none focus:shadow-outline">
                        @error('newCategoryName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-2">
                        <label for="newCategoryDescription" class="block text-gray-700 text-sm font-bold mb-1">Description:</label>
                        <textarea wire:model.defer="newCategoryDescription" id="newCategoryDescription" rows="2" class="shadow appearance-none border rounded w-full py-1 px-2 text-gray-700 text-sm leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="button" wire:click="saveCategory" class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1 px-2 rounded mr-2">
                            Save
                        </button>
                        <button type="button" wire:click="toggleCategoryForm" class="bg-gray-500 hover:bg-gray-700 text-white text-xs font-bold py-1 px-2 rounded">
                            Cancel
                        </button>
                    </div>
                </div>
                @endif
            </div>

            <div>
                <label for="sku" class="block text-gray-700 text-sm font-bold mb-2">SKU:</label>
                <input type="text" wire:model.defer="sku" id="sku" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="purchase_price" class="block text-gray-700 text-sm font-bold mb-2">Purchase Price:</label>
                <input type="number" step="0.01" wire:model.defer="purchase_price" id="purchase_price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('purchase_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="selling_price" class="block text-gray-700 text-sm font-bold mb-2">Selling Price:</label>
                <input type="number" step="0.01" wire:model.defer="selling_price" id="selling_price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('selling_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantity:</label>
                <input type="number" wire:model.defer="quantity" id="quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="reorder_level" class="block text-gray-700 text-sm font-bold mb-2">Reorder Level:</label>
                <input type="number" wire:model.defer="reorder_level" id="reorder_level" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('reorder_level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="brand" class="block text-gray-700 text-sm font-bold mb-2">Brand:</label>
                <input type="text" wire:model.defer="brand" id="brand" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('brand') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="model_compatibility" class="block text-gray-700 text-sm font-bold mb-2">Compatible Models:</label>
                <input type="text" wire:model.defer="model_compatibility" id="model_compatibility" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('model_compatibility') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                <select wire:model.defer="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-1 md:col-span-2">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea wire:model.defer="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-1 md:col-span-2">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Product Image:</label>
                <input type="file" wire:model="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-1">Uploading...</div>
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                
                @if ($image)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Preview:</p>
                        <img src="{{ $image->temporaryUrl() }}" class="mt-2 h-24 w-24 object-cover rounded">
                    </div>
                @elseif ($image_path)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Current Image:</p>
                        <img src="{{ Storage::url($image_path) }}" class="mt-2 h-24 w-24 object-cover rounded">
                    </div>
                @endif
            </div>
        </div>
        
        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ $product_id ? 'Update Product' : 'Save Product' }}
            </button>
        </div>
    </form>
</div>