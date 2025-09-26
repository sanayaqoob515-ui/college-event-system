@extends('layouts.app')
@section('content')
<h2>Attendance for {{ $event->title }}</h2>
<table class="table">
  <tr><th>Student</th><th>Status</th><th>Action</th></tr>
  @foreach($registrations as $reg)
    <tr>
      <td>{{ $reg->student->name ?? '' }}</td>
      <td>
        @php
          $att = $attendances->firstWhere('student_id', $reg->student_id);
        @endphp
        @if($att && $att->attended)
          <span class="text-success">Present</span>
        @else
          <span class="text-danger">Absent</span>
        @endif
      </td>
      <td>
        @if(!($att && $att->attended))
        <form method="POST" action="{{ route('attendance.mark', [$event->id, $reg->student_id]) }}">
          @csrf
          <button class="btn btn-sm btn-success">Mark Present</button>
        </form>
        @endif
      </td>
    </tr>
  @endforeach
</table>
@endsection
