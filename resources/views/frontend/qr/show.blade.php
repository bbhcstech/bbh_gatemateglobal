  @extends('frontend.layouts-frontend.app')

@section('title', 'Home Page')  

@section('content')

<div class="container py-4">
    <h1 class="mb-3">{{ $qr->name ?? 'QR Code' }}</h1>

    <div class="mb-3">
        <img src="{{ $publicUrl }}" alt="QR Code" style="max-width: 400px; width: 100%; height: auto;">
    </div>

    <p class="text-muted mb-3">
        Type: <strong>{{ strtoupper($qr->type) }}</strong>
        @if($qr->category) • Category: <strong>{{ $qr->category }}</strong> @endif
    </p>

    <a class="btn btn-success me-2" href="{{ route('qr.download', $qr) }}">Download SVG</a>
    <a class="btn btn-outline-secondary" href="{{ route('qr.create') }}">Create another</a>
</div>

@endsection