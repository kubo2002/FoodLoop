@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1>My Profile</h1>

        <div class="card p-4">
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Role:</strong> {{ auth()->user()->role }}</p>
            <a href="#" class="btn btn-primary mt-3">Edit Profile</a>
        </div>
    </div>
@endsection
