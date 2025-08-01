@extends('admin.layout')

@section('title', 'Door Colors - BH Cabinetry Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Door Colors</h1>
        <a href="{{ route('admin.door-colors.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Door Color
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
            @forelse($doorColors as $doorColor)
                <li class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($doorColor->image)
                                <img src="{{ asset($doorColor->image) }}" alt="{{ $doorColor->name }}" class="h-10 w-10 rounded object-cover mr-3">
                            @endif
                            <div class="text-sm font-medium text-gray-900">
                                {{ $doorColor->name }}
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.door-colors.edit', $doorColor) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.door-colors.destroy', $doorColor) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this door color?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-4 text-center text-gray-500">
                    No door colors found.
                </li>
            @endforelse
        </ul>
    </div>

    <div class="mt-6">
        {{ $doorColors->links() }}
    </div>
</div>
@endsection 