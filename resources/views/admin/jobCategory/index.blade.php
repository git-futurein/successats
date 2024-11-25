@extends('layouts.master')
@section('title')
    Job Category
@endsection
@section('page-title')
    Job Category
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
                                <h6 class="card-title mb-0">Job Category Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                @if (App\Helpers\FileHelper::usr()->can('client-term.create'))
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#createJob">Create new</button>
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
                        {{-- <h6>Create Jobs Category</h6> --}}
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <div class="admin-dashboard-table">
                                    <table class="table table-bordered mb-0" id="myTable">
                                    <thead>
                                        <tr>
                                            <th style="padding-right: 20px !important;">No</th>
                                            <th style="padding-right: 20px !important;">Category Name</th>
                                            <th style="padding-right: 20px !important;">Category Parent</th>
                                            <th style="padding-right: 20px !important;">Category Status</th>
                                            <th style="padding-right: 20px !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td>
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td>
                                                    {{ $data->jobcategory_name }}
                                                </td>
                                                <td>
                                                    @if ($data->jobcategory_parent)
                                                        {{ \App\Models\jobcategory::where(['id' => $data->jobcategory_parent])->pluck('jobcategory_name')->first() }}
                                                    @else
                                                        Parent
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $data->jobcategory_status == 1 ? 'Active' : 'In-Active' }}
                                                </td>
                                                <td style="display: flex;">
                                                    @if (App\Helpers\FileHelper::usr()->can('job-category.update'))
                                                        <button data-id="{{ $data->id }}" data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-modal-lg-edit"
                                                            class="btn btn-sm btn-info edit me-3"><i
                                                                class="fa-solid fa-pen-to-square"></i></button>
                                                    @endif
                                                    @if (App\Helpers\FileHelper::usr()->can('job-category.destroy'))
                                                        <form id="deleteForm"
                                                            action="{{ route('job-category.destroy', $data->id) }}"
                                                            method="POST">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  Create modal example -->
        <div class="modal fade" id="createJob" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabell">Create Leave Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('job-category.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Category
                                            Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="jobcategory_name" class="form-control"
                                                placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Category
                                            Parent</label>
                                        <div class="col-sm-9">
                                            <select name="jobcategory_parent" class="form-control">
                                                <option value="">Select One</option>
                                                @foreach ($jobType as $type)
                                                    <option value="{{ $type->id }}">
                                                        {{ $type->jobcategory_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Seq
                                            No</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="jobcategory_seqno"
                                                placeholder="Seq No">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                        class="btn btn-sm btn-secondary me-3">Cancel</a>
                                        <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!--  Edit modal example -->
        <div class="modal fade bs-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Update Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="editSection">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
                $.get("job-category/" + id + "/edit",
                    function(data) {
                        $('#editSection').html(data);
                    })
            });
        </script>
    @endsection
