@extends('admin.layout.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="d-flex justify-content-center">
<div class="card shadow" style="max-width:380px;width:100%">
<div class="card-body">

<i class="fas fa-taxi fa-2x text-warning mb-3 text-center d-block"></i>

<ul class="nav nav-pills nav-fill mb-3">
<li class="nav-item">
<a class="nav-link active" data-type="one_time">Once</a>
</li>
<li class="nav-item">
<a class="nav-link" data-type="frequent">Frequently</a>
</li>
</ul>


<form method="POST" action="{{ route('cab.store') }}">
@csrf
<input type="hidden" name="type" id="cabType" value="one_time">

{{-- ONCE --}}
<div id="onceBox">
<label>Allow my cab to enter in next</label>
<select name="expected_time" class="form-control mb-2">
<option value="30">30 Minutes</option>
<option value="60">1 Hour</option>
<option value="120">2 Hours</option>
</select>

<label>Last 4 digits of vehicle no.</label>
<input type="text" name="vehicle_number"
maxlength="4" class="form-control text-center">
</div>

{{-- FREQUENT --}}
<div id="frequentBox" style="display:none">

<label>Select Days of Week</label>
<select name="days_of_week" class="form-control mb-2">
<option value="all">All days of week</option>
<option value="weekdays">Weekdays</option>
<option value="weekends">Weekends</option>
</select>

<label>Select Validity</label>
<select name="validity_months" class="form-control mb-2">
<option value="1">1 Month</option>
<option value="3">3 Months</option>
<option value="6">6 Months</option>
</select>

<label>Select Time Slot</label>
<div class="d-flex gap-2 mb-2">
<input type="time" name="time_from" class="form-control">
<input type="time" name="time_to" class="form-control">
</div>

<label>Entries Per Day</label>
<select name="entries_per_day" class="form-control mb-2">
<option value="1">One Entry</option>
<option value="2">Two Entries</option>
</select>
</div>

{{-- COMPANY --}}
<label>Company Name</label>
<select name="company_name" class="form-control mb-2">
@foreach($companies as $c)
<option value="{{ $c->name }}">{{ $c->name }}</option>
@endforeach
</select>

<!--<input type="text" name="company_name"-->
<!--class="form-control"-->
<!--placeholder="+ Add company name">-->

<button class="btn btn-warning w-100 mt-3 fw-bold">
✓ Allow Entry
</button>

</form>
</div>
</div>
</div>

<script>
document.querySelectorAll('.nav-link').forEach(tab=>{
tab.onclick=()=>{
document.getElementById('cabType').value = tab.dataset.type;
document.getElementById('onceBox').style.display =
tab.dataset.type === 'one_time' ? 'block':'none';
document.getElementById('frequentBox').style.display =
tab.dataset.type === 'frequent' ? 'block':'none';
document.querySelectorAll('.nav-link').forEach(t=>t.classList.remove('active'));
tab.classList.add('active');
};
});
</script>

@endsection

