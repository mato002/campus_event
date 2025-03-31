@extends('layouts.admin')

@section('content')
<div class="flex flex-col h-full min-h-screen">
    <h2 class="text-3xl font-semibold mb-6">Edit Category</h2>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-lg font-medium">Category Name</label>
            <input type="text" name="name" id="name" class="input-field w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter category name" value="{{ old('name', $category->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary bg-blue-500 text-white hover:bg-blue-600 p-3 rounded-md">Update Category</button>
    </form>
</div>
@endsection
