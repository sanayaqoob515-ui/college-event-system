@extends('layouts.app')
@section('content')
<h2>Gallery</h2>
<form method="GET" class="mb-3">
	<div class="row">
		<div class="col-md-4">
			<select name="category" class="form-control" onchange="this.form.submit()">
				<option value="">All Categories</option>
				@foreach($categories as $cat)
					<option value="{{ $cat->id }}" @if($selectedCategory==$cat->id) selected @endif>{{ $cat->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-4">
			<select name="subcategory" class="form-control" onchange="this.form.submit()">
				<option value="">All Subcategories</option>
				@if($selectedCategory)
					@foreach($categories->where('id',$selectedCategory)->first()->subcategories ?? [] as $sub)
						<option value="{{ $sub->id }}" @if($selectedSubcategory==$sub->id) selected @endif>{{ $sub->name }}</option>
					@endforeach
				@else
					@foreach($categories as $cat)
						@foreach($cat->subcategories as $sub)
							<option value="{{ $sub->id }}" @if($selectedSubcategory==$sub->id) selected @endif>{{ $cat->name }} - {{ $sub->name }}</option>
						@endforeach
					@endforeach
				@endif
			</select>
		</div>
		<div class="col-md-4">
			<button class="btn btn-primary">Filter</button>
		</div>
	</div>
</form>
<div class='row'>
@foreach($media as $m)
	<div class='col-md-3 mb-3'>
		<img src="{{ asset('storage/' . $m->file_url) }}" class='img-fluid'>
		<p>{{ $m->caption }}</p>
		@if($m->subcategory)
			<small class="text-muted">{{ $m->subcategory->category->name ?? '' }} / {{ $m->subcategory->name }}</small>
		@endif
	</div>
@endforeach
</div>
@endsection