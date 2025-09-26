@extends('layouts.app')

@section('content')
<form method="GET" action="{{ route('home') }}" class="mb-3">
  <div class="row">
    <div class="col-md-2"><input type="text" name="q" class="form-control" placeholder="Keyword" value="{{ request('q') }}"></div>
    <div class="col-md-2"><input type="text" name="category" class="form-control" placeholder="Category" value="{{ request('category') }}"></div>
    <div class="col-md-2"><input type="text" name="department" class="form-control" placeholder="Department" value="{{ request('department') }}"></div>
    <div class="col-md-2"><input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}"></div>
    <div class="col-md-2"><input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}"></div>
    <div class="col-md-2"><button class="btn btn-primary w-100">Search</button></div>
  </div>
</form>

@if(isset($events))
  <div class="list-group">
    @foreach($events as $event)
      <a href="{{ route('events.show', $event->id) }}" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">{{ $event->title }}</h5>
          <small>{{ $event->date }}</small>
        </div>
        <p class="mb-1">{{ Str::limit($event->description, 120) }}</p>
        <small>Venue: {{ $event->venue }} | Slots: <span id="slots-{{ $event->id }}">{{ $event->max_participants - $event->seats_booked }}</span> / {{ $event->max_participants }}</small>
      </a>
    @endforeach
  </div>
  <div class="mt-3">{{ $events->links() ?? '' }}</div>
@endif
@endsection