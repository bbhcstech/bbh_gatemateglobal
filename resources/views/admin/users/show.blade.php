<style>
    .cursor-pointer {
    cursor: pointer;
}
</style>@extends('admin.layout.app')

@section('title', 'View User')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>User Details</h5>

        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
            ← Back to List
        </a>
    </div>

    <div class="card-body">

        <div class="row">

            <!-- PROFILE IMAGE -->
            <div class="col-md-3 text-center mb-3">
                @if($user->profilePicture && $user->profilePicture->file_path)
                    <img src="{{ asset($user->profilePicture->file_path) }}"
                         class="img-thumbnail"
                         style="width:180px;height:180px;object-fit:cover">
                @else
                    <img src="{{ asset('default-user.png') }}"
                         class="img-thumbnail"
                         style="width:180px;height:180px;">
                @endif
            </div>

            <!-- USER INFO -->
            <div class="col-md-9">

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>

                    <tr>
                        <th>Mobile No</th>
                        <td>{{ $user->mobile }}</td>
                    </tr>

                    <tr>
                        <th>WhatsApp No</th>
                        <td>{{ $user->whatsapp_no ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Role</th>
                        <td class="text-capitalize">
                           {{ optional($user->roleMaster)->name ?? 'N/A' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            @if($user->approval_status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($user->approval_status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Account Active</th>
                        <td>
                            <span class="badge bg-{{ $user->is_active === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($user->is_active) }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>OTP Verified</th>
                        <td>
                            @if($user->otp_verified)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Tower</th>
                        <td>{{ optional($user->tower)->name ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Floor</th>
                        <td>{{ optional($user->floor)->floor_no ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Flat</th>
                        <td>{{ optional($user->flat)->flat_no ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Parking Slot</th>
                        <td>{{ optional($user->parking)->slot_no ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Documents</th>
                        <td>
                           @if($user->document && $user->document->file_path)
                    
                        {{-- Image preview if image --}}
                        @php
                            $ext = pathinfo($user->document->file_path, PATHINFO_EXTENSION);
                        @endphp
                    
                        @if(in_array(strtolower($ext), ['jpg','jpeg','png','webp']))
                            <img src="{{ asset($user->document->file_path) }}"
                                 width="120"
                                 class="img-thumbnail cursor-pointer"
                                 onclick="previewImage('{{ asset($user->document->file_path) }}')">
                        @endif
                    
                        <a href="{{ asset($user->document->file_path) }}"
                           target="_blank"
                           class="text-primary mt-1 d-block small">
                            View Uploaded Document
                        </a>
                    
                    @else
                        <span class="badge bg-secondary">N/A</span>
                    @endif
                        </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>
</div>


<!-- IMAGE PREVIEW MODAL -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImg" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
function previewImage(src) {
    document.getElementById('previewImg').src = src;
    new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
}
</script>
@endpush
