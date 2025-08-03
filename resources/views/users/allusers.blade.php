@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Users</h2>

    @if(session('status'))
        <div class="alert alert-warning">{{ session('status') }}</div>
    @endif
    @if(session('deleted'))
        <div class="alert alert-danger">{{ session('deleted') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge 
                            @if($user->role === 'admin') bg-danger 
                            @elseif($user->role === 'vendor') bg-primary 
                            @else bg-secondary @endif">
                            {{ ucfirst($user->role) }}
                        </span></td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                    
                        <a class="btn btn-sm btn-outline-danger"
                            href="{{ route('user.delete', $user->id) }}"
                            onclick="return confirm('Are You Sure You Want To Delete This User?')">
                                <i class="fas fa-trash-alt"></i>
                        </a>

                            <a class="btn btn-sm btn-outline-secondary"
                            href="{{ route('user.lock', $user->id) }}"
                            onclick="return confirm('{{ $user->is_locked ? 'Are you sure you want to unlock this user?' : 'Are you sure you want to lock this user?' }}')">
                                <i class="{{ $user->is_locked ? 'fas fa-lock' : 'fas fa-lock-open' }}"></i>
                        </a>


                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
