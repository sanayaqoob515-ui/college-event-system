@extends('layouts.app')
@section('content')
<h3>My Favorite Events</h3>
<ul>
@foreach($events as $fav)
    <li>{{ $fav->event->title ?? '' }}</li>
@endforeach
</ul>
<hr>
<h3>My Favorite Media</h3>
<ul>
@foreach($media as $fav)
    <li>
        @if($fav->media)
            <img src="/storage/{{ $fav->media->file_url }}" width="100"> {{ $fav->media->caption }}
        @endif
    </li>
@endforeach
</ul>
@endsection
