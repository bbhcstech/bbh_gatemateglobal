@extends('admin.layout.app')

@section('title','Edit Pet')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm col-md-6 mx-auto">
        <div class="card-body p-4">
            <h4 class="mb-3">Edit Pet</h4>
            

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <form method="POST" action="{{ route('pets.update', $pet->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Resident -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="mb-3">
                    <label class="form-label">Resident</label>
                    <select name="resident_id" class="form-select" required>
                        <option value="">-- Select Resident --</option>
                        @foreach($residents as $resident)
                            <option value="{{ $resident->id }}"
                                {{ old('resident_id', $pet->resident_id) == $resident->id ? 'selected' : '' }}>
                                {{ $resident->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('resident_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                 @endif
               @if(auth()->check() && auth()->user()->role === 'resident')
                 <input type="hidden" name="resident_id"
                       value="{{ Auth::id() }}">
             @endif
                <!-- Type -->
              <div class="mb-3">
    <label class="form-label">
        Type <span class="text-danger">*</span>
    </label>

    <select name="type" class="form-select" required>
        <option value="">-- Select Type --</option>

        @foreach($petsNames as $petType)
            <option value="{{ $petType->name }}"
                {{ old('type', $pet->type) == $petType->name ? 'selected' : '' }}>
                {{ $petType->name }}
            </option>
        @endforeach

    </select>

    @error('type')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $pet->name) }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Age -->
                <div class="mb-3">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control"
                           value="{{ old('age', $pet->age) }}" min="0">
                    @error('age')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Color -->
                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control"
                           value="{{ old('color', $pet->color) }}">
                    @error('color')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="mb-3">
                <label class="form-label">image</label>
                <input type="file" name="image" class="form-control">
                @if($pet->image)
                    <img src="{{ asset($pet->image) }}"
                         width="80"
                         class="mb-2 rounded">
                @endif

            </div>

                <div class="text-end">
                    <button class="btn btn-success rounded-pill px-4">Update</button>
                    <a href="{{ route('pets.index') }}" class="btn btn-secondary rounded-pill px-4">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
