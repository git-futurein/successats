@extends('layouts.master')
@section('title')
Type Of Pass
@endsection
@section('page-title')
Type Of Pass
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
                                <h6 class="card-title mb-0">Type Of Pass Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                <button data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-create"
                        class="btn btn-sm btn-success">Create New</button>
                            </div>
                        </div>
                </div>
                @include('admin.include.errors')
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
                            @foreach ($datas as $data)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$data->passtype_code}}</td>
                                <td>{{$data->passtype_status == 1 ? 'Active' : 'Inactive'}}</td>
                                <td style="display: flex;">

                                    <button data-id="{{ $data->id }}" data-bs-toggle="modal"
                                        data-bs-target=".bs-example-modal-lg-edit"
                                        class="btn btn-sm btn-info edit me-3"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                    <form id="deleteForm" action="{{route('pass-type.destroy', $data->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this item?')"
                                            class="btn btn-sm btn-danger"><i class="fa fa-trash "></i></a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach


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

                    <!--  Create modal example -->
                    <div class="modal fade bs-example-modal-lg-create" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tncCreate">Create Pass Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{ route('pass-type.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row mb-1">
                                                    <label for="one" class="col-sm-4 col-form-label">Pass Type Code</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="passtype_code" class="form-control"
                                                            placeholder="Title" value="{{ old('passtype_code') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label for="one" class="col-sm-4 col-form-label">Pass Type Description</label>
                                                    <div class="col-sm-8">
                                                        <textarea name="passtype_desc" rows="2" class="form-control" placeholder="Descriptin">{{old('passtype_desc')}} </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">

                                                <div class="row mb-1">
                                                    <label for="one" class="col-sm-4 col-form-label">List Order</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="passtype_seqno" class="form-control"
                                                            placeholder="List Order" value="{{ old('passtype_seqno') }}">
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
                <!-- Edit modal content -->
                    <!--  Edit modal example -->
                    <div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tncCreate">Update Pass Type</h5>
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
                $.get("pass-type/" + id + "/edit",
                    function(data) {
                        $('#editSection').html(data);
                    })
            });
        </script>
    @endsection
