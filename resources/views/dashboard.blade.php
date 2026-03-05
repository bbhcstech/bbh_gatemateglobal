@extends('admin.layout.app')

@section('title', 'Home Page')

@section('content')

<style>
.status-card {
  border-radius: 18px;
  color: #fff;
  min-height: 190px;
  border: none;
}
.status-card .card-body { padding: 20px; }
.status-card h5 { font-size: 18px; font-weight: 600; }
.status-card h2 { font-size: 42px; font-weight: 700; margin: 15px 0; }
.status-card .top,
.status-card .bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.status-card .icon {
  width: 42px;
  height: 42px;
  background: rgba(255,255,255,0.2);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.status-card .icon.dark { background: rgba(0,0,0,0.2); }
.bg-purple { background: #6f42c1; }
.btn-purple { background-color: #6f42c1; }
.btn-indigo { background-color: #6610f2; }
.card { border-radius: 10px; }
</style>

<main id="main" class="main">

<!-- DASHBOARD STATS -->
<div class="container-fluid py-4">
  <div class="row g-4">

    <div class="col-xl-3 col-sm-6">
  <a href="{{ route('residents.index') }}" class="text-decoration-none">
    <div class="card bg-success">
      <div class="card-body d-flex justify-content-between">
        <div>
          <h6 class="text-white">Residents</h6>
          <h2 class="text-white">{{ $residentsCount }}</h2>
          <span class="badge bg-light text-dark">View All</span>
        </div>
        <i class="fas fa-home fa-2x text-white"></i>
      </div>
    </div>
  </a>
</div>


 <div class="col-xl-3 col-sm-6">
  <a href="{{ route('complaints.index') }}" class="text-decoration-none">
    <div class="card bg-danger">
      <div class="card-body d-flex justify-content-between">
        <div>
          <h6 class="text-white">Complaints</h6>
          <h2 class="text-white">{{ $complaintsCount }}</h2>
          <span class="badge bg-warning text-dark">View All</span>
        </div>
        <i class="fas fa-exclamation-circle fa-2x text-white"></i>
      </div>
    </div>
  </a>
</div>


   <div class="col-xl-3 col-sm-6">
  <a href="{{ route('domestic-helps.index') }}" class="text-decoration-none">
    <div class="card bg-info">
      <div class="card-body d-flex justify-content-between">
        <div>
          <h6 class="text-white">Domestic Helps</h6>
          <h2 class="text-white">{{ $domesticCount }}</h2>
          <span class="badge bg-light text-dark">View All</span>
        </div>
        <i class="fas fa-hands-helping fa-2x text-white"></i>
      </div>
    </div>
  </a>
</div>

<div class="col-xl-3 col-sm-6">
  <a href="{{ route('visitors.index') }}" class="text-decoration-none">
    <div class="card bg-warning">
      <div class="card-body d-flex justify-content-between">
        <div>
          <h6 class="text-white">Visitors</h6>
          <h2 class="text-white">{{ $visitorsCount }}</h2>
          <span class="badge bg-dark">View All</span>
        </div>
        <i class="fas fa-walking fa-2x text-white"></i>
      </div>
    </div>
  </a>
</div>


<div class="col-xl-3 col-sm-6">
  <a href="{{ route('vendor-visits.index') }}" class="text-decoration-none">
    <div class="card bg-secondary">
      <div class="card-body d-flex justify-content-between">
        <div>
          <h6 class="text-white">Vendors</h6>
          <h2 class="text-white">{{ $vendorsCount }}</h2>
          <span class="badge bg-light text-dark">View All</span>
        </div>
        <i class="fas fa-store fa-2x text-white"></i>
      </div>
    </div>
  </a>
</div>


<!-- STATUS CARDS -->
<!--<div class="container-fluid py-4">-->
<!--  <div class="row g-4">-->

<!--    <div class="col-xl-3 col-sm-6">-->
<!--      <div class="status-card bg-danger">-->
<!--        <div class="card-body">-->
<!--          <div class="top">-->
<!--            <h5>Unpaid Invoices</h5>-->
<!--            <i class="fas fa-file-invoice-dollar"></i>-->
<!--          </div>-->
<!--          <h2>0</h2>-->
<!--          <div class="bottom">-->
<!--            <span>View All</span>-->
<!--            <span class="badge bg-warning text-dark">Pending</span>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="col-xl-3 col-sm-6">-->
<!--      <div class="status-card bg-warning">-->
<!--        <div class="card-body">-->
<!--          <div class="top">-->
<!--            <h5>Today's Bookings</h5>-->
<!--            <i class="fas fa-calendar-check"></i>-->
<!--          </div>-->
<!--          <h2>0</h2>-->
<!--          <div class="bottom">-->
<!--            <span>Manage</span>-->
<!--            <span class="badge bg-info">Scheduled</span>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="col-xl-3 col-sm-6">-->
<!--      <div class="status-card bg-purple">-->
<!--        <div class="card-body">-->
<!--          <div class="top">-->
<!--            <h5>Upcoming Events</h5>-->
<!--            <i class="fas fa-calendar-alt"></i>-->
<!--          </div>-->
<!--          <h2>0</h2>-->
<!--          <div class="bottom">-->
<!--            <span>View</span>-->
<!--            <span class="badge bg-success">Scheduled</span>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="col-xl-3 col-sm-6">-->
<!--      <div class="status-card bg-primary">-->
<!--        <div class="card-body">-->
<!--          <div class="top">-->
<!--            <h5>Active Notices</h5>-->
<!--            <i class="fas fa-bullhorn"></i>-->
<!--          </div>-->
<!--          <h2>0</h2>-->
<!--          <div class="bottom">-->
<!--            <span>Manage</span>-->
<!--            <span class="badge bg-light text-dark">Active</span>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--  </div>-->
<!--</div>-->

<!-- ACTIVITY + QUICK ACTIONS -->
<!--<div class="container-fluid">-->
<!--  <div class="row mt-4">-->

<!--    <div class="col-lg-8">-->
<!--      <div class="card mb-4">-->
<!--        <div class="card-header d-flex justify-content-between">-->
<!--          <h6>Recent Activities</h6>-->
<!--          <a href="#" class="btn btn-primary btn-sm">View All</a>-->
<!--        </div>-->
<!--        <div class="card-body text-center text-muted py-4">-->
<!--          No recent activities-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="col-lg-4">-->
<!--      <div class="card mb-4">-->
<!--        <div class="card-header"><h6>Quick Actions</h6></div>-->
<!--        <div class="card-body d-grid gap-2">-->
<!--          <a href="#" class="btn btn-info text-white">Add Resident</a>-->
<!--          <a href="#" class="btn btn-info text-white">Register Visitor</a>-->
<!--          <a href="#" class="btn btn-danger">Create Invoice</a>-->
<!--          <a href="#" class="btn btn-purple text-white">Create Event</a>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--  </div>-->
<!--</div>-->

</main>
@endsection
