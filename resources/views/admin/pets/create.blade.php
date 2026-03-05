@extends('admin.layout.app')

@section('title','Add Pet')

@section('content')
<div class="container">

<div class="card shadow col-md-6 mx-auto">
    <div class="card-body p-4">
        <h5 class="mb-3">Add Pet</h5>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Resident --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="mb-3">
                <label class="form-label">Resident</label>
                <select name="resident_id" class="form-select" required>
                    <option value="">-- Select Resident --</option>
                    @foreach($residents as $resident)
                        <option value="{{ $resident->id }}">
                            {{ $resident->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
             @endif
               @if(auth()->check() && auth()->user()->role === 'resident')
             <input type="hidden" name="resident_id"
                       value="{{ Auth::id() }}">
             @endif
            {{-- Pet Type --}}
            <div class="mb-3">
            <label class="form-label">
                Pet Type <span class="text-danger">*</span>
            </label>
        
            <select name="type" class="form-select" required>
                <option value="">-- Select --</option>
        
                @foreach($petsNames as $petType)
                    <option value="{{ $petType->name }}"
                        {{ old('type', $pet->type ?? '') == $petType->name ? 'selected' : '' }}>
                        {{ $petType->name }}
                    </option>
                @endforeach
            </select>
        </div>


            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label">Pet Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            {{-- Age --}}
            <div class="mb-3">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control">
            </div>

            {{-- Color --}}
            <div class="mb-3">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Pet Image</label>
                <input type="file" name="image" class="form-control"
                       accept="image/*">
            </div>


            <div class="text-end">
                <button class="btn btn-success px-4 rounded-pill">
                    Save
                </button>
            </div>

        </form>
    </div>
</div>

</div>
@endsection
