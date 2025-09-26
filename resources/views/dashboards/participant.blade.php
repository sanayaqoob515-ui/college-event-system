@extends('layouts.app')
@section('content')
<h2>Participant Dashboard</h2>
<h4>My Registrations</h4>
<ul>
  @foreach($regs as $reg)
    <li>
      {{ $reg->event->title }} - Status: {{ $reg->status }}
      <form method="POST" action="{{ route('registrations.cancel', $reg->id) }}" style="display:inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Cancel</button>
      </form>
    </li>
  @endforeach
</ul>

<h4>Join Waitlist for Full Events</h4>
<form method="POST" action="{{ route('events.waitlist', ['id' => 0]) }}" onsubmit="event.preventDefault(); var id = prompt('Enter Event ID to join waitlist:'); if(id) { this.action = this.action.replace('/0', '/' + id); this.submit(); }">
    @csrf
    <button class="btn btn-sm btn-warning">Join Waitlist</button>
</form>
@endsection
