@extends('admin.layout.app')

@section('title', 'Security Dashboard')

@section('content')

<style>
    .console-card {
        border: 1px solid #dcdcdc;
        border-radius: 6px;
        background: #ffffff;
        padding: 12px;
        margin-bottom: 12px;
    }

    .summary-box {
        border: 1px solid #e3e3e3;
        border-radius: 6px;
        text-align: center;
        padding: 15px;
        background: #f9f9f9;
    }

    .summary-box h2 {
        margin: 5px 0;
        font-weight: bold;
    }

    .nav-console {
        display: flex;
        gap: 15px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .nav-console a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
    }

    .activity-table th {
        background: #f1f1f1;
    }

    .badge-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
</style>

<style>

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 12px;
}

.action-card {
    background: #f8f9fa;
    border: 1px solid #e3e3e3;
    border-radius: 10px;
    text-align: center;
    padding: 15px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.action-card:hover {
    background: #eef1f5;
    transform: translateY(-3px);
    text-decoration: none;
}

.action-card i {
    font-size: 26px;
    margin-bottom: 6px;
    color: #2c3e50;
}

.action-card span {
    display: block;
    font-size: 14px;
    font-weight: 500;
}

</style>


<main id="main" class="main">

<div class="container-fluid">

    <div class="console-card">

        <!-- TOP NAVIGATION -->
     <div class="card mb-3">
    <div class="card-header">
        <b>Quick Actions</b>
    </div>

    <div class="card-body">

        <div class="quick-actions">

            <a href="{{ route('dashboard') }}" class="action-card">
                <i class="fa fa-home"></i>
                <span>Home</span>
            </a>

            <a href="{{ route('visitors.index') }}" class="action-card">
                <i class="fa fa-users"></i>
                <span>Visitors</span>
            </a>

            <a href="{{ route('vendor-visits.index') }}" class="action-card">
                <i class="fa fa-truck"></i>
                <span>Vendors</span>
            </a>

            <a href="{{ route('domestic-helps.index') }}" class="action-card">
                <i class="fa fa-handshake"></i>
                <span>Domestic Help</span>
            </a>

            <a href="{{ route('vehicles.index') }}" class="action-card">
                <i class="fa fa-car"></i>
                <span>Vehicles</span>
            </a>

           <a href="{{ route('notifications.index') }}" class="action-card">

                <div class="position-relative d-inline-block">
                    <i class="fa fa-bell"></i>
            
                    @if($unreadNotifications > 0)
                        <span class="badge bg-danger position-absolute"
                              style="top:-8px; right:-10px;">
                            {{ $unreadNotifications }}
                        </span>
                    @endif
                </div>
            
                <span>Notifications</span>
            
            </a>



            <a href="{{ url('/profile') }}" class="action-card">
                <i class="fa fa-user"></i>
                <span>Profile</span>
            </a>

        </div>

    </div>
</div>



        <h5 class="mb-3">Security Dashboard – Gate Console</h5>

        <div class="row">

            <!-- LEFT SECTION : VISITORS SUMMARY -->
            <div class="col-md-6">
                <div class="console-card">

                    <div class="d-flex justify-content-between">
                        <b>Today's Visitors</b>
                        <a href="{{ route('visitors.index') }}">View All</a>
                    </div>

                    <div class="row mt-3">

                        <div class="col-6">
                            <div class="summary-box">
                                <h2>{{ $pendingVisitors }}</h2>
                                <small>Pending Approvals</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="summary-box">
                                <h2>{{ $checkedInVisitors }}</h2>
                                <small>Checked-In (Used)</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RIGHT SECTION : PREAPPROVAL SUMMARY -->
            <div class="col-md-6">
                <div class="console-card">

                    <div class="d-flex justify-content-between">
                        <b>Pre-Approved Visitors</b>
                        <a href="{{ route('visitor-preapproval.index') }}">View All</a>
                    </div>

                    <div class="row mt-3">

                        <div class="col-6">
                            <div class="summary-box">
                                <h2>{{ $vendorsScheduled }}</h2>
                                <small>Scheduled Today</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="summary-box">
                                <h2>{{ $vendorsPresent }}</h2>
                                <small>Currently Inside</small>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <!-- ACTIVITY LOG -->
        <div class="console-card mt-3">

            <div class="d-flex justify-content-between">
                <b>Recent Activity Log</b>
                <a href="{{ route('visitor-logs.index') }}">View All</a>
            </div>

            <table class="table table-sm mt-2 activity-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Purpose</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($activityLogs as $log)
                    <tr>
                        <td>{{ $log->name }}</td>
                        <td>{{ $log->purpose ?? 'N/A' }}</td>
                        <td>{{ $log->created_at->format('h:i A') }}</td>
                        <td>
                            @if($log->status == 'inside')
                                <span class="badge bg-success">Inside</span>
                            @elseif($log->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($log->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            No recent activity
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>

    </div>

</div>

</main>

@endsection
