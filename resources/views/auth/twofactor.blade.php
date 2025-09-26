@extends('layouts.app')
@section('content')
<h2>Two-Factor Authentication</h2>
@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif
<form method="POST" action="{{ route('2fa.verify') }}">
  @csrf
  <div class="mb-2">
    <label>Enter the 6-digit code sent to your email</label>
    <input type="text" name="two_factor_code" class="form-control" required maxlength="6">
  </div>
  <button class="btn btn-primary">Verify</button>
</form>
<form method="POST" action="{{ route('2fa.send') }}" class="mt-2">
  @csrf
  <button class="btn btn-link">Resend Code</button>
</form>
@endsection
