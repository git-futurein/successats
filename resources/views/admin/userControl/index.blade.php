@extends('layouts.master')
@section('title')
User Control Management
@endsection
@section('page-title')
User Control Management
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
                                    <label for="one" class="col-sm-3 col-form-label">Employee Group</label>
                                    <div class="col-sm-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-2 col-form-label">Module</label>
                                    <div class="col-sm-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">Select One</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-sm btn-success">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>Access</th>
                                            <th>Create</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                            <th>View</th>
                                            <th>Print</th>
                                            <th>Approved</th>
                                            <th>Select All</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Invoice - Modules</td>
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
                                            </td>
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
                                                <input type="checkbox" hid="0" class="parent_check">
                                            </td>
                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="10"><button type="button" class="btn btn-primary">Save</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
