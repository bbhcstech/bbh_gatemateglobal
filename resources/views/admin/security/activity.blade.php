@extends('admin.layout.app')

@section('content')

<h4>Activity Timeline</h4>

<table class="table table-bordered">
<tr>
    <th>Type</th>
    <th>Description</th>
    <th>Time</th>
</tr>

@foreach($logs as $log)
<tr>
    <td>{{ $log->type }}</td>
    <td>{{ $log->description }}</td>
    <td>{{ $log->time }}</td>
</tr>
@endforeach

</table>

@endsection
