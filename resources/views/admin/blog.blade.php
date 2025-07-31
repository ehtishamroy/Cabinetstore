@extends('admin.layout')

@section('title', 'Blog - Aura Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Blog Posts</h1>
            <p class="text-gray-600 mt-1">Create and manage your articles.</p>
        </div>
        <button class="mt-4 sm:mt-0 bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg flex items-center hover:bg-gray-900">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Write New Post
        </button>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Author</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium">Top 5 Kitchen Cabinet Trends...</td>
                        <td class="px-4 py-3">Jane Doe</td>
                        <td class="px-4 py-3">July 20, 2025</td>
                        <td class="px-4 py-3 text-green-600 font-medium">Published</td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-button">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </button>
                            <button class="action-button text-red-500">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 