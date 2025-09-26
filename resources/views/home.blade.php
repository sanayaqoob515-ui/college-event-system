@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8">
    <h1>Upcoming Events</h1>
    @include('events.index')
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5>About</h5>
        <p>EventSphere - College Event Management platform (Phase 1)</p>
      </div>
    </div>
  </div>
</div>
@endsection
