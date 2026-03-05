@extends('admin.layout.app')

@section('title','Tower Data')

@section('content')
<div class="card">
    <div class="card-header">Tower / Floor / Flat Structure</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="card-body">
        @foreach($towers as $tower)
            <h5 class="text-primary">🏢 {{ $tower->name }}</h5>

            @foreach($tower->floors as $floor)
                <div class="ms-3">
                    <strong>Floor {{ $floor->floor_no }}</strong>

                    <div class="ms-4">
                        @foreach($floor->flats as $flat)
                            <span class="badge bg-secondary me-1">
                                Flat {{ $flat->flat_no }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <hr>
        @endforeach
    </div>
</div>
@endsection
