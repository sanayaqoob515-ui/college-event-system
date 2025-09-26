@extends('layouts.app')
@section('content')
<h2>Admin Dashboard</h2>
<h4>Pending Events</h4>
<ul>
  @foreach($pending as $ev)
    <li>{{ $ev->title }} 
      <form action="/admin/events/{{ $ev->id }}/approve" method="POST" style="display:inline">@csrf<button class="btn btn-sm btn-success">Approve</button></form>
      <form action="/admin/events/{{ $ev->id }}/reject" method="POST" style="display:inline">@csrf<button class="btn btn-sm btn-danger">Reject</button></form>
    </li>
  @endforeach
</ul>
<h4>Approved Events</h4>
<ul>
  @foreach($approved as $ev)
    <li>{{ $ev->title }} ({{ $ev->date }})</li>
  @endforeach
</ul>
@endsection
