@extends('layouts.admin')

@section('content')
<div class="flex flex-col h-full min-h-screen">
    <h2 class="text-3xl font-semibold mb-6">Manage Regular Users</h2>

    @if(session('success'))
        <div class="alert alert-success text-white bg-green-500 p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex-grow">
        <table class="table table-bordered w-full text-left" id="usersTable">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-2">#</th>
                    <th class="px-6 py-2">Name</th>
                    <th class="px-6 py-2">Email</th>
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
                        <td class="px-6 py-2">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                            <form class="delete-user-form" action="{{ route('admin.manage-users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm bg-red-500 text-white p-2 rounded-md hover:bg-red-600">
                                    Delete
                                </button>
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
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.delete-user-form');

    // Test if SweetAlert2 is working
    // Swal.fire('SweetAlert2 is working!');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const row = this.closest('tr');
            const action = this.getAttribute('action');
            const formData = new URLSearchParams(new FormData(this));

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
                    fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            // Animate row removal
                            row.style.transition = 'opacity 0.3s';
                            row.style.opacity = 0;

                            setTimeout(() => {
                                row.remove();
                                renumberRows();
                            }, 300);

                            Swal.fire(
                                'Deleted!',
                                'The user has been deleted.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the user.',
                                'error'
                            );
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    });
                }
            });
        });
    });

    function renumberRows() {
        const rows = document.querySelectorAll('#usersTable tbody tr');
        rows.forEach((row, index) => {
            const serialCell = row.querySelector('.serial-number');
            if (serialCell) {
                serialCell.textContent = index + 1;
            }
        });
    }
});
</script>
@endsection
