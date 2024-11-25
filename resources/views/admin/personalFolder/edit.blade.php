@extends('layouts.master')
@section('title')
Personal Folder Management
@endsection
@section('page-title')
Personal Folder Management
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Update Personal Folder</h4>
                </div>
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Title">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-2 col-form-label">Remark</label>
                                    <div class="col-sm-9">
                                        <textarea name="" rows="2" class="form-control" placeholder="Remark"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-4">
                                    <label for="one" class="col-sm-2 col-form-label">Statuse</label>
                                    <div class="col-sm-9">
                                        <select name="" id="" class="form-control">
                                            <option value="">Active</option>
                                            <option value="">In-Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5 mt-2">
                            <div class="col-lg-12">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Candidate</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Remark</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Candidate</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Remark</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="#" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-info">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
