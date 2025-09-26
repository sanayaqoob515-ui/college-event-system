@extends('layouts.app')
@section('content')
<h2>My Certificates</h2>
<ul>
@foreach($certs as $c)
<li>
	@if(!$c->fee_paid)
		<form method="POST" action="{{ route('certificates.pay', $c->id) }}" style="display:inline">
			@csrf
			<button class="btn btn-sm btn-warning">Pay Certificate Fee</button>
		</form>
		<span class="text-danger">(Fee not paid)</span>
	@else
		<a href='/storage/{{ $c->certificate_url }}' target='_blank'>Certificate for Event {{ $c->event_id }}</a>
	@endif
</li>
@endforeach
</ul>
@endsection