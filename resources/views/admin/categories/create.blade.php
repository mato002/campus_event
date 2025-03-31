@extends('layouts.admin')

@section('content')
<div class="flex flex-col h-full min-h-screen">
    <h2 class="text-3xl font-semibold mb-6">Create Category</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-lg font-medium">Category Name</label>
            <input type="text" name="name" id="name" class="input-field w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter category name" required>
        </div>

        <button type="submit" class="btn btn-primary bg-blue-500 text-white hover:bg-blue-600 p-3 rounded-md">Save Category</button>
    </form>
</div>
@endsection
