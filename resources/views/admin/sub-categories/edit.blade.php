@extends('admin.layout')

@section('title', 'Edit Sub Category - BH Cabinetry Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Sub Category</h1>
        <p class="text-gray-600 mt-1">Update the sub category information.</p>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.sub-categories.update', $subCategory) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                    <select name="category_id" id="category_id" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                            required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $subCategory->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Sub Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $subCategory->name) }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="e.g., 2 Drawer Base Cabinet, Single Door Base Cabinet"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL (Optional)</label>
                    <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $subCategory->image_url) }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="https://example.com/image.jpg">
                    @error('image_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.sub-categories.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Sub Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 