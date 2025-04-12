@extends('layouts.admin')

@section('content')
<div class="flex flex-col h-full min-h-screen">
    <h2 class="text-3xl font-semibold mb-6">Manage Regular Users</h2>

    @if(session('success'))
        <div class="alert alert-success text-white bg-green-500 p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" id="searchInput" class="border p-2 w-full rounded" placeholder="Search by name or email...">
    </div>

    <div class="flex-grow overflow-x-auto">
        <table class="table table-bordered w-full text-left" id="usersTable">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-2">#</th>
                    <th class="px-6 py-2">Name</th>
                    <th class="px-6 py-2">Email</th>
                    <th class="px-6 py-2">Status</th>
                    <th class="px-6 py-2">Registered At</th>
                    <th class="px-6 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr class="border-b border-gray-300 user-row" data-id="{{ $user->id }}">
                        <td class="px-6 py-2 serial-number">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2">{{ $user->name }}</td>
                        <td class="px-6 py-2">{{ $user->email }}</td>
                        <td class="px-6 py-2">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td class="px-6 py-2">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                            @if($user->status == 1)
                                <!-- Deactivate Button -->
                                <form action="{{ route('admin.manage-users.deactivate', $user->id) }}" method="POST" class="deactivate-user-form">
                                    @csrf
                                    <button type="submit" class="bg-yellow-500 text-white p-2 rounded-md hover:bg-yellow-600">Deactivate</button>
                                </form>
                            @else
                                <!-- Activate Button -->
                                <form action="{{ route('admin.manage-users.activate', $user->id) }}" method="POST" class="activate-user-form">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white p-2 rounded-md hover:bg-green-600">Activate</button>
                                </form>
                            @endif
                            <!-- Delete Button -->
                            <form class="delete-user-form" action="{{ route('admin.manage-users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white p-2 rounded-md hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-auto flex justify-between p-4 bg-gray-100">
        {{ $users->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.delete-user-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // Search Filter
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#usersTable tbody tr');

        rows.forEach(row => {
            const name = row.children[1].textContent.toLowerCase();
            const email = row.children[2].textContent.toLowerCase();

            if (name.includes(filter) || email.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
