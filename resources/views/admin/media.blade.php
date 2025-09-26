@extends('layouts.app')
@section('content')
<h2>Moderate Media</h2>
@foreach($media as $m)
  <div class="border p-2 mb-2">
    <img src="/storage/{{ $m->file_url }}" width="100"> {{ $m->caption }}
    <form method="POST" action="#" style="display:inline">@csrf<button class="btn btn-sm btn-danger">Delete</button></form>
  </div>
@endforeach
@endsection
