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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category (Select One)</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($categories as $category)
                                <label class="flex items-center">
                                    <input type="radio" name="category_id" value="{{ $category->id }}" 
                                           {{ old('category_id', $product->categories->first()?->id) == $category->id ? 'checked' : '' }}
                                           class="category-radio rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           data-category-id="{{ $category->id }}">
                                    <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('category_id')
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
                        <div class="flex space-x-2">
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                   placeholder="Auto-generated SKU"
                                   required>
                            <button type="button" id="generate-sku-btn" 
                                    class="mt-1 px-3 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Generate
                            </button>
                        </div>
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

                                         <!-- Labor Cost -->
                     <div>
                         <label for="labor_cost" class="block text-sm font-medium text-gray-700">Labor Cost ($)</label>
                                                   <input type="number" name="labor_cost" id="labor_cost" value="{{ old('labor_cost', $product->labor_cost) }}"  
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                step="0.01" min="0"
                                placeholder="30.00">
                         @error('labor_cost')
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
    // Get all category radio buttons
    const categoryRadios = document.querySelectorAll('.category-radio');
    
    // Add event listener to each category radio
    categoryRadios.forEach(function(categoryRadio) {
        categoryRadio.addEventListener('change', function() {
            const categoryId = this.getAttribute('data-category-id');
            
            // First, uncheck all subcategory checkboxes
            const allSubcategoryCheckboxes = document.querySelectorAll('.subcategory-checkbox');
            allSubcategoryCheckboxes.forEach(function(subcategoryCheckbox) {
                subcategoryCheckbox.checked = false;
            });
            
            // Then, check all subcategory checkboxes that belong to the selected category
            const subcategoryCheckboxes = document.querySelectorAll('.subcategory-checkbox[data-category-id="' + categoryId + '"]');
            subcategoryCheckboxes.forEach(function(subcategoryCheckbox) {
                subcategoryCheckbox.checked = true;
            });
        });
    });
    
    // Auto-select subcategories for the initially selected category (if any)
    const selectedCategoryRadio = document.querySelector('.category-radio:checked');
    if (selectedCategoryRadio) {
        const categoryId = selectedCategoryRadio.getAttribute('data-category-id');
        const subcategoryCheckboxes = document.querySelectorAll('.subcategory-checkbox[data-category-id="' + categoryId + '"]');
        subcategoryCheckboxes.forEach(function(subcategoryCheckbox) {
            subcategoryCheckbox.checked = true;
        });
    }
    
    // SKU Generation functionality
    const skuInput = document.getElementById('sku');
    const generateSkuBtn = document.getElementById('generate-sku-btn');
    const productLineSelect = document.getElementById('product_line_id');
    const nameInput = document.getElementById('name');
    
    function generateSKU() {
        const productLine = productLineSelect.options[productLineSelect.selectedIndex];
        const name = nameInput.value.trim();
        
        if (!productLine.value) {
            alert('Please select a product line first');
            return;
        }
        
        if (!name) {
            alert('Please enter a product name first');
            return;
        }
        
        // Extract door style and color from product line text
        const productLineText = productLine.text;
        const parts = productLineText.split(' - ');
        const doorStyle = parts[0] || 'STYLE';
        const doorColor = parts[1] || 'COLOR';
        
        // Create SKU format: DOORSTYLE-DOORCOLOR-PRODUCTNAME-TIMESTAMP
        const timestamp = Date.now().toString().slice(-4); // Last 4 digits of timestamp
        const cleanName = name.replace(/[^A-Z0-9]/gi, '').toUpperCase().substring(0, 8);
        const cleanDoorStyle = doorStyle.replace(/[^A-Z0-9]/gi, '').toUpperCase().substring(0, 6);
        const cleanDoorColor = doorColor.replace(/[^A-Z0-9]/gi, '').toUpperCase().substring(0, 6);
        
        const generatedSKU = `${cleanDoorStyle}-${cleanDoorColor}-${cleanName}-${timestamp}`;
        skuInput.value = generatedSKU;
    }
    
    // Generate SKU button click
    generateSkuBtn.addEventListener('click', generateSKU);
    
    // Auto-generate SKU when product line or name changes (if both are filled)
    productLineSelect.addEventListener('change', function() {
        if (productLineSelect.value && nameInput.value.trim()) {
            generateSKU();
        }
        filterCategoriesByProductLine();
    });
    
    nameInput.addEventListener('input', function() {
        if (productLineSelect.value && nameInput.value.trim()) {
            generateSKU();
        }
    });
    
    // Filter categories and subcategories based on selected product line
    function filterCategoriesByProductLine() {
        const selectedProductLineId = productLineSelect.value;
        if (!selectedProductLineId) {
            // Show all categories and subcategories if no product line is selected
            document.querySelectorAll('.category-radio').forEach(radio => {
                radio.closest('label').style.display = 'flex';
            });
            document.querySelectorAll('.subcategory-checkbox').forEach(checkbox => {
                checkbox.closest('label').style.display = 'flex';
            });
            return;
        }
        
        // Make AJAX call to get categories for the selected product line
        fetch(`/admin/product-lines/${selectedProductLineId}/categories`)
            .then(response => response.json())
            .then(data => {
                // Hide all categories and subcategories first
                document.querySelectorAll('.category-radio').forEach(radio => {
                    radio.closest('label').style.display = 'none';
                });
                document.querySelectorAll('.subcategory-checkbox').forEach(checkbox => {
                    checkbox.closest('label').style.display = 'none';
                });
                
                // Show only the categories that are related to this product line
                data.categories.forEach(category => {
                    const categoryRadio = document.querySelector(`.category-radio[value="${category.id}"]`);
                    if (categoryRadio) {
                        categoryRadio.closest('label').style.display = 'flex';
                    }
                    
                    // Show subcategories for this category
                    category.sub_categories.forEach(subCategory => {
                        const subCategoryCheckbox = document.querySelector(`.subcategory-checkbox[value="${subCategory.id}"]`);
                        if (subCategoryCheckbox) {
                            subCategoryCheckbox.closest('label').style.display = 'flex';
                        }
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching categories:', error);
                // Fallback: show all categories if AJAX fails
                document.querySelectorAll('.category-radio').forEach(radio => {
                    radio.closest('label').style.display = 'flex';
                });
                document.querySelectorAll('.subcategory-checkbox').forEach(checkbox => {
                    checkbox.closest('label').style.display = 'flex';
                });
            });
    }
    
    // Initialize category filtering on page load
    filterCategoriesByProductLine();
});
</script>
@endsection 