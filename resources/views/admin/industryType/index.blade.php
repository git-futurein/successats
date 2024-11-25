@extends('layouts.master')
@section('title')
    Industry Type
@endsection
@section('page-title')
    Industry Type
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Industry Type Table</h4>
                        <div class="text-end">
                            @if (App\Helpers\FileHelper::usr()->can('industry-type.create'))
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target=".bs-example-modal-lg-create">Create New</button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.include.errors')

                        <table class="table table-bordered mb-0" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Industry Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->industry_code }}</td>
                                        <td>{{ $data->industry_status == 1 ? 'Active' : 'In-Active' }}</td>
                                        <td style="display: flex;">
                                            @if (App\Helpers\FileHelper::usr()->can('industry-type.update'))
                                            <button type="button" class="btn btn-sm btn-info edit me-2"
                                                data-id="{{ $data->id }}" data-bs-toggle="modal"
                                                data-bs-target=".bs-example-modal-lg-edit">Edit</a>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('industry-type.destroy'))
                                            <form id="deleteForm" action="{{route('industry-type.destroy', $data->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                    class="btn btn-sm btn-danger">Delete</a>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!--  Create modal example -->
                    <div class="modal fade bs-example-modal-lg-create" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tncCreate">Create Industry</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ route('industry-type.store') }}" method="POST">
                                        @csrf
                                        <div class="row p-4">
                                            <div class="col-lg-12 row">
                                                <div class="row mb-4 col-lg-6">
                                                    <label for="one" class="col-sm-4 col-form-label">Industy
                                                        Code</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="industry_code" class="form-control"
                                                            placeholder="Title" value="{{ old('industry_code') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-4 col-lg-6">
                                                    <label for="one" class="col-sm-4 col-form-label">Industry
                                                        Description</label>
                                                    <div class="col-sm-8">
                                                        <textarea name="industry_desc" rows="2" class="form-control" placeholder="Descriptin"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-4 col-lg-6">
                                                    <label for="one" class="col-sm-4 col-form-label">List Order</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="industry_seqno" class="form-control"
                                                            placeholder="List Order" value="{{ old('industry_seqno') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                                    class="btn btn-sm btn-secondary">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!--  Edit modal example -->
                    <div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tncCreate">Update Industry</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="editSection">

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
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
        </script>

        <script>
            //edit modal show and after submit
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id'); //i or 2 categoryid
                $.get(" industry-type/" + id + "/edit",
                    function(data) {
                        $('#editSection').html(data);
                    })
            });
        </script>
    @endsection
