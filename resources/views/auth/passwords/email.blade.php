@extends('layouts.app')
@section('content')
<h2>Reset Password</h2>
@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-2">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <button class="btn btn-primary">Send Password Reset Link</button>
</form>
@endsection
