@extends('admin.layout.app')

@section('title', 'Help Payments')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>{{ isset($helpRating) ? 'Edit Rating' : 'Add Rating' }}</h5>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ isset($helpRating) 
                        ? route('help-ratings.update',$helpRating->rating_id) 
                        : route('help-ratings.store') }}">
            @csrf
            @if(isset($helpRating)) @method('PUT') @endif

            <div class="mb-3">
                <label>Help ID</label>
                <input type="number" name="help_id" class="form-control"
                       value="{{ old('help_id',$helpRating->help_id ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label>Resident ID</label>
                <input type="number" name="resident_id" class="form-control"
                       value="{{ old('resident_id',$helpRating->resident_id ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label>Rating (1–5)</label>
                <input type="number" name="rating" min="1" max="5"
                       class="form-control"
                       value="{{ old('rating',$helpRating->rating ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label>Feedback</label>
                <textarea name="feedback" class="form-control">{{ old('feedback',$helpRating->feedback ?? '') }}</textarea>
            </div>

            <button class="btn btn-success">Save</button>
            <a href="{{ route('help-ratings.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
