@extends('layouts.app')
@section('content')

<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg rounded-4 border-0" style="width: 26rem; background: #f8f9fa;">
        
        <div class="card-body p-4">
            
            <img src="{{ asset('assets/userimage/' . $user->image) }}" class="rounded-circle mb-3 mx-auto d-block" alt="Instructor Image" style="width: 120px; height: 120px; object-fit: cover;">
                
            <h3 class="card-title text-primary fw-bold mb-3 text-center">
                {{ $user->name }}
            </h3>

            <ul class="list-group list-group-flush mb-4">
                
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Email:</strong>
                    <span>{{ $user->email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Phone:</strong>
                    <span>{{ $user->phone }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Address:</strong>
                    <span>{{ $user->address }}</span>
                </li>
                
                <li class="list-group-item d-flex justify-content-between">
                    <strong>User Type:</strong>
                    <span>{{ $user->role }}</span>
                </li>
            
            </ul>

            <div class="text-center">
                <a class="btn btn-outline-primary px-4" href="/home">
                    ⬅️ Back To Home
                </a>
                <a class="btn btn-outline-secondary px-4" href="{{route('user.edit')}}">
                    Update Myprofile
                </a>
            </div>
        </div>
    </div>
</div>


@endsection