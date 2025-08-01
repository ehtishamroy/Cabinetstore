@extends('admin.layout')

@section('title', 'Create Product Line - BH Cabinetry Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Create New Product Line</h1>
        <p class="text-gray-600 mt-1">Create a new product line by combining a door style with a door color.</p>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.product-lines.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Door Style -->
                    <div>
                        <label for="door_style_id" class="block text-sm font-medium text-gray-700">Door Style</label>
                        <select name="door_style_id" id="door_style_id" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                required>
                            <option value="">Select a door style</option>
                            @foreach($doorStyles as $doorStyle)
                                <option value="{{ $doorStyle->id }}" {{ old('door_style_id') == $doorStyle->id ? 'selected' : '' }}>
                                    {{ $doorStyle->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('door_style_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Door Color -->
                    <div>
                        <label for="door_color_id" class="block text-sm font-medium text-gray-700">Door Color</label>
                        <select name="door_color_id" id="door_color_id" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                required>
                            <option value="">Select a door color</option>
                            @foreach($doorColors as $doorColor)
                                <option value="{{ $doorColor->id }}" {{ old('door_color_id') == $doorColor->id ? 'selected' : '' }}>
                                    {{ $doorColor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('door_color_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Categories -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Available Categories</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('admin.product-lines.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Product Line
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 