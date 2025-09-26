<h2>Events Report</h2>
<table border="1" cellpadding="5">
<tr><th>Title</th><th>Date</th><th>Venue</th><th>Category</th></tr>
@foreach($events as $e)
<tr>
  <td>{{ $e->title }}</td>
  <td>{{ $e->date }}</td>
  <td>{{ $e->venue }}</td>
  <td>{{ $e->category }}</td>
</tr>
@endforeach
</table>
