@extends('layouts.master')
@section('title')
    Leave Management
@endsection
@section('page-title')
    Leave Management
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
                <div class="card p-3">
                    <div class="card-header">
                        <div>
                            <p class="card-title mb-0 text-secondary">Filter</p>
                        </div>
                        <hr>
                        <form action="{{ route('search.leave') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12 col-md-6 row">
                                    <label for="one" class="col-sm-5 col-form-label fw-bold">Filter Date</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="daterange" value="{{ old('daterange', '2023-12-01 - 2024-01-25') }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 row">
                                    <label for="one" class="col-sm-5 col-form-label fw-bold">AR Number</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="ar_number" value="{{ old('ar_number') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-12  d-flex justify-content-center align-items-center">
                                    <button type="submit" class="btn btn-sm btn-success">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card p-3">
                    <div class="card-header">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6 class="card-title mb-0">Leave Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                 @if (App\Helpers\FileHelper::usr()->can('leave.create'))
                                <div class="text-end">
                                    <a href="{{ route('leave.create') }}" class="btn btn-sm btn-success">Create New</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered mb-0" id="leaveTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee Type</th>
                                    <th>Name</th>
                                    <th>Type Of Leave</th>
                                    <th>Remark</th>
                                    <th>Leave Start Date</th>
                                    <th>Leave End Date</th>
                                    <th>Leave Days</th>
                                    <th>Approved/Rejected By </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>@if ($data->leave_empl_type==1) Employee @else Candidate @endif</td>
                                        @if ($data->leave_empl_type==1)
                                        <td>{{ $data->employee?->employee_name }}</td>
                                        @else
                                        <td>{{ $data->candidate?->candidate_name }}</td>
                                        @endif
                                        <td>{{ $data->leaveType?->leavetype_code }}</td>
                                        <td>{{ $data->leave_reason }}</td>
                                        <td>{{ $data->leave_datefrom }}</td>
                                        <td>{{ $data->leave_dateto }}</td>
                                        <td>{{ $data->leave_total_day }}</td>
                                        <td>--</td>
                                        {{-- <td>{{$data->leave_status}}</td> --}}
                                        <td class="text-{{\App\Enums\Status::from($data->leave_status)->message()}}">{{\App\Enums\Status::from($data->leave_status)->title()}}</td>
                                        <td style="display: flex;">
                                            @if (App\Helpers\FileHelper::usr()->can('leave.edit'))
                                            <a href="{{ route('leave.edit', $data->id) }}" class="btn btn-info btn-sm me-3"><i
                                                    class="fas fa-pen"></i></a>
                                            <a href="{{ route('leave.cancle', $data->id) }}" class="btn btn-warning btn-sm me-3">Cancle</a>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('leave.destroy'))
                                            <form action="{{ route('leave.destroy', $data->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this item?')"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                            @endif
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
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#leaveTable').DataTable();
            });

            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    endDate: moment().format('YYYY-MM-DD')
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                });
            });
        </script>
    @endsection
