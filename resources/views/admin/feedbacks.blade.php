@extends('layouts.app')
@section('content')
<h2>Moderate Feedback</h2>
@foreach($feedbacks as $fb)
  <div class="border p-2 mb-2">
    <strong>{{ $fb->user->name ?? '' }}</strong> - Rating: {{ $fb->rating }}<br>
    <small>{{ $fb->created_at->diffForHumans() }}</small>
    <p>{{ $fb->comment }}</p>
    <form method="POST" action="#" style="display:inline">@csrf<button class="btn btn-sm btn-danger">Delete</button></form>
  </div>
@endforeach
@endsection
