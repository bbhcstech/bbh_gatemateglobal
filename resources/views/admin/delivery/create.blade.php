@extends('admin.layout.app')

@section('content')

<div class="d-flex justify-content-center">
<div class="card shadow" style="max-width:380px;width:100%">
<div class="card-body">

<i class="fas fa-box fa-2x text-warning mb-3 text-center d-block"></i>

<ul class="nav nav-pills nav-fill mb-3">
<li class="nav-item">
<a class="nav-link active" data-type="one_time">Once</a>
</li>
<li class="nav-item">
<a class="nav-link" data-type="frequent">Frequently</a>
</li>
</ul>

<form method="POST" action="{{ route('delivery.store') }}">
@csrf
<input type="hidden" name="type" id="deliveryType" value="one_time">

{{-- SURPRISE --}}
<div class="form-check mb-2">
<input class="form-check-input" type="checkbox" name="surprise_delivery" value="1">
<label class="form-check-label">
Surprise Delivery
</label>
</div>

{{-- ONCE --}}
<div id="onceBox">
<label>Allow delivery to enter in next</label>
<select name="expected_time" class="form-control mb-2">
<option value="30">30 Minutes</option>
<option value="60">1 Hour</option>
<option value="120">2 Hours</option>
</select>
</div>

{{-- FREQUENT --}}
<div id="frequentBox" style="display:none">
<label>Days of Week</label>
<select name="days_of_week" class="form-control mb-2">
<option value="all">All Days</option>
<option value="weekdays">Weekdays</option>
<option value="weekends">Weekends</option>
</select>

<label>Validity</label>
<select name="validity_months" class="form-control mb-2">
<option value="1">1 Month</option>
<option value="3">3 Months</option>
<option value="6">6 Months</option>
</select>

<label>Time Slot</label>
<div class="d-flex gap-2 mb-2">
<input type="time" name="time_from" class="form-control">
<input type="time" name="time_to" class="form-control">
</div>

<label>Entries per day</label>
<select name="entries_per_day" class="form-control mb-2">
<option value="1">One Entry</option>
<option value="2">Two Entries</option>
</select>
</div>

<label>Company Name</label>
<select name="delivery_company_id" class="form-control mb-3">
@foreach($companies as $c)
<option value="{{ $c->id }}">{{ $c->name }}</option>
@endforeach
</select>

<button class="btn btn-warning w-100 fw-bold">
✓ Allow Delivery
</button>

</form>
</div>
</div>
</div>

<script>
document.querySelectorAll('.nav-link').forEach(tab=>{
tab.onclick=()=>{
document.getElementById('deliveryType').value = tab.dataset.type;
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
