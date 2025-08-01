@extends('admin.layout')

@section('title', 'Categories - BH Cabinetry Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Category
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($categories as $category)
                <li class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="h-10 w-10 rounded object-cover mr-3">
                            @endif
                            <div class="text-sm font-medium text-gray-900">
                                {{ $category->name }}
                            </div>
                            <span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                {{ $category->sub_categories_count }} sub categories
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-4 text-center text-gray-500">
                    No categories found.
                </li>
            @endforelse
        </ul>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>
@endsection 