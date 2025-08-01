@extends('admin.layout')

@section('title', 'Edit Product - BH Cabinetry Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
        <p class="text-gray-600 mt-1">Update the product information.</p>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Line -->
                    <div class="md:col-span-2">
                        <label for="product_line_id" class="block text-sm font-medium text-gray-700">Product Line</label>
                        <select name="product_line_id" id="product_line_id" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                required>
                            <option value="">Select a product line</option>
                            @foreach($productLines as $productLine)
                                <option value="{{ $productLine->id }}" {{ old('product_line_id', $product->product_line_id) == $productLine->id ? 'selected' : '' }}>
                                    {{ $productLine->doorStyle->name }} - {{ $productLine->doorColor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_line_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categories -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($categories as $category)
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                           {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                           class="category-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           data-category-id="{{ $category->id }}">
                                    <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('categories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sub Categories -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sub Categories</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($subCategories as $subCategory)
                                <label class="flex items-center">
                                    <input type="checkbox" name="sub_categories[]" value="{{ $subCategory->id }}" 
                                           {{ in_array($subCategory->id, old('sub_categories', $product->subCategories->pluck('id')->toArray())) ? 'checked' : '' }}
                                           class="subcategory-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           data-category-id="{{ $subCategory->category_id }}">
                                    <span class="ml-2 text-sm text-gray-700">{{ $subCategory->category->name }} > {{ $subCategory->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('sub_categories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                               placeholder="e.g., HDF-CG-2DR-24"
                               required>
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                               placeholder="e.g., 2 Drawer Base Cabinet"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                               step="0.01" min="0"
                               required>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assembly Cost -->
                    <div>
                        <label for="assembly_cost" class="block text-sm font-medium text-gray-700">Assembly Cost ($)</label>
                        <input type="number" name="assembly_cost" id="assembly_cost" value="{{ old('assembly_cost', $product->assembly_cost) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                               step="0.01" min="0"
                               placeholder="0.00">
                        @error('assembly_cost')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hinge Type -->
                    <div>
                        <label for="hinge_type" class="block text-sm font-medium text-gray-700">Hinge Type</label>
                        <input type="text" name="hinge_type" id="hinge_type" value="{{ old('hinge_type', $product->hinge_type) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                               placeholder="e.g., Soft Close, Standard"
                               required>
                        @error('hinge_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Modifiable -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_modifiable" value="1" 
                                   {{ old('is_modifiable', $product->is_modifiable) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Is Modifiable</span>
                        </label>
                        @error('is_modifiable')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all category checkboxes
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    
    // Add event listener to each category checkbox
    categoryCheckboxes.forEach(function(categoryCheckbox) {
        categoryCheckbox.addEventListener('change', function() {
            const categoryId = this.getAttribute('data-category-id');
            const isChecked = this.checked;
            
            // Get all subcategory checkboxes that belong to this category
            const subcategoryCheckboxes = document.querySelectorAll('.subcategory-checkbox[data-category-id="' + categoryId + '"]');
            
            // Check/uncheck all subcategories based on category selection
            subcategoryCheckboxes.forEach(function(subcategoryCheckbox) {
                subcategoryCheckbox.checked = isChecked;
            });
        });
    });
});
</script>
@endsection 