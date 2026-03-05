@extends('admin.layout.app')

@section('title', 'Visitor Pre-Approval')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Visitor Pre-Approval Request</h5>
        </div>
        
        @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

        <div class="card-body">
            <form action="{{ route('visitor-preapproval.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                
                
                <div class="mb-3">
                                <label class="form-label">Visitor Name <span class="text-danger">*</span>
</label>
                                <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                <label class="form-label">
                    Phone Number <span class="text-danger">*</span>
                </label>
            
                <input type="text"
                       name="phone"
                       class="form-control"
                       pattern="^[6-9][0-9]{9}$"
                       maxlength="10"
                       inputmode="numeric"
                       placeholder="Enter 10 digit mobile number"
                       required
                       title="Enter valid 10-digit Indian mobile number starting with 6-9">
            </div>


                 
                <div class="mb-3">
                                <label class="form-label">Visitor Photo <span class="text-danger">*</span>
</label>
                                <input type="file" name="image" class="form-control" required>
                 </div>

                <div class="mb-3">
                                <label class="form-label">Purpose of Visit</label>
                                <textarea name="purpose" class="form-control" rows="3" required></textarea>
                 </div>

                {{-- Visit Date --}}
                <div class="mb-3">
                    <label class="form-label">Visit Date <span class="text-danger">*</span></label>
                    <input type="date"
                           name="visit_date"
                           class="form-control"
                           required>
                    @error('visit_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Expected Time --}}
                <div class="mb-3">
                    <label class="form-label">Expected Time <span class="text-danger">*</span></label>
                    <input type="time"
                           name="expected_time"
                           class="form-control"
                           required>
                    @error('expected_time') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                
                
                <div class="text-end mt-4">
                            <a href="{{ route('visitor-preapproval.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success px-4">Save Visitor</button>
                        </div>
            </form>
        </div>
    </div>
</div>
@endsection
