@extends('admin.layout.app')

@section('title', 'Housekeeping Dashboard')

@section('content')
<main id="main" class="main">

    <div class="container-fluid py-4">
        <h1 class="mb-4">Housekeeping Dashboard</h1>

        <div class="row">

            <!-- Card 1: Assigned Blocks -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Assigned Blocks
                                </p>
                                <h5 class="font-weight-bolder mb-0">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="bi bi-building text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Cleaning Tasks Today -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Cleaning Tasks Today
                                </p>
                                <h5 class="font-weight-bolder mb-0 text-info">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="bi bi-bucket text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Completed Tasks -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Completed Tasks
                                </p>
                                <h5 class="font-weight-bolder mb-0 text-success">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="bi bi-check-circle text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Pending Tasks -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold">
                                    Pending Tasks
                                </p>
                                <h5 class="font-weight-bolder mb-0 text-warning">
                                    0
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="bi bi-exclamation-circle text-lg opacity-10"></i>
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
                            <i class="bi bi-check2-square"></i> Mark Task Completed
                        </a>

                        <a href="#" class="btn btn-outline-primary me-2">
                            <i class="bi bi-list-task"></i> View My Tasks
                        </a>

                        <a href="#" class="btn btn-outline-warning">
                            <i class="bi bi-exclamation-diamond"></i> Report Issue
                        </a>

                    </div>
                </div>
            </div>
        </div>

    </div>

</main>
@endsection
