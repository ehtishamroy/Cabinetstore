@extends('admin.layout')

@section('title', 'Create Door Style - BH Cabinetry Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Create New Door Style</h1>
        <p class="text-gray-600 mt-1">Add a new door style to the system.</p>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.door-styles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Door Style Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Door Style Image</label>
                    <input type="file" name="image" id="image" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Upload an image for this door style (optional). Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.door-styles.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Door Style
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 