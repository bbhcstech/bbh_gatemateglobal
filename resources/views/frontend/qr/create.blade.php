@extends('frontend.layouts-frontend.app')

@section('title', 'Home Page')  

@section('content')
<div class="container py-4">
    <h1 class="mb-3">Create QR Code</h1>

    <form method="POST" action="{{ route('qr.store') }}" x-data="{ type: 'url' }">
        @csrf

        {{-- Type --}}
        <div class="mb-3">
            <label class="form-label">Type</label>
            <select class="form-select" name="type" x-model="type">
                <option value="url">URL / Link</option>
                <option value="text">Text</option>
                <option value="wifi">Wi-Fi</option>
                <option value="map">Map (geo)</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="audio">Audio (Link)</option>
                <option value="pdf">PDF (Link)</option>
                <option value="app">Play Market / App Store (Link)</option>
            </select>
            @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Dynamic fields --}}
        <div x-show="['url','audio','pdf','app'].includes(type)" class="mb-3">
            <label class="form-label">Put your link here</label>
            <input type="url" class="form-control" name="link" placeholder="https://example.com" value="{{ old('link') }}">
            @error('link') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div x-show="type==='text'" class="mb-3">
            <label class="form-label">Enter Content (Text)</label>
            <textarea class="form-control" name="text" rows="4" placeholder="Your text">{{ old('text') }}</textarea>
            @error('text') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div x-show="type==='wifi'" class="mb-3 row g-3">
            <div class="col-md-4">
                <label class="form-label">SSID</label>
                <input type="text" class="form-control" name="ssid" value="{{ old('ssid') }}">
                @error('ssid') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Encryption</label>
                <select class="form-select" name="encryption" x-on:change="$dispatch('enctype-changed')">
                    <option value="WPA">WPA/WPA2</option>
                    <option value="WEP">WEP</option>
                    <option value="nopass">No Password</option>
                </select>
                @error('encryption') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4" x-data="{ showPwd: true }" x-on:enctype-changed.window="
                showPwd = document.querySelector('[name=encryption]').value !== 'nopass'
            " x-init="showPwd = document.querySelector('[name=encryption]').value !== 'nopass'">
                <label class="form-label">Password</label>
                <input type="text" class="form-control" name="password" :disabled="!showPwd" value="{{ old('password') }}">
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="hidden" value="1" id="hidden">
                    <label class="form-check-label" for="hidden">Hidden SSID</label>
                </div>
            </div>
        </div>

        <div x-show="type==='map'" class="mb-3 row g-3">
            <div class="col-md-6">
                <label class="form-label">Latitude</label>
                <input type="number" step="any" class="form-control" name="lat" value="{{ old('lat') }}">
                @error('lat') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Longitude</label>
                <input type="number" step="any" class="form-control" name="lng" value="{{ old('lng') }}">
                @error('lng') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

        <div x-show="type==='whatsapp'" class="mb-3 row g-3">
            <div class="col-md-6">
                <label class="form-label">Phone (with country code, no +)</label>
                <input type="text" class="form-control" name="phone" placeholder="91XXXXXXXXXX" value="{{ old('phone') }}">
                @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Message (optional)</label>
                <input type="text" class="form-control" name="message" placeholder="Hello! I found you via QR" value="{{ old('message') }}">
                @error('message') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Name / Category (optional) --}}
        <div class="mb-3">
            <label class="form-label">Name your QR (optional)</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="form-label">Content Category (optional)</label>
            <input type="text" class="form-control" name="category" value="{{ old('category') }}">
            @error('category') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Generate QR</button>
    </form>
</div>

{{-- Alpine.js for tiny interactivity --}}
<script src="//unpkg.com/alpinejs" defer></script>

  @endsection