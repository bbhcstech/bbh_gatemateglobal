@extends('admin.layout.app')

@section('title', 'Tenant Dashboard')

@section('content')
<main id="main" class="main">

    <div class="container-fluid py-4">
        <h1 class="mb-4">Tenant Dashboard</h1>

        <div class="row">

            <!-- Rent Status -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Rent Status
                                </p>
                                <h5 class="font-weight-bolder mb-0 text-success">
                                    Paid
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="bi bi-currency-rupee text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Due Amount -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Due Amount
                                </p>
                                <h5 class="font-weight-bolder mb-0 text-danger">
                                    ₹0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                    <i class="bi bi-exclamation-circle text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Complaints -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    My Complaints
                                </p>
                                <h5 class="font-weight-bolder mb-0">
                                    0 Pending
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="bi bi-tools text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visitors -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Today's Visitors
                                </p>
                                <h5 class="font-weight-bolder mb-0">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="bi bi-person-badge text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notices -->
            <div class="col-xl-6 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Latest Notices</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">No new notices available.</p>
                    </div>
                </div>
            </div>

            <!-- Lease Info -->
            <div class="col-xl-6 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Lease Information</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Flat No:</strong> A-101</p>
                        <p class="mb-1"><strong>Lease Ends:</strong> 31 Dec 2026</p>
                        <p class="mb-0"><strong>Owner:</strong> Mr. Sharma</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>
@endsection
