@extends('layouts.master')
@section('title')
    Marial Status Management
@endsection
@section('page-title')
    Marial Status Management
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
                            <h6 class="card-title mb-0">Marial Status Table</h6>
                        </div>
                        <div class="p-2 bd-highlight">
                            <button data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-create"
                                class="btn btn-sm btn-success">Create New</button>
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
                                    <th>No.</th>
                                    <th>Marital Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->marital_statuses_code }}</td>
                                        <td>{{ $data->marital_statuses_status == '1' ? 'Active' : 'In-Active' }}</td>
                                        <td class="d-flex">
                                            @if (App\Helpers\FileHelper::usr()->can('marital-status.update'))
                                            <button data-id="{{ $data->id }}" data-bs-toggle="modal"
                                                data-bs-target=".bs-example-modal-lg-edit"
                                                class="btn btn-sm btn-info edit me-3"><i
                                                    class="fa-solid fa-pen-to-square"></i></button>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('marital-status.destroy'))
                                            <form action="{{ route('marital-status.destroy', $data->id) }}" method="POST">
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
                                    <h5 class="modal-title" id="tncCreate">Create Marital Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ route('marital-status.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row mb-1">
                                                    <label for="one" class="col-sm-4 col-form-label">Marital Code</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="marital_statuses_code" class="form-control"
                                                            placeholder="Title" value="{{ old('marital_statuses_code') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label for="one" class="col-sm-4 col-form-label">Marital Description</label>
                                                    <div class="col-sm-8">
                                                        <textarea name="marital_statuses_desc" rows="2" class="form-control" placeholder="Descriptin"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">

                                                <div class="row mb-1">
                                                    <label for="one" class="col-sm-4 col-form-label">List Order</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="marital_statuses_seqno" class="form-control"
                                                            placeholder="List Order" value="{{ old('marital_statuses_seqno') }}">
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
                                    <h5 class="modal-title" id="tncCreate">Update Marital Status</h5>
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
                $.get("marital-status/" + id + "/edit",
                    function(data) {
                        $('#editSection').html(data);
                    })
            });
        </script>
    @endsection
