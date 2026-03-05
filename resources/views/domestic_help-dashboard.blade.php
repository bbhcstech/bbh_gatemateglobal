@extends('admin.layout.app')

@section('title', 'Domestic Help Dashboard')

@section('content')
<main id="main" class="main">

    <div class="container-fluid py-4">
        <h1 class="mb-4">Domestic Help Dashboard</h1>

        <div class="row">

            <!-- Card 1: Assigned Flats -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Assigned Flats
                                </p>
                                <h5 class="font-weight-bolder mb-0">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="bi bi-house-check text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Today Check-in -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Today Check-in
                                </p>
                                <h5 class="font-weight-bolder mb-0 text-success">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="bi bi-box-arrow-in-right text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Pending Approval -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Pending Approval
                                </p>
                                <h5 class="font-weight-bolder mb-0 text-warning">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="bi bi-clock-history text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Today Visits -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Visits Today
                                </p>
                                <h5 class="font-weight-bolder mb-0">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="bi bi-person-workspace text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Quick Actions</h5>

                        <a href="#" class="btn btn-outline-success me-2">
                            <i class="bi bi-box-arrow-in-right"></i> Check In
                        </a>

                        <a href="#" class="btn btn-outline-danger me-2">
                            <i class="bi bi-box-arrow-right"></i> Check Out
                        </a>

                        <a href="#" class="btn btn-outline-primary">
                            <i class="bi bi-person-lines-fill"></i> View Assigned Flats
                        </a>

                    </div>
                </div>
            </div>
        </div>

    </div>

</main>
@endsection
