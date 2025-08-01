@extends('admin.layout')

@section('title', 'Product Lines - BH Cabinetry Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Product Lines</h1>
        <a href="{{ route('admin.product-lines.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Product Line
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
            @forelse($productLines as $productLine)
                <li class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $productLine->doorStyle->name }} - {{ $productLine->doorColor->name }}
                            </div>
                            <span class="ml-2 bg-green-100 text-green-600 text-xs px-2 py-1 rounded">
                                {{ $productLine->categories->count() }} categories
                            </span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.product-lines.edit', $productLine) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.product-lines.destroy', $productLine) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this product line?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-4 text-center text-gray-500">
                    No product lines found.
                </li>
            @endforelse
        </ul>
    </div>

    <div class="mt-6">
        {{ $productLines->links() }}
    </div>
</div>
@endsection 