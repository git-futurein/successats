@extends('layouts.master')
@section('title')
    Designation Management
@endsection
@section('page-title')
    Designation Management
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
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6 class="card-title mb-0">Designation Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                <button data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-create"
                                class="btn btn-sm btn-success">Create
                                New</button>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        {{-- Here place table --}}
                        <div class="admin-dashboard-table">
                            <table class="table table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    <th style="padding-right: 30px !important">No.</th>
                                    <th style="padding-right: 120px !important">Designation Code</th>
                                    <th style="padding-right: 120px !important">Description</th>
                                    <th style="padding-right: 30px !important">Status</th>
                                    <th style="padding-right: 30px !important">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->designation_code }}</td>
                                        <td>{{ $data->designation_desc }}</td>
                                        <td>{{ $data->designation_status == '1' ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td class="d-flex">
                                            @if (App\Helpers\FileHelper::usr()->can('designation.update'))
                                            <button data-id="{{ $data->id }}" data-bs-toggle="modal"
                                                data-bs-target=".bs-example-modal-lg-edit"
                                                class="btn btn-sm btn-info edit me-3"><i
                                                    class="fa-solid fa-pen-to-square"></i></button>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('designation.destroy'))
                                            <form action="{{ route('designation.destroy', $data->id) }}" method="POST">
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

                    <!--  Create modal example -->
                    <div class="modal fade bs-example-modal-lg-create" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">Create Designation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ route('designation.store') }}" method="POST">
                                        @csrf
                                        <div class="row p-2">
                                            <div class="col-lg-12">
                                                <div class="row mb-1">
                                                    <label for="one" class="col-sm-4 col-form-label">Designation
                                                        Code</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="designation_code"
                                                            placeholder="Designation Code">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label for="one"
                                                        class="col-sm-4 col-form-label">Description</label>
                                                    <div class="col-sm-8">
                                                        <textarea name="designation_desc" rows="2" class="form-control" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label for="one" class="col-sm-4 col-form-label">List Order</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="designation_seqno"
                                                            placeholder="List Order">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="{{ route('designation.index') }}"
                                                    class="btn btn-sm btn-secondary">Cancel</a>
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
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">Update Designation</h5>
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
                $.get("designation/" + id + "/edit",
                    function(data) {
                        $('#editSection').html(data);
                    })
            });
        </script>
    @endsection
