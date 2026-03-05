@extends('admin.layout.app')

@section('content')

<h4>Security Alerts</h4>

<form method="POST" action="{{ route('alerts.store') }}">
@csrf

<select name="alert_type" class="form-control mb-2">
    <option>Emergency</option>
    <option>Call</option>
    <option>Kid Exit</option>
</select>

<textarea name="message" class="form-control mb-2"></textarea>

<button class="btn btn-danger">Create Alert</button>

</form>

<hr>

@foreach($alerts as $alert)

<div class="card p-2 mb-2">
    <b>{{ $alert->alert_type }}</b> - {{ $alert->message }}

    <span class="badge bg-info">{{ $alert->status }}</span>

    @if($alert->status == 'Open')
    <form method="POST" action="{{ route('alerts.resolve',$alert->alert_id) }}">
        @csrf
        <button class="btn btn-success btn-sm">Resolve</button>
    </form>
    @endif
</div>

@endforeach

@endsection
