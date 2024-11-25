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
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6 class="card-title mb-0">Nationality</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                @if (App\Helpers\FileHelper::usr()->can('nationality.create'))
                                    <button type="submit" class="btn btn-sm btn-success " data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-create">Create New</a>
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

                        <div class="admin-dashboard-table">
                            <table class="table table-bordered mb-0" id="nationalityDataTable">
                            <thead>
                                <tr>
                                    <th style="padding-right: 20px !important">No</th>
                                    <th style="padding-right: 100px !important">Name</th>
                                    <th style="padding-right: 100px !important">Nationality</th>
                                    <th style="padding-right: 10px !important">Alpha_2_Code</th>
                                    <th style="padding-right: 10px !important">Alpha_3_Code</th>
                                    <th style="padding-right: 10px !important">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->en_country_name }}</td>
                                        <td>{{ $data->en_nationality }}</td>
                                        <td>{{ $data->alpha_2_code }}</td>
                                        <td>{{ $data->alpha_3_code }}</td>
                                        <td style="display: flex;">
                                            @if (App\Helpers\FileHelper::usr()->can('nationality.update'))
                                                <button data-bs-toggle="modal"
                                                    data-bs-target=".bs-example-modal-lg-edit-{{$data->id}}"
                                                    class="btn btn-sm btn-info edit me-3"><i
                                                        class="fa-solid fa-pen-to-square"></i></button>
                                            @endif
                                            {{-- @if (App\Helpers\FileHelper::usr()->can('nationality.destroy'))
                                                <form id="deleteForm" action="{{ route('nationality.destroy', $data->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this item?')"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                </form>
                                            @endif --}}
                                        </td>
                                    </tr>
                                    @include('admin.country.edit')
                                @endforeach


                            </tbody>
                        </table>
                        </div>
                    </div>

                    <!--  Create modal example -->
                    <div class="modal fade bs-example-modal-lg-create" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content p-4">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myLargeModalLabel">Create Nationality</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('countries.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="en_country_name" class="form-control"
                                                            placeholder="Country Name" value="{{ old('en_country_name') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Nationality
                                                        Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="country_code" class="form-control"
                                                            placeholder="Nationality code" value="{{ old('country_code') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Nationality</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="en_nationality" class="form-control"
                                                            placeholder="Nationality" value="{{ old('en_nationality') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Alpha 2 Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="alpha_2_code" class="form-control"
                                                            placeholder="alpha 2 code" value="{{ old('alpha_2_code') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Alpha 3 Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="alpha_3_code" class="form-control"
                                                            placeholder="alpha 3 code" value="{{ old('alpha_3_code') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-info">Create</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  Edit modal example -->
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
                $('#nationalityDataTable').DataTable();
            });
        </script>

        {{-- <script>
            //edit modal show and after submit
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id'); //i or 2 categoryid
                $.get("/ATS/countries/" + id + "/edit",
                    function(data) {
                        console.log(data);
                        $('#editSection').html(data);
                    })
            });
        </script> --}}
    @endsection
