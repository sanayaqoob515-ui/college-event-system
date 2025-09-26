@extends('layouts.app')
@section('content')
<h2>Admin Analytics Dashboard</h2>
<div class="row mb-4">
  <div class="col-md-2"><div class="card"><div class="card-body"><h5>Events</h5><p class="display-6">{{ $eventCount }}</p></div></div></div>
  <div class="col-md-2"><div class="card"><div class="card-body"><h5>Users</h5><p class="display-6">{{ $userCount }}</p></div></div></div>
  <div class="col-md-2"><div class="card"><div class="card-body"><h5>Registrations</h5><p class="display-6">{{ $registrationCount }}</p></div></div></div>
  <div class="col-md-2"><div class="card"><div class="card-body"><h5>Feedbacks</h5><p class="display-6">{{ $feedbackCount }}</p></div></div></div>
  <div class="col-md-2"><div class="card"><div class="card-body"><h5>Reviews</h5><p class="display-6">{{ $reviewCount }}</p></div></div></div>
</div>
<div class="row mb-4">
  <div class="col-md-6">
    <h5>Registrations by Month</h5>
    <canvas id="regChart"></canvas>
  </div>
  <div class="col-md-6">
    <h5>Events by Category</h5>
    <canvas id="catChart"></canvas>
  </div>
</div>
<div class="row mb-4">
  <div class="col-md-6">
    <h5>Average Review Scores</h5>
    <ul>
      <li>Content: {{ number_format($avgReviewScores['content'],2) }}</li>
      <li>Organization: {{ number_format($avgReviewScores['organization'],2) }}</li>
      <li>Venue: {{ number_format($avgReviewScores['venue'],2) }}</li>
      <li>Speakers: {{ number_format($avgReviewScores['speakers'],2) }}</li>
    </ul>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const regCtx = document.getElementById('regChart').getContext('2d');
new Chart(regCtx, {
  type: 'line',
  data: {
    labels: {!! json_encode(array_keys($registrationsByMonth->toArray())) !!},
    datasets: [{
      label: 'Registrations',
      data: {!! json_encode(array_values($registrationsByMonth->toArray())) !!},
      borderColor: 'blue',
      fill: false
    }]
  }
});
const catCtx = document.getElementById('catChart').getContext('2d');
new Chart(catCtx, {
  type: 'bar',
  data: {
    labels: {!! json_encode(array_keys($eventsByCategory->toArray())) !!},
    datasets: [{
      label: 'Events',
      data: {!! json_encode(array_values($eventsByCategory->toArray())) !!},
      backgroundColor: 'orange'
    }]
  }
});
</script>
@endsection
