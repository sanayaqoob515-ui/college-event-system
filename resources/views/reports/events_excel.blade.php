<table border="1" cellpadding="5">
<tr><th>Title</th><th>Date</th><th>Venue</th><th>Category</th></tr>
@foreach($data as $row)
<tr>
  <td>{{ $row['Title'] }}</td>
  <td>{{ $row['Date'] }}</td>
  <td>{{ $row['Venue'] }}</td>
  <td>{{ $row['Category'] }}</td>
</tr>
@endforeach
</table>
