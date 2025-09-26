@extends('layouts.app')
@section('content')
<h3>Edit Profile</h3>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
<hr>
<h4>Change Password</h4>
@if($errors->has('current_password'))
    <div class="alert alert-danger">{{ $errors->first('current_password') }}</div>
@endif
<form method="POST" action="{{ route('profile.password') }}">
    @csrf
    <div class="mb-3">
        <label>Current Password</label>
        <input type="password" name="current_password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>New Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Confirm New Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-warning">Change Password</button>
</form>
@endsection
