@extends('layouts.master')
@section('title')
File Type
@endsection
@section('page-title')
File Type
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">File Type Table</h4>
                    <div class="text-end">
                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#fileTypeCreate">Create New</a>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>PDF</td>
                                <td style="display: flex;">
                                    <a href="#" class="btn btn-sm btn-info me-2" data-bs-toggle="modal"
                                        data-bs-target="#fileTypeEdit">Edit</a>
                                    <form id="deleteForm" action="" method="POST">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this item?')"
                                            class="btn btn-sm btn-danger">Delete</a>
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
                <div id="fileTypeCreate" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                    aria-hidden="true" data-bs-scroll="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Create Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <label for="reason_of_blacklist">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                        value="{{ old('name') }}">
                                    <button type="submit" class="btn btn-sm btn-info mt-3">Submit</button>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <!-- Edit modal content -->
                <div id="fileTypeEdit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                    data-bs-scroll="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Update Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <label for="reason_of_blacklist">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="">
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
