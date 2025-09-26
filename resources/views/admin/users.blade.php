@extends('layouts.app')
@section('content')
<h2>All Users</h2>
<table class="table">
  <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr>
  @foreach($users as $user)
    <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>
        <form method="POST" action="{{ route('admin.updateRole', $user->id) }}">
          @csrf
          <select name="role" onchange="this.form.submit()">
            <option value="student" @if($user->role=='student') selected @endif>Student</option>
            <option value="organizer" @if($user->role=='organizer') selected @endif>Organizer</option>
            <option value="admin" @if($user->role=='admin') selected @endif>Admin</option>
          </select>
        </form>
      </td>
      <td>{{ $user->status ?? 'active' }}</td>
      <td>
        <form method="POST" action="{{ route('admin.suspend', $user->id) }}" style="display:inline">@csrf<button class="btn btn-sm btn-warning">Suspend</button></form>
        <form method="POST" action="{{ route('admin.delete', $user->id) }}" style="display:inline">@csrf<button class="btn btn-sm btn-danger">Delete</button></form>
      </td>
    </tr>
  @endforeach
</table>
@endsection
