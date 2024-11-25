@extends('layouts.master')
@section('title')
Employee Group
@endsection
@section('page-title')
Employee Group
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Employee Group Table</h4>
                    <div class="text-end">
                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#groupCreate">Create New</a>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Group 1</td>
                                <td>
                                    <span class="btn btn-sm btn-info">Active</span>
                                </td>
                                <td style="display: flex;">
                                    <a href="#" class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#groupEdit">Edit</a>
                                    <form id="deleteForm" action="" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-sm btn-danger">Delete</a>
                                    </form>
                                </td>
                            </tr>


                            {{-- empty data --}}
                            {{-- <tr>
                                <td class="text-center text-warning" colspan="5">
                                    No data found!
                                </td>
                            </tr> --}}
                            {{-- empty data --}}
                        </tbody>
                    </table>
                </div>

                <!-- Create modal content -->
                <div id="groupCreate" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                    data-bs-scroll="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Create Group</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <label for="reason_of_blacklist">Group Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name')}}">

                                    <select name="status" id="" class="form-control mt-4">
                                        <option value="">Active</option>
                                        <option value="">In-Active</option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-info mt-3">Submit</button>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <!-- Edit modal content -->
                <div id="groupEdit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                    data-bs-scroll="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Update Group</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <label for="reason_of_blacklist">Group Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{old('name')}}">

                                    <select name="status" id="" class="form-control mt-4">
                                        <option value="">Active</option>
                                        <option value="">In-Active</option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-info mt-3">Submit</button>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        </div>
    </div>
    @endsection
