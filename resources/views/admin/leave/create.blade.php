@extends('layouts.master')
@section('title')
    Leave Management
@endsection
@section('page-title')
    Leave Management
@endsection
@section('body')

    <body>
    @endsection
    @section('css')
        <!-- quill css -->
        <link href="{{ URL::asset('build/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-3">
                    <div class="card-header">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6 class="card-title mb-0">Create Leave</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('leave.index') }}" class="btn btn-sm btn-success">Search</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Group</label>
                                        <div class="col-sm-9">
                                            <select name="leave_empl_type" id="leave_empl_type" class="form-control">
                                                <option value="">Select One</option>
                                                <option value="0">Candidate</option>
                                                <option value="1">Employee</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Employee Name</label>
                                        <div class="col-sm-9">
                                            <select name="employees_id" id="employees_id" class="form-control">
                                                <option value="">Select One</option>
                                                {{-- @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}">
                                                            {{ $employee->employee_name }}
                                                        </option>
                                                    @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Type of Leave</label>
                                        <div class="col-sm-9">
                                            <select name="leave_types_id" class="form-control">
                                                <option value="">Select One</option>
                                                @foreach ($leaveType as $type)
                                                    <option value="{{ $type->id }}">
                                                        {{ $type->leavetype_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Leave Duration</label>
                                        <div class="col-sm-9">
                                            <select name="leave_duration" class="form-control">
                                                <option value="Full Day Leave" {{ old('leave_duration') }}>Full
                                                    Day Leave</option>
                                                <option value="Half Day AM" {{ old('leave_duration') }}>Half
                                                    Day
                                                    AM</option>
                                                <option value="Half Day PM" {{ old('leave_duration') }}>Half
                                                    Day
                                                    PM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Date (From)</label>
                                        <div class="col-sm-9">
                                            <input id="dateFrom" type="date" name="leave_datefrom" class="form-control"
                                                placeholder="Date (From)" value="{{ old('leave_datefrom') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Date (To)</label>
                                        <div class="col-sm-9">
                                            <input type="date" id="dateTo" class="form-control" name="leave_dateto"
                                                placeholder="Date (To)" value="{{ old('leave_dateto') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Total Days</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Total Days"
                                                name="leave_total_day" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Upload File</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" placeholder="Upload File"
                                                name="leave_file_path">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 col-lg-6">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label">Remarks</label>
                                        <div class="col-sm-9">
                                            <textarea rows="2" name="leave_reason" class="form-control" placeholder="Remarks"> {{ old('leave_reason') }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="{{ route('leave.index') }}" class="btn btn-sm btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- ckeditor -->
        <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>
        <script>
            function job_link() {
                var copyText = document.getElementById("job_link");

                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);
            }

            $(document).ready(function() {
                let differenceInDays = 0;

                function calculateDifference() {
                    let dateFrom = new Date($('#dateFrom').val());
                    dateFrom.setHours(0, 0, 0, 0);

                    let dateTo = new Date($('#dateTo').val());
                    dateTo.setHours(24, 0, 0, 0);
                    if (!isNaN(dateFrom) && !isNaN(dateTo)) {
                        let differenceInTime = dateTo.getTime() - dateFrom.getTime();
                        let differenceInDays = differenceInTime / (1000 * 3600 * 24);
                        console.log(differenceInDays);

                        $('input[name="leave_total_day"]').val(differenceInDays);
                    }

                }
                $('#dateFrom, #dateTo').change(calculateDifference);
                calculateDifference();
            });
        </script>

        <script>
            $(document).ready(function() {

                // Listen for changes in the candidate dropdown
                $('#leave_empl_type').change(function() {
                    var selectedGroupType = $(this).val();

                    // Check if a group type is selected
                    if (selectedGroupType == 1) {
                        if (selectedGroupType) {
                            $.ajax({
                                type: 'GET',
                                url: '/ATS/leave/get/employee/' + selectedGroupType,
                                success: function(response) {
                                    updateEmployee(response);
                                },
                                error: function(error) {
                                    console.error('Error fetching employee data:', error);
                                    $('#employees_id').empty();
                                    $('#employees_id').append(
                                        '<option value="" disabled selected>No Employee Available</option>'
                                    );
                                }
                            });
                        } else {
                            // If no group type is selected, clear the employees dropdown
                            $('#employees_id').empty();
                            $('#employees_id').append(
                                '<option value="" disabled selected>Select a Group Type first</option>');
                        }
                    } else if (selectedGroupType == 0) {
                        if (selectedGroupType) {
                            $.ajax({
                                type: 'GET',
                                url: '/ATS/leave/get/candidate/' + selectedGroupType,
                                success: function(response) {
                                    updateCandidate(response);
                                },
                                error: function(error) {
                                    console.error('Error fetching candidate data:', error);
                                    $('#candidate_id').empty();
                                    $('#candidate_id').append(
                                        '<option value="" disabled selected>No Candidate Available</option>'
                                    );
                                }
                            });
                        } else {
                            // If no group type is selected, clear the employees dropdown
                            $('#candidate_id').empty();
                            $('#candidate_id').append(
                                '<option value="" disabled selected>Select a Group Type first</option>');
                        }
                    }
                });

                function updateEmployee(response) {
                    $('#employees_id').empty();
                    response.employees.forEach(function(employee) {
                        $('#employees_id').append('<option value="' + employee.id + '">' + employee
                            .employee_name +
                            '</option>');
                    });
                }

                function updateCandidate(response) {
                    $('#employees_id').empty();
                    response.candidates.forEach(function(candidate) {
                        $('#employees_id').append('<option value="' + candidate.id + '">' + candidate
                            .candidate_name +
                            '</option>');
                    });
                }
                $('#leave_empl_type').trigger('change');

            });

            $(document).ready(function() {
                $(document).on('change', '#dateFrom', function() {
                    var value2 = $('#dateFrom').val();
                    $('#dateTo').attr('min', value2);
                    $('#dateTo').prop("disabled", false);
                    $('.end').prop("disabled", false);
                });
            });
        </script>
    @endsection
