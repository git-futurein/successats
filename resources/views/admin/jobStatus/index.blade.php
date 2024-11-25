@extends('layouts.master')
@section('title')
    Job Status
@endsection
@section('page-title')
    Job Status
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Job Status Table</h4>
                        <div class="text-end">
                            <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                data-bs-target="#statusCreate">Create New</a>
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
                                @foreach ($datas as $data)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->status == 1 ? 'Active' : 'In-Active'}}</td>
                                    <td style="display: flex;">
                                        <a href="#" class="btn btn-sm btn-info me-2 edit" data-bs-toggle="modal"
                                            data-bs-target="#statusEdit" data-id="{{ $data->id }}">Edit</a>
                                        <form id="deleteForm" action="{{route('job-status.destroy', $data->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this item?')"
                                                class="btn btn-sm btn-danger">Delete</a>
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

                    <!-- Create modal content -->
                    <div id="statusCreate" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                        aria-hidden="true" data-bs-scroll="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Create Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('job-status.store') }}" method="POST">
                                        @csrf
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
                    <div id="statusEdit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                        data-bs-scroll="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Update Status</h5>
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
        <script>
            //edit modal show and after submit
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id'); //i or 2 categoryid
                $.get("job-status/" + id + "/edit",
                    function(data) {
                        $('#editSection').html(data);
                    })
            });
        </script>
    @endsection
