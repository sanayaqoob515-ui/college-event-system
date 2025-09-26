@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <h3>{{ $event->title }}</h3>
    <p>{{ $event->description }}</p>
    <p><strong>Date:</strong> {{ $event->date }} <strong>Time:</strong> {{ $event->time }}</p>
    <p><strong>Venue:</strong> {{ $event->venue }}</p>
    <p><strong>Seats:</strong> {{ $event->seats_booked }}/{{ $event->max_participants }}</p>
    @auth
      <form method="POST" action="{{ route('events.register', $event->id) }}">@csrf<button class="btn btn-primary">Register</button></form>
    @else
      <a href="/login" class="btn btn-outline-primary">Login to register</a>
    @endauth
    <hr>
  <a href="data:text/calendar;charset=utf8,BEGIN:VCALENDAR%0AVERSION:2.0%0AUID:{{ uniqid() }}%0ADTSTAMP:{{ now()->format('Ymd\THis\Z') }}%0ASUMMARY:{{ urlencode($event->title) }}%0ADTSTART;TZID=Asia/Karachi:{{ $event->date }}T{{ str_replace(':','',$event->time) }}00%0ADTEND;TZID=Asia/Karachi:{{ $event->date }}T{{ str_pad((int)substr($event->time,0,2)+1,2,'0',STR_PAD_LEFT) }}{{ substr($event->time,3,2) }}00%0ALOCATION:{{ urlencode($event->venue) }}%0ADESCRIPTION:{{ urlencode($event->description) }}%0AEND:VEVENT%0AEND:VCALENDAR" download="event.ics" class="btn btn-sm btn-outline-secondary">Add to Calendar (.ics)</a>
  <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($event->title) }}&dates={{ $event->date }}T{{ str_replace(':','',$event->time) }}00Z/{{ $event->date }}T{{ str_pad((int)substr($event->time,0,2)+1,2,'0',STR_PAD_LEFT) }}{{ substr($event->time,3,2) }}00Z&details={{ urlencode($event->description) }}&location={{ urlencode($event->venue) }}" target="_blank" class="btn btn-sm btn-outline-success">Google Calendar</a>
  <a href="https://outlook.live.com/calendar/0/deeplink/compose?subject={{ urlencode($event->title) }}&body={{ urlencode($event->description) }}&startdt={{ $event->date }}T{{ $event->time }}&enddt={{ $event->date }}T{{ str_pad((int)substr($event->time,0,2)+1,2,'0',STR_PAD_LEFT) }}:{{ substr($event->time,3,2) }}&location={{ urlencode($event->venue) }}" target="_blank" class="btn btn-sm btn-outline-primary">Outlook</a>
    <div class="mt-2">
      <span>Share:</span>
      <a target="_blank" href="https://wa.me/?text={{ urlencode($event->title.' on '.$event->date) }}" onclick="fetch('{{ route('events.logShare', $event->id) }}', {method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},body:JSON.stringify({platform:'WhatsApp',message:'{{ $event->title }} on {{ $event->date }}'})});">WhatsApp</a> |
      <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" onclick="fetch('{{ route('events.logShare', $event->id) }}', {method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},body:JSON.stringify({platform:'Facebook',message:'{{ $event->title }}'})});">Facebook</a> |
      <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($event->title) }}" onclick="fetch('{{ route('events.logShare', $event->id) }}', {method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},body:JSON.stringify({platform:'LinkedIn',message:'{{ $event->title }}'})});">LinkedIn</a>
    </div>
    <script>
    function logCalendarSync(type, url) {
      fetch('{{ route('events.logCalendar', $event->id) }}', {
        method:'POST',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},
        body:JSON.stringify({calendar_type:type,calendar_url:url})
      });
    }
    </script>
  </div>
</div>

@auth
  <hr>
  <h4>Submit Multi-Aspect Review</h4>
  <form method="POST" action="{{ route('events.review', $event->id) }}">
    @csrf
    <div class="row">
      <div class="col-md-3 mb-2">
        <label>Content</label>
        <select name="content_rating" class="form-control" required>
          <option value="">Select</option>
          @for($i=1; $i<=5; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3 mb-2">
        <label>Organization</label>
        <select name="organization_rating" class="form-control" required>
          <option value="">Select</option>
          @for($i=1; $i<=5; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3 mb-2">
        <label>Venue</label>
        <select name="venue_rating" class="form-control" required>
          <option value="">Select</option>
          @for($i=1; $i<=5; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3 mb-2">
        <label>Speakers</label>
        <select name="speakers_rating" class="form-control" required>
          <option value="">Select</option>
          @for($i=1; $i<=5; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
      </div>
    </div>
    <div class="mb-2">
      <label>Comments</label>
      <textarea name="comments" class="form-control" maxlength="2000"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Submit Review</button>
  </form>
  <form method="POST" action="{{ route('favorites.addEvent', $event->id) }}" class="mt-2">
    @csrf
    <button class="btn btn-outline-success btn-sm">Add to Favorites</button>
  </form>
@endauth

<hr>
<h4>Event Reviews (Multi-Aspect)</h4>
<div class="mb-2">
  <strong>Average Ratings:</strong>
  <ul>
    <li>Content: {{ number_format($avg['content'], 2) ?? 'N/A' }}</li>
    <li>Organization: {{ number_format($avg['organization'], 2) ?? 'N/A' }}</li>
    <li>Venue: {{ number_format($avg['venue'], 2) ?? 'N/A' }}</li>
    <li>Speakers: {{ number_format($avg['speakers'], 2) ?? 'N/A' }}</li>
  </ul>
  <canvas id="ratingsChart" width="400" height="200"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('ratingsChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Content', 'Organization', 'Venue', 'Speakers'],
      datasets: [{
        label: 'Average Rating',
        data: [
          {{ $avg['content'] ?? 0 }},
          {{ $avg['organization'] ?? 0 }},
          {{ $avg['venue'] ?? 0 }},
          {{ $avg['speakers'] ?? 0 }}
        ],
        backgroundColor: [
          'rgba(54, 162, 235, 0.7)',
          'rgba(255, 206, 86, 0.7)',
          'rgba(75, 192, 192, 0.7)',
          'rgba(255, 99, 132, 0.7)'
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          max: 5
        }
      }
    }
  });
</script>
@foreach($reviews as $review)
  <div class="border p-2 mb-2">
    <strong>{{ $review->user->name }}</strong> <br>
    <span>Content: {{ $review->content_rating }}, Organization: {{ $review->organization_rating }}, Venue: {{ $review->venue_rating }}, Speakers: {{ $review->speakers_rating }}</span><br>
    <small>{{ $review->created_at->diffForHumans() }}</small>
    <p>{{ $review->comments }}</p>
  </div>
@endforeach
@endsection
