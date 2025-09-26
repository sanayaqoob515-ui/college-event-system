@extends('layouts.app')
@section('content')
<h2>Send Announcement</h2>
<form method="POST" action="{{ route('announcements.store') }}">
  @csrf
  <div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Message</label>
    <textarea name="message" class="form-control" required></textarea>
  </div>
  <div class="mb-3">
    <label>Target Role (optional)</label>
    <select name="target_role" class="form-control">
      <option value="">All</option>
      <option value="student">Student</option>
      <option value="organizer">Organizer</option>
      <option value="admin">Admin</option>
    </select>
  </div>
  <div class="mb-3">
    <label>Target User (optional)</label>
    <select name="target_user_id" class="form-control">
      <option value="">None</option>
      @foreach($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
      @endforeach
    </select>
  </div>
  <button class="btn btn-primary">Send</button>
</form>
@endsection
