@extends('layouts.app')
@section('content')
<h2>Upload Media</h2>
<form method="POST" action="{{ route('gallery.upload') }}" enctype="multipart/form-data">
  @csrf
  <div class="mb-2">
    <label>Event</label>
    <input type="text" name="event_id" class="form-control" required>
  </div>
  <div class="mb-2">
    <label>File</label>
    <input type="file" name="file" class="form-control" required>
  </div>
  <div class="mb-2">
    <label>Caption</label>
    <input type="text" name="caption" class="form-control">
  </div>
  <div class="mb-2">
    <label>Subcategory</label>
    <select name="subcategory_id" class="form-control">
      <option value="">None</option>
      @foreach($categories as $cat)
        <optgroup label="{{ $cat->name }}">
          @foreach($cat->subcategories as $sub)
            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
          @endforeach
      </optgroup>
      @endforeach
    </select>
  </div>
  <button class="btn btn-primary">Upload</button>
</form>
@endsection
