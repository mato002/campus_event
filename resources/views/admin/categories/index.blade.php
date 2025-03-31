@extends('layouts.admin')

@section('content')
<div class="flex flex-col h-full min-h-screen">
    <h2 class="text-3xl font-semibold mb-6">Categories List</h2>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-4 bg-blue-500 text-white hover:bg-blue-600 p-3 rounded-md">Create Category</a>

    <div class="flex-grow h-3/4">
        <table class="table table-bordered w-full text-left">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-2">#</th>
                    <th class="px-6 py-2">Category Name</th>
                    <th class="px-6 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="categories-table-body">
                @foreach ($categories as $index => $category)
                    <tr class="border-b border-gray-300" id="category-row-{{ $category->id }}">
                        <td class="px-6 py-2">{{ $categories->firstItem() + $index }}</td>
                        <td class="px-6 py-2">{{ $category->name }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600">Edit</a>
                            <button type="button"
                                class="btn btn-danger btn-sm bg-red-500 text-white p-2 rounded-md hover:bg-red-600 delete-btn"
                                data-category-id="{{ $category->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Laravel's built-in pagination -->
    <div class="mt-4">
        {{ $categories->links() }} <!-- Laravel's pagination links -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            let categoryId = this.getAttribute("data-category-id");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/categories/${categoryId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json"
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "The category has been deleted successfully.",
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Remove category row from table
                            document.getElementById(`category-row-${categoryId}`).remove();
                        } else {
                            Swal.fire("Error!", data.message, "error");
                        }
                    }).catch(error => {
                        Swal.fire("Error!", "An unexpected error occurred.", "error");
                    });
                }
            });
        });
    });
});
</script>
@endsection
