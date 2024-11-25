@extends('layouts.master')
@section('title')
Leave Type Management
@endsection
@section('page-title')
Leave Type Management
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
                            <h6 class="card-title mb-0">Leave Type Table</h6>
                        </div>
                        <div class="p-2 bd-highlight">
                            @if (App\Helpers\FileHelper::usr()->can('leave-type.create'))
                                <button data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-create"
                                    class="btn btn-sm btn-info">Create New</button>
                            @endif
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
                                <th style="padding-right: 120px !important">Leave Type</th>
                                <th style="padding-right: 120px !important">Description</th>
                                <th style="padding-right: 30px !important">Status</th>
                                <th style="padding-right: 30px !important">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->leavetype_code }}</td>
                                    <td>{{ $data->leavetype_desc }}</td>
                                    <td>{{ $data->leavetype_status == 1 ? 'Active' : 'Inactive' }}
                                    </td>
                                    <td class="d-flex">
                                        @if (App\Helpers\FileHelper::usr()->can('leave-type.update'))
                                        <button data-id="{{ $data->id }}" data-bs-toggle="modal"
                                            data-bs-target=".bs-example-modal-lg-edit"
                                            class="btn btn-sm btn-info edit me-3"><i
                                                class="fa-solid fa-pen-to-square"></i></button>
                                        @endif
                                        @if (App\Helpers\FileHelper::usr()->can('leave-type.destroy'))
                                        <form
                                            action="{{ route('leave-type.destroy', $data->id) }}"
                                            method="POST">
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
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">Create Leave Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="{{ route('leave-type.store') }}" method="POST">
                                    @csrf
                                    <div class="row p-2">
                                        <div class="col-lg-6">
                                            <div class="row mb-1">
                                                <label for="one" class="col-sm-4 col-form-label">Leave Type
                                                    Code</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="leavetype_code" class="form-control"
                                                        placeholder="Leave Type Code">
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="one" class="col-sm-4 col-form-label">Default Leave
                                                    Days</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="leavetype_default" class="form-control"
                                                        placeholder="Default Leave Days">
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="one" class="col-sm-4 col-form-label">List Order</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="leavetype_seqno"
                                                        placeholder="List Order">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-1">
                                                <label for="one" class="col-sm-4 col-form-label">Block
                                                    Candidate</label>
                                                <div class="col-sm-8">
                                                    <select name="leavetype_block" id="" class="form-control">
                                                        <option value="">Select One</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="one" class="col-sm-4 col-form-label">Description</label>
                                                <div class="col-sm-8">
                                                    <textarea name="leavetype_desc" rows="2" placeholder="Description"
                                                        class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="{{ route('leave-type.index') }}"
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
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">Update Leave Type</h5>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>

    <script>
        //edit modal show and after submit
        $('body').on('click', '.edit', function () {
            var id = $(this).data('id'); //i or 2 categoryid
            $.get("leave-type/" + id + "/edit",
            function (data) {
                $('#editSection').html(data);
            })
        });
    </script>
    @endsection
