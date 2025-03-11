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
        <table class="table table-bordered w-full text-left">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-2">ID</th>
                    <th class="px-6 py-2">Name</th>
                    <th class="px-6 py-2">Email</th>
                    <th class="px-6 py-2">Registered At</th>
                    <th class="px-6 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b border-gray-300">
                        <td class="px-6 py-2">{{ $user->id }}</td>
                        <td class="px-6 py-2">{{ $user->name }}</td>
                        <td class="px-6 py-2">{{ $user->email }}</td>
                        <td class="px-6 py-2">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                            <form action="{{ route('admin.manage-users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm bg-red-500 text-white p-2 rounded-md hover:bg-red-600" onclick="return confirm('Are you sure?')">
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
