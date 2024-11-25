@extends('layouts.master')
@section('title')
    TNC Template Management
@endsection
@section('page-title')
    TNC Template Management
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
                                <h6 class="card-title mb-0">TNC Template Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                @if (App\Helpers\FileHelper::usr()->can('tnc.create'))
                                    <button data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-create" class="btn btn-sm btn-success">Create New</button>
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
                                    <th style="padding-right: 60px">No.</th>
                                    <th style="padding-right: 60px">TNC Code</th>
                                    <th style="padding-right: 60px">Default</th>
                                    <th style="padding-right: 60px">Status</th>
                                    <th style="padding-right: 60px">File</th>
                                    <th style="padding-right: 60px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->tnc_template_code }}</td>
                                        <td>{{ $data->tnc_template_isDefault == '1' ? 'Default' : 'None' }}</td>
                                        <td>{{ $data->tnc_template_status == '1' ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            @if ($data->tnc_template_file_path)
                                            <a href="{{ asset('storage') }}/{{ $data->tnc_template_file_path }}"
                                                target="_blank">
                                                <i class="fas fa fa-eye"></i>
                                            </a>
                                            @else
                                            No file attached
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            @if (App\Helpers\FileHelper::usr()->can('tnc.update'))
                                            <button data-id="{{ $data->id }}" data-bs-toggle="modal"
                                                data-bs-target=".bs-example-modal-lg-edit"
                                                class="btn btn-sm btn-info edit me-3"><i
                                                    class="fa-solid fa-pen-to-square"></i></button>
                                            @endif
                                                    @if (App\Helpers\FileHelper::usr()->can('tnc.destroy'))

                                                    <form action="{{ route('tnc.destroy', $data->id) }}" method="POST">
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
                                    <h5 class="modal-title" id="tncCreate">Create TNC Template</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ route('tnc.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row p-3">
                                            <div class="row mb-1 col-lg-6">
                                                <label for="one" class="col-sm-5 col-form-label fw-bold">TNC Code</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="tnc_template_code" class="form-control"
                                                        placeholder="Title" value="{{ old('tnc_template_code') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-1 col-lg-6">
                                                <label for="one" class="col-sm-5 col-form-label fw-bold">List Order</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="tnc_template_seqno" class="form-control"
                                                        placeholder="List Order" value="{{ old('tnc_template_seqno') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-1 col-lg-6">
                                                <label for="one" class="col-sm-5 col-form-label fw-bold">TNC
                                                    Description</label>
                                                <div class="col-sm-7">
                                                    <textarea name="tnc_template_desc" rows="2" class="form-control" placeholder="Description"> {{ old('tnc_template_desc') }} </textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-1 col-lg-6">
                                                <label for="one" class="col-sm-5 col-form-label fw-bold">Upload Template
                                                    File</label>
                                                <div class="col-sm-7">
                                                    <input type="file" name="tnc_template_file_path"
                                                        class="form-control">
                                                    <div class="col-sm-12 text-end">
                                                        <small>**PDF file only </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-lg-12">
                                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-sm btn-secondary">Cancel</button>
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
                                    <h5 class="modal-title" id="tncCreate">Update TNC Template</h5>
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
                $.get("tnc/" + id + "/edit",
                    function(data) {
                        $('#editSection').html(data);
                    })
            });
        </script>
    @endsection
