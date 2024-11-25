@extends('layouts.master')
@section('title')
    Calendar
@endsection
@section('css')
    <!-- fullcalendar css -->
    <link href="{{ URL::asset('build/libs/fullcalendar/main.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
    Calendar
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="row">
                    @if (isset($managers))
                        @foreach ($managers as $manager)
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-heading{{ $loop->index }}">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapse{{ $loop->index }}"
                                                        aria-expanded="false"
                                                        aria-controls="flush-collapse{{ $loop->index }}">
                                                        Manager: {{ $manager->employee_name }} - Total
                                                        {{ count($candidatesByManager[$manager->id]) }} Resumes
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse{{ $loop->index }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="flush-heading{{ $loop->index }}"
                                                    data-bs-parent="#accordionFlushExample" style="">
                                                    <table class="table table-bordered mb-0" id="myTable">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Candidate Name</th>
                                                                <th>Candidate Email</th>
                                                                <th>Resume</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($candidatesByManager[$manager->id] ?? [] as $candidate)
                                                                <tr>
                                                                    <td>{{ $loop->index + 1 }}</td>
                                                                    <td>{{ $candidate['candidate_name'] }}</td>
                                                                    <td>{{ $candidate['candidate_email'] }}</td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div><!-- end accordion -->
                                    </div><!-- end card-body -->
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if (isset($team_leader))
                        @foreach ($team_leader as $team)

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading{{ $loop->index }}">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse{{ $loop->index }}" aria-expanded="false"
                                                    aria-controls="flush-collapse{{ $loop->index }}">
                                                    Team Leader: {{ $team->employee_name }} - Total
                                                    {{ count($candidatesByTeam[$team->id]) }} Resumes
                                                </button>
                                            </h2>
                                            <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-heading{{ $loop->index }}"
                                                data-bs-parent="#accordionFlushExample" style="">
                                                <table class="table table-bordered mb-0" id="myTable">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Data 1</th>
                                                            <th>Data 2</th>
                                                            <th>Data 3</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($candidatesByTeam[$team->id] ?? [] as $candidate)
                                                            <tr>
                                                                <td>{{ $candidate['candidate_name'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div><!-- end accordion -->
                                </div><!-- end card-body -->
                            </div>
                        </div>
                    @endforeach
                    @endif
                    @if (isset($consultents))

                    @foreach ($consultents as $consultant)

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-heading{{ $loop->index }}">
                                            <button class="accordion-button fw-medium collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapse{{ $loop->index }}" aria-expanded="false"
                                                aria-controls="flush-collapse{{ $loop->index }}">
                                                Consultant: {{ $consultant->employee_name }} - Total
                                                {{ count($candidatesByConsultent[$consultant->id]) }} Resumes
                                            </button>
                                        </h2>
                                        <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse"
                                            aria-labelledby="flush-heading{{ $loop->index }}"
                                            data-bs-parent="#accordionFlushExample" style="">
                                            <table class="table table-bordered mb-0" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Data 1</th>
                                                        <th>Data 2</th>
                                                        <th>Data 3</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($candidatesByConsultent[$consultant->id] ?? [] as $candidate)
                                                        <tr>
                                                            <td>{{ $candidate['candidate_name'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- end accordion -->
                            </div><!-- end card-body -->
                        </div>
                    </div>
                @endforeach
                    @endif
                </div>
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <button class="btn btn-primary w-100" id="btn-new-event"><i class="mdi mdi-plus"></i> Create
                                    New Event</button>

                                <div id="external-events">
                                    <br>
                                    <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                    <div class="external-event fc-event bg-success" data-class="bg-success">
                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>New Event Planning
                                    </div>
                                    <div class="external-event fc-event bg-info" data-class="bg-info">
                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Meeting
                                    </div>
                                    <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Generating Reports
                                    </div>
                                    <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Create New theme
                                    </div>
                                </div>

                                <div class="row justify-content-center mt-5">
                                    <img src="{{ URL::asset('build/images/calendar-img.png') }}" alt=""
                                        class="img-fluid d-block">
                                </div>

                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xl-9">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>

                <div style='clear:both'></div>

                <!-- Add New Event MODAL -->
                <div class="modal fade" id="event-modal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-3 px-4 border-bottom-0">
                                <h5 class="modal-title" id="modal-title">Event</h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>

                            </div>
                            <div class="modal-body p-4">
                                <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Event Name</label>
                                                <input class="form-control" placeholder="Insert Event Name" type="text"
                                                    name="title" id="event-title" required value="" />
                                                <div class="invalid-feedback">Please provide a valid event name</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Category</label>
                                                <select class="form-select shadow-none" name="category" id="event-category"
                                                    required>
                                                    <option value="" selected> --Select-- </option>
                                                    <option value="bg-danger">Danger</option>
                                                    <option value="bg-success">Success</option>
                                                    <option value="bg-primary">Primary</option>
                                                    <option value="bg-info">Info</option>
                                                    <option value="bg-dark">Dark</option>
                                                    <option value="bg-warning">Warning</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a valid event category</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-danger"
                                                id="btn-delete-event">Delete</button>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button type="button" class="btn btn-light me-1"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success"
                                                id="btn-save-event">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end modal-content-->
                    </div> <!-- end modal dialog-->
                </div>
                <!-- end modal-->
            </div>
        </div>
        <!-- end row -->
    @endsection
    @section('scripts')
        <!-- plugin js -->
        <script src="{{ URL::asset('build/libs/fullcalendar/main.min.js') }}"></script>

        <!-- Calendar init -->
        <script src="{{ URL::asset('build/js/pages/calendar.init.js') }}"></script>
        {{-- <script src="{{ URL::asset('build/js/app.js') }}"></script> --}}
    @endsection
