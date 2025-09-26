@extends('layouts.app')
@section('content')
<h2>Organizer Dashboard</h2>
<h4>Your Events</h4>
<ul>
  @foreach($events as $ev)
    <li>
      {{ $ev->title }} - Status: {{ $ev->status }} | Slots: {{ $ev->max_participants - $ev->seats_booked }}/{{ $ev->max_participants }}
      <form method="POST" action="{{ route('organizer.updateSlots', $ev->id) }}" style="display:inline">
        @csrf
        <input type="number" name="max_participants" value="{{ $ev->max_participants }}" min="1" style="width:80px">
        <button class="btn btn-sm btn-info">Update Slots</button>
      </form>
    </li>
  @endforeach
</ul>
@endsection
