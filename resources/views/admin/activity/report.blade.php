@extends('layouts.master')
@section('title')
Activity Report
@endsection
@section('page-title')
Activity Report
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">User</label>
                                    <div class="col-sm-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-2 col-form-label">Date Range</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3 text-center">
                                <button type="submit" class="btn btn-info btn-sm">Search</button>
                                <a href="#" class="btn btn-info btn-sm"> <i class="fa-solid fa-print"></i> Print</a>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="text-center">Activity Report</h1>
                            <form action="">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Action</th>
                                            <th>Remarks</th>
                                            <th>Insert By</th>
                                            <th>Insert Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            {{-- <td>Invoice - Modules</td>
                                            <td>
                                                <input type="checkbox" name="check[0][]">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="check[0][]">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="check[0][]">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="check[0][]">
                                            </td> --}}
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
