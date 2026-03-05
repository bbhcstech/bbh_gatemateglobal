@extends('admin.layout.app')

@section('content')

<div class="container-fluid">

    <h4 class="mb-3 text-primary">Visitor Entry / Exit Management</h4>

    {{-- =================== ENTRY FORM =================== --}}

    <div class="card mb-4">
        <div class="card-body">
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            

            <form method="POST" action="{{ route('visitor.entry') }}">
                @csrf

                <div class="row">

                    {{-- Visitor --}}
                    <div class="col-md-4">
                        <select name="visitor_id" id="visitor_select" class="form-control" required>
                            <option value="">Select Visitor</option>

                            @foreach(\App\Models\VisitorPreapproval::where('status','approved')->latest()->get() as $visitor)
                                <option value="{{ $visitor->id }}">
                                    {{ $visitor->name }} ({{ $visitor->phone }})
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Resident --}}
                    <div class="col-md-4">
                        <select name="resident_id" id="resident_select" class="form-control" required>
                            <option value="">Visiting Resident</option>

                            @foreach(\App\Models\User::where('role','resident')->get() as $resident)
                                <option value="{{ $resident->id }}">
                                    {{ $resident->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success">
                            <i class="fas fa-door-open"></i> Mark Entry
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- =================== RECENT VISITORS & SUMMARY =================== --}}

    <div class="row">

        {{-- LEFT SIDE : RECENT VISITOR LIST --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <strong>Recent Visitors</strong>
                </div>

                <div class="card-body p-2">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach(\App\Models\VisitorPreapproval::latest()->take(10)->get() as $v)
                            <tr>
                                <td>
                                <a href="#" 
                                   class="text-primary view-visitor"
                                   data-id="{{ $v->id }}"
                                   data-name="{{ $v->name }}"
                                   data-phone="{{ $v->phone }}"
                                   data-image="{{ $v->image  ?? '' }}">
                                   {{ $v->name }}
                                </a>
                            </td>

                                <td>{{ $v->phone }}</td>
                                <td>{{ $v->visit_date ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $v->status == 'approved' ? 'success' : 'warning' }}">
                                        {{ ucfirst($v->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        {{-- RIGHT SIDE : SUMMARY PANEL --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <strong>Today Summary</strong>
                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-md-4">
                            <div class="border p-2 rounded">
                                <h5>
                                    {{ \App\Models\VisitorLog::whereDate('entry_time', today())->count() }}
                                </h5>
                                <small>Total Entries</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border p-2 rounded">
                                <h5>
                                    {{ \App\Models\VisitorLog::whereNull('exit_time')->count() }}
                                </h5>
                                <small>Currently Inside</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border p-2 rounded">
                                <h5>
                                    {{ \App\Models\VisitorPreapproval::where('status','pending')->count() }}
                                </h5>
                                <small>Pending Approvals</small>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

    <hr>

    {{-- =================== HISTORY TABLE =================== --}}

    <div class="card mt-3">

        <div class="card-header bg-light">
            <strong>Visitor Entry / Exit History</strong>
        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead class="bg-light">
                    <tr>
                        <th>Visitor</th>
                        <th>Resident</th>
                        <th>Entry Time</th>
                        <th>Exit Time</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($logs as $log)

                    <tr>
                        <td>{{ $log->visitor->name ?? '-' }}</td>
                        <td>{{ $log->resident->name ?? '-' }}</td>
                        <td>{{ $log->entry_time }}</td>
                        <td>{{ $log->exit_time ?? '—' }}</td>

                        <td>
                            <span class="badge bg-{{ $log->exit_time ? 'secondary' : 'success' }}">
                                {{ $log->exit_time ? 'Exited' : 'Inside' }}
                            </span>
                        </td>

                        <td>
                            @if(!$log->exit_time)

                            <form method="POST" action="{{ route('visitor.exit', $log->id) }}">
                                @csrf

                                <button class="btn btn-danger btn-sm">
                                    Mark Exit
                                </button>

                            </form>

                            @else
                                —
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No visitor logs found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
<!-- Visitor Profile Modal -->
<div class="modal fade" id="visitorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Visitor Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <img id="visitorImage"
                     src=""
                     class="rounded-circle mb-3"
                     width="100"
                     height="100"
                     style="object-fit:cover">

                <h5 id="visitorName"></h5>
                <p id="visitorPhone"></p>

                <hr>

                <div class="text-start">
                    <p><strong>Entry Time:</strong> <span id="entryTime">-</span></p>
                    <p><strong>Exit Time:</strong> <span id="exitTime">-</span></p>
                    <p><strong>Verified By:</strong> <span id="verifiedBy">-</span></p>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection


@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

    $('#visitor_select').on('change', function(){

        var visitorId = $(this).val();

        if(visitorId)
        {
            $.ajax({
                url: "{{ url('/get-resident-by-visitor') }}/" + visitorId,
                type: "GET",
                dataType: "json",

                success: function(response){

                    if(response.resident_id)
                    {
                        $('#resident_select').val(response.resident_id);
                    }
                    else
                    {
                        alert("Resident not found for this visitor");
                    }
                },

                error: function(xhr){
                    console.log(xhr.responseText);
                    alert("AJAX Error - Check console");
                }
            });
        }
        else
        {
            $('#resident_select').val('');
        }

    });

});
</script>
<script>
$(document).on('click', '.view-visitor', function(e){
    e.preventDefault();

    let visitorId = $(this).data('id');
    let name = $(this).data('name');
    let phone = $(this).data('phone');
    let image = $(this).data('image');

    $('#visitorName').text(name);
    $('#visitorPhone').text(phone);

    if(image){
    $('#visitorImage').attr('src', "{{ asset('') }}/" + image);
} else {
    $('#visitorImage').attr('src', 'https://via.placeholder.com/100');
}


    $.ajax({
        url: "{{ url('/visitor-log-details') }}/" + visitorId,
        type: "GET",
        dataType: "json",

        success: function(response){

            $('#entryTime').text(response.entry_time ?? '-');
            $('#exitTime').text(response.exit_time ?? 'Still Inside');
            $('#verifiedBy').text(response.verified_by ?? '-');

            var myModal = new bootstrap.Modal(document.getElementById('visitorModal'));
            myModal.show();
        },

        error: function(xhr){
            console.log(xhr.responseText);
            alert("AJAX Error - Check console");
        }
    });
});

</script>

@endpush
