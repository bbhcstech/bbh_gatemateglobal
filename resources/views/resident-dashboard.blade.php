@extends('admin.layout.app')

@section('title', 'Resident Dashboard')

@section('content')

<style>
.dashboard-card {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 10px;
    background: #fff;
    margin-bottom: 12px;
}

.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-icons i {
    font-size: 18px;
    margin-left: 12px;
    cursor: pointer;
}

.quick-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 10px;
}

.quick-btn {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 12px;
    text-align: center;
    background: #f8f9fa;
    transition: .3s;
}

.quick-btn:hover {
    background: #e9ecef;
}

.quick-btn i {
    font-size: 24px;
    margin-bottom: 6px;
}

.bottom-nav {
    display: flex;
    justify-content: space-around;
    padding: 10px;
    background: #f1f1f1;
    border-radius: 10px;
}

</style>

@php
$unreadNotifications = \App\Models\Notification::where('resident_id', auth()->id())
                       ->where('audience', 'resident')
                        ->where('is_read', 0)
                        ->count();
@endphp

<main class="main container-fluid py-3">

<!-- HEADER -->
<div class="dashboard-card">
    <div class="header-bar">

        <div>
            <h5>Society Name: {{ auth()->user()->society_name ?? 'My Society' }}</h5>
        </div>

        <div class="header-icons">
            <i class="fa fa-search"></i>

            <a href="{{ route('notifications.index') }}">
                <i class="fa fa-bell"></i>
                @if($unreadNotifications > 0)
                    <span class="badge bg-danger">
                        {{ $unreadNotifications }}
                    </span>
                @endif
            </a>

            <a href="{{ url('/profile') }}">
                <i class="fa fa-user"></i>
            </a>
        </div>

    </div>
    
    
    <!-- RESIDENT DETAILS -->
<div class="dashboard-box">
    <div class="section-title">My Details</div>

    <div class="row align-items-center">

        <div class="col-md-2 text-center">
            @if($user->profile_pic)
                <img src="{{ asset($user->profile_pic) }}"
                     class="rounded-circle border"
                     width="90" height="90"
                     style="object-fit:cover">
            @else
                <img src="{{ asset('default-user.png') }}"
                     class="rounded-circle border"
                     width="90" height="90">
            @endif
        </div>

        <div class="col-md-10">

            <table class="table table-sm table-bordered">

                <tr>
                    <th width="150">Name</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>Mobile</th>
                    <td>{{ $user->mobile }}</td>
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
                    <th>Parking</th>
                    <td>{{ optional($user->parking)->parking_no ?? 'N/A' }}</td>
                </tr>

            </table>

        </div>
    </div>
</div>
</div>


<!-- QUICK ACTIONS -->
<div class="dashboard-card">

<h6 class="fw-bold">Quick Actions</h6>

<div class="quick-grid">

    <a href="{{ route('visitor-preapproval.index') }}" class="quick-btn text-decoration-none text-dark">
        <i class="fa fa-user-check"></i>
        <div>Pre-Approve</div>
    </a>

    <a href="#" class="quick-btn text-decoration-none text-dark">
        <i class="fa fa-credit-card"></i>
        <div>Payments</div>
    </a>

    <a href="{{ route('complaints.index') }}" class="quick-btn text-decoration-none text-dark">
        <i class="fa fa-headset"></i>
        <div>Helpdesk</div>
    </a>

    <a href="#" class="quick-btn text-decoration-none text-dark">
        <i class="fa fa-building"></i>
        <div>Amenities</div>
    </a>

    <a href="#" class="quick-btn text-decoration-none text-dark">
        <i class="fa fa-clipboard-check"></i>
        <div>Claim Facility</div>
    </a>

    <a href="#" class="quick-btn text-decoration-none text-dark">
        <i class="fa fa-comments"></i>
        <div>Posts</div>
    </a>

    <a href="#" class="quick-btn text-decoration-none text-dark">
        <i class="fa fa-shield"></i>
        <div>Security</div>
    </a>

    <a href="#" class="quick-btn text-decoration-none text-dark">
        <i class="fa fa-ellipsis-h"></i>
        <div>View More</div>
    </a>

</div>

</div>


<!-- VISITOR SUMMARY -->
<div class="dashboard-card">

<h6 class="fw-bold">Visitor Summary</h6>

<p>
You have <b>{{ $todayVisitors ?? 0 }}</b> Visitors Today
</p>

</div>


<!-- VISITOR UPDATES -->
<div class="dashboard-card">

<h6 class="fw-bold">Visitor Updates</h6>

<table class="table table-sm">
    @forelse($recentVisitors ?? [] as $visitor)
        <tr>
            <td>
                Resident Visitor – {{ $visitor->name }}
            </td>
        </tr>
    @empty
        <tr>
            <td>No recent visitors</td>
        </tr>
    @endforelse
</table>

</div>


<!-- BOTTOM NAVIGATION -->
<div class="dashboard-card">

<div class="bottom-nav">

    <a href="#" class="text-decoration-none text-dark">
        <i class="fa fa-users"></i><br>
        Social
    </a>

    <a href="#" class="text-decoration-none text-dark">
        <i class="fa fa-store"></i><br>
        Marketplace
    </a>

    <a href="#" class="text-decoration-none text-dark">
        <i class="fa fa-comments"></i><br>
        Community
    </a>

    <a href="#" class="text-decoration-none text-dark">
        <i class="fa fa-cogs"></i><br>
        Services
    </a>

    <a href="#" class="text-decoration-none text-dark">
        <i class="fa fa-microchip"></i><br>
        Devices
    </a>

</div>

</div>

</main>

@endsection
