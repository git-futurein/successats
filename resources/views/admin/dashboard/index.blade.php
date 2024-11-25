@extends('layouts.master')
@section('title')
Dashboard
@endsection
@section('page-title')
Dashboard
@endsection
@section('body')

<body>
    @endsection
    @section('content')

    <style>
        .fixed-table-container {
            position: fixed;
            bottom: 0;
            width: 78%;
            background-color: #fff;
            border-top: 1px solid #ddd;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            height: 250px;
            overflow:scroll;
        }

        @keyframes slideInFromBottom {
            from {
                transform: translate3d(0, 100%, 0);
            }
            to {
                transform: translate3d(0, 0, 0);
            }
        }

        .modal.bottom .modal-dialog {
            animation: slideInFromBottom 0.8s ease-out;
            transform-origin: 50% 100%;
            height: 400px;
            margin: 0;
        }

        .modal.bottom .modal-content {
            width: 100vw;
            border-radius: 0;
        }
    </style>
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="true"
                                    aria-controls="flush-collapseOne">Manager : Hender Tho - Total 0 Resume
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse" aria-labelledby="flush-headingOne"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body text-muted">

                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Candidates Name</th>
                                                <th>Job Assign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- end accordion -->
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingtwo">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapsetwo" aria-expanded="true"
                                    aria-controls="flush-collapsetwo">Manager : Joanna Bumanlag - Total 42 Resume
                                </button>
                            </h2>
                            <div id="flush-collapsetwo" class="accordion-collapse" aria-labelledby="flush-headingOne"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body text-muted">

                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Candidates Name</th>
                                                <th>Job Assign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- end accordion -->
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingthree">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapsethree" aria-expanded="true"
                                    aria-controls="flush-collapsethree">Manager : Joanna Bumanlag - Total 42 Resume
                                </button>
                            </h2>
                            <div id="flush-collapsethree" class="accordion-collapse" aria-labelledby="flush-headingOne"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body text-muted">

                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Candidates Name</th>
                                                <th>Job Assign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- end accordion -->
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    @endsection
