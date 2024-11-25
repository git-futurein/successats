@extends('layouts.master')
@section('title')
Tax Invoice Management
@endsection
@section('page-title')
Tax Invoice Management
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Create New Invoice</h4>
                    <div class="text-end">
                        <a href="" class="btn btn-sm btn-info">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Invoice No</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Invoice No">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Invoice Type</label>
                                    <div class="col-sm-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">AR Number</label>
                                    <div class="col-sm-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Attention Person</label>
                                    <div class="col-sm-9">
                                        <textarea rows="2" class="form-control" placeholder="Attention Person"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Postal Code</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Postal Code">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                        <textarea rows="2" class="form-control" placeholder="Address" readonly></textarea>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">GST Charge %</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="%" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Outlet</label>
                                    <div class="col-sm-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" placeholder="Date" >
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Terms</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Terms" >
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">GST REG NO</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="GST REG NO" >
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Unit No</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Unit No" >
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-3 col-form-label">Remarks</label>
                                    <div class="col-sm-9">
                                        <textarea  rows="2" class="form-control" placeholder="Remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-sm btn-info">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
