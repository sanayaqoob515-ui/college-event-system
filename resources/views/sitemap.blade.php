@extends('layouts.app')
@section('content')
<h2>Sitemap</h2>
<ul>
  <li><a href="{{ route('home') }}">Home</a></li>
  <li><a href="/dashboard">Dashboard</a></li>
  <li><a href="/gallery">Gallery</a></li>
  <li><a href="/my-certificates">Certificates</a></li>
  <li><a href="/reports/csv">Reports</a></li>
  <li><a href="/notifications">Notifications</a></li>
  <li><a href="/sitemap">Sitemap</a></li>
</ul>
@endsection
