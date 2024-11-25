@extends('layouts.master')
@section('title')
    Attendence Management
@endsection
@section('page-title')
    Attendence Management
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                @if($errors->any())
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                          <strong>{{$errors->first()}}</strong>
                        </div>
                    </div>
                @endif
                <div class="card p-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Filter </h4>
                        <hr>
                        <form method="GET" action="{{ route('attendence.index') }}" id="attendanceFilter">
                            @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-6 row mb-3">
                                <label for="three" class="col-sm-12 col-md-4 col-form-label"> Start Date</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{$start}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 row">
                                <label for="three" class="col-sm-12 col-md-4 col-form-label">End Date</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{$end}}">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="card p-3">
                    <div class="card-header">
                        <h4 class="card-title mb-2">Attendence Table</h4>
                        {{-- <div class="text-end">
                            <a href="{{ route('candidate.create') }}" class="btn btn-sm btn-success">Create New</a>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered mb-0" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Client</th>
                                    <th>Attendence Month</th>
                                    <th>Approved Date & Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->candidate?->candidate_name }}</td>
                                        <td>{{ $data->client?->client_name }}</td>
                                        <td>
                                            {{ Carbon\Carbon::parse($data->month_year)->format('M, Y') }}
                                        </td>
                                        <td>{{ $data->updated_at }}</td>
                                        <td style="display: flex;">
                                            <a href="{{ route('attendence.edit', $data->id) }}"
                                                class="btn btn-info btn-sm me-2"><i class="fas fa-pen"></i></a>
                                            <a href="#"
                                                class="btn btn-danger btn-sm me-2">Resubmit</a>
                                            <a href="{{ route('attendence.print', $data->id) }}"
                                                class="btn btn-warning btn-sm me-2">Print</a>
                                            <a disable href="#"
                                                class="btn btn-success btn-sm me-2">Download Attachments</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            });

            $(document).ready(function () {
                $('#start_date, #end_date').on('change', function () {
                    var startDateValue = $('#start_date').val();
                    var endDateValue = $('#end_date').val();

                    var newUrl = "{{ route('attendence.index') }}?start_date=" + startDateValue + "&end_date=" + endDateValue;
                    window.location.href = newUrl;
                });
            });
        </script>
    @endsection
