@extends('layouts.app')
@section('content')
<h3>Event Feedback</h3>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<form method="POST" action="{{ route('feedback.store', $event->id) }}">
    @csrf
    <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <select name="rating" id="rating" class="form-control" required>
            <option value="">Select</option>
            @for($i=1; $i<=5; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="mb-3">
        <label for="comment" class="form-label">Comment</label>
        <textarea name="comment" id="comment" class="form-control" maxlength="1000"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit Feedback</button>
</form>
<hr>
<h4>All Feedback</h4>
@foreach($feedbacks as $fb)
    <div class="border p-2 mb-2">
        <strong>{{ $fb->user->name }}</strong> - Rating: {{ $fb->rating }}<br>
        <small>{{ $fb->created_at->diffForHumans() }}</small>
        <p>{{ $fb->comment }}</p>
    </div>
@endforeach
@endsection
