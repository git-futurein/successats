@extends('layouts.master')
@section('title')
    Nationality
@endsection
@section('page-title')
    Nationality
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
                        <h4 class="card-title mb-0">Nationality Table</h4>
                        @if (App\Helpers\FileHelper::usr()->can('nationality.create'))
                            <div class="text-end">
                                <button type="submit" class="btn btn-sm btn-success " data-bs-toggle="modal"
                                    data-bs-target=".bs-example-modal-lg-create">Create New</a>
                            </div>
                        @endif
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

                        <table class="table table-bordered mb-0" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nationality Code</th>
                                    {{-- <th>Seq No</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->en_nationality }}</td>
                                        {{-- <td>{{ $data->seq_no }}</td> --}}
                                        <td>{{ $data->country_status == 1 ? 'Active' : 'In-Active' }}</td>
                                        <td style="display: flex;">
                                            @if (App\Helpers\FileHelper::usr()->can('nationality.update'))
                                                <button data-id="{{ $data->id }}" data-bs-toggle="modal"
                                                    data-bs-target=".bs-example-modal-lg-edit"
                                                    class="btn btn-sm btn-info edit me-3"><i
                                                        class="fa-solid fa-pen-to-square"></i></button>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('nationality.destroy'))
                                                <form id="deleteForm" action="{{ route('nationality.destroy', $data->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this item?')"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    {{-- empty data --}}
                                    <tr>
                                        <td class="text-center text-warning" colspan="5">
                                            No data found!
                                        </td>
                                    </tr>
                                    {{-- empty data --}}
                                @endforelse


                            </tbody>
                        </table>
                    </div>

                    <!--  Create modal example -->
                    <div class="modal fade bs-example-modal-lg-create" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">Create Nationality</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('nationality.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Nationality
                                                        Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="nationality_code" class="form-control"
                                                            placeholder="Code">
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Seq No</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="seq_no" class="form-control"
                                                            placeholder="Seq no">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-4">
                                                    <label for="one"
                                                        class="col-sm-3 col-form-label">Description</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="description" rows="4" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal" aria-label="Close">Cancel</button>
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
                                    <h5 class="modal-title" id="myLargeModalLabel">Update Nationality</h5>
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
                $.get("nationality/" + id + "/edit",
                    function(data) {
                        $('#editSection').html(data);
                    })
            });
        </script>
    @endsection
