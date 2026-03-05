@extends('admin.layout.app')

@section('title','Family Member')

@section('content')
<div class="main-content position-relative max-height-vh-100 h-100">

    <div class="container-fluid py-4">

        <div class="card shadow-lg col-md-6 mx-auto">
            <div class="card-body p-4">
      <h4 class="mb-3">{{ isset($familyMember) ? 'Edit' : 'Add' }} Family Member</h4>


      @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

      <form method="POST"
        action="{{ isset($familyMember) ? route('family-members.update',$familyMember) : route('family-members.store') }}">
        @csrf
        @isset($familyMember) @method('PUT') @endisset

         {{-- Resident Selection --}}
            @if(auth()->user()->role === 'admin')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Resident</label>
                    <select name="resident_id" class="form-select" required>
                        <option value="">-- Select Resident --</option>
                        @foreach($residents as $resident)
                            <option value="{{ $resident->id }}"
                                {{ old('resident_id', $familyMember->resident_id ?? '') == $resident->id ? 'selected' : '' }}>
                                {{ $resident->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('resident_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            @else
                {{-- Auto select resident for logged-in resident --}}
                <input type="hidden" name="resident_id"
                       value="{{ Auth::id() }}">
            @endif

        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control"
            value="{{ old('name',$familyMember->name ?? '') }}" required>
        </div>
    
            <div class="mb-3">
        <label class="form-label fw-semibold">Relation</label>
        <select name="relation_id" class="form-select" required>
            <option value="">-- Select Relation --</option>
    
            @foreach($relations as $relation)
                <option value="{{ $relation->id }}"
                    {{ old('relation_id', $familyMember->relation_id ?? '') == $relation->id ? 'selected' : '' }}>
                    {{ $relation->name }}
                </option>
            @endforeach
        </select>
    
        @error('relation_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>



        <div class="mb-3">
          <label class="form-label">Mobile</label>
          <input type="text" name="mobile" class="form-control"
            value="{{ old('mobile',$familyMember->mobile ?? '') }}">
        </div>

        <div class="text-end">
          <button class="btn btn-success rounded-pill px-4">Save</button>
        </div>

      </form>
       </div>
        </div>

    </div>
</div>
@endsection
