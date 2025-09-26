@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h3>Register</h3>
    <form method="POST" action="/register">
      @csrf
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input class="form-control" name="name" required>
      </div>
      <div class="mb-3">
        <label class="form-label">User Type</label>
        <select class="form-control" name="role" required>
          <option value="student">Student</option>
          <option value="organizer">Organizer</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Mobile</label>
        <input class="form-control" name="mobile">
      </div>
      <div class="mb-3">
        <label class="form-label">Department</label>
        <input class="form-control" name="department">
      </div>
      <div class="mb-3">
        <label class="form-label">Enrollment No</label>
        <input class="form-control" name="enrollment_no">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" name="email" type="email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" name="password" type="password" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input class="form-control" name="password_confirmation" type="password" required>
      </div>
      <button class="btn btn-success">Create account</button>
    </form>
  </div>
</div>
@endsection
