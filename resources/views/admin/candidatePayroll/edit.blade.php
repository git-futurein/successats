@extends('layouts.master')
@section('title')
Payroll Management
@endsection
@section('page-title')
Payroll Management
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Update Payroll</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <div class="row mb-4">
                                <label for="nineteen" class="col-sm-3 col-form-label">Salary Date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="date" class="form-control" placeholder="Salary Date">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="nineteen" class="col-sm-3 col-form-label">Outlet</label>
                                <div class="col-sm-9">
                                    <select name="" id="" class="form-control">
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="nineteen" class="col-sm-3 col-form-label">GIRO No.</label>
                                <div class="col-sm-9">
                                    <select name="" id="" class="form-control">
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="nineteen" class="col-sm-3 col-form-label">Client</label>
                                <div class="col-sm-9">
                                    <select name="" id="" class="form-control">
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="nineteen" class="col-sm-3 col-form-label">AR No.</label>
                                <div class="col-sm-9">
                                    <select name="" id="" class="form-control">
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="nineteen" class="col-sm-3 col-form-label">Candidate</label>
                                <div class="col-sm-9">
                                    <select name="" id="" class="form-control">
                                        <option value="">Select One</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="nineteen" class="col-sm-3 col-form-label">Payslip Period (Start
                                    Date)</label>
                                <div class="col-sm-9">
                                    <input type="date" name="date" class="form-control"
                                        placeholder="Payslip Period (Start Date)">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="nineteen" class="col-sm-3 col-form-label">Payslip Period (End
                                    Date)</label>
                                <div class="col-sm-9">
                                    <input type="date" name="date" class="form-control"
                                        placeholder="Payslip Period (End Date)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="overflow-x:scroll;">
                        <table id="detail_table" class="table transaction-detail">
                            <thead>
                                <tr>
                                    <th style="min-width:50px;padding-left:5px">No</th>
                                    <th style="min-width:200px;">Employee Name</th>
                                    <th style="min-width:150px;text-align:center;">Total Day</th>
                                    <th style="min-width:200px;text-align:center;">Job Type</th>
                                    <th style="min-width:150px;text-align:right">Basic Salary</th>
                                    <th style="min-width:150px;text-align:right">Salary</th>
                                    <th style="min-width:150px;text-align:right">OT (1.5X)</th>
                                    <th style="min-width:150px;text-align:right">OT (2X)</th>
                                    <th style="min-width:150px;text-align:right">Allowance</th>
                                    <th style="min-width:150px;text-align:right">Reimbursement</th>
                                    <th style="min-width:150px;text-align:right">Late Deduction</th>
                                    <th style="min-width:150px;text-align:right">Unpaid Leave</th>
                                    <th style="min-width:150px;text-align:right">Additional</th>
                                    <th style="min-width:150px;text-align:right">Deductions</th>
                                    <th style="min-width:150px;text-align:right">Employee CPF</th>
                                    <th style="min-width:150px;text-align:right">Employer CPF</th>
                                    <th style="min-width:150px;text-align:right">Total</th>
                                    <th style="min-width:100px;text-align:right"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="payslipslisting">
                                    <td colspan="20" class="text-center"> No Record Found.</td>
                                </tr>
                                <tr id="detail_last_tr"></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <a href="" class="btn btn-secondary btn-sm">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
