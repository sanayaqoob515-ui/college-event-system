@extends('layouts.app')
@section('content')
<h2>Announcements</h2>
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@foreach($announcements as $a)
  <div class="border p-2 mb-2">
    <strong>{{ $a->title }}</strong> <small>({{ $a->created_at->diffForHumans() }})</small><br>
    <p>{{ $a->message }}</p>
  </div>
@endforeach
@endsection
