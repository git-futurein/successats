@extends('layouts.master')
@section('title')
    Outlet
@endsection
@section('page-title')
    Outlet
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
                                <h6 class="card-title mb-0">Outlet Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('outlets.create') }}" class="btn btn-sm btn-success">Create new</a>
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
                            <table class="table table-bordered mb-0" id="myTable">
                            <thead>
                                <tr>
                                    <th style="padding-right: 20px !important">No</th>
                                    <th style="padding-right: 120px !important">Company Name</th>
                                    <th style="padding-right: 20px !important">Country</th>
                                    <th style="padding-right: 20px !important">Tel No</th>
                                    <th style="padding-right: 220px !important">Website</th>
                                    <th style="padding-right: 80px !important">Description</th>
                                    <th style="padding-right: 20px !important">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->outlet_name }}</td>
                                        <td>{{ $data->nationality->en_country_name }}</td>
                                        <td>{{ $data->outlet_tel }}</td>
                                        <td>{{ $data->outlet_website }}</td>
                                        <td>{{ $data->outlet_description }}</td>
                                        <td style="display: flex;">
                                            {{-- @if (App\Helpers\FileHelper::usr()->can('outlets.edit')) --}}
                                            <a href="{{route('outlets.edit', $data->id)}}" class="btn btn-sm btn-info me-2"><i class="fa fa-pen"></i></a>
                                            {{-- @endif
                                            @if (App\Helpers\FileHelper::usr()->can('outlets.destroy')) --}}
                                            <form id="deleteForm" action="{{ route('outlets.destroy', $data->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </form>
                                            {{-- @endif --}}
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
    @endsection
