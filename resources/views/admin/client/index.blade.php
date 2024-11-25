@extends('layouts.master')
@section('title')
    Client Management
@endsection
@section('page-title')
    Client Management
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
                                <h6 class="card-title mb-0">Client Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                @if (App\Helpers\FileHelper::usr()->can('clients.create'))
                                    {{-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-create">Import</button> --}}
                                    <a href="{{ route('clients.create') }}" class="btn btn-sm btn-success">Create New</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="admin-dashboard-table">
                            <table class="table table-bordered mb-0 bg-light" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Client Name</th>
                                    <th>Account Holder</th>
                                    <th>Industry</th>
                                    <th>Status</th>
                                    <th>Payroll PIC</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->client_name }}</td>
                                        <td>
                                            @if ($data->employees_id)
                                                {{ $data->Employee->employee_name }}
                                            @endif
                                        </td>
                                        <td>{{ $data->industry_type?->jobcategory_name }}</td>
                                        <td>{{ $data->clients_status == 1 ? 'Active' : 'In-Active' }}</td>

                                        <td>
                                            @if ($data->payroll_employees_id)
                                                {{ $data->Employee_Payroll->employee_name }}
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if ($data->latestFollowUp()?->description)
                                                <u>{{ $data->latestFollowUp()->created_at }}</u><br />
                                                {!! $data->latestFollowUp()->description !!}
                                            @endif
                                        </td> --}}
                                        <td class="d-flex justify-content-center">
                                            {{-- @if (App\Helpers\FileHelper::usr()->can('client.file.upload'))
                                                <a href="{{ route('clients.edit', $data->id) }}#upload_file"
                                                    class="btn btn-secondary btn-sm me-1">Upload File</a>
                                            @endif --}}

                                            @if (App\Helpers\FileHelper::usr()->can('client.followup'))
                                                <a href="{{ route('clients.edit', $data->id) }}#follow_up"
                                                    class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Add Remark"><i class="fas fa-plus"></i>
                                                    <i class="fas fa-registered"></i></a>
                                                <a onclick="getRemark({{ $data->id }})"
                                                    class="btn btn-success btn-sm me-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Show Remarks"><i
                                                        class="fas fa-registered"></i></a>
                                            @endif

                                            @if (App\Helpers\FileHelper::usr()->can('clients.edit'))
                                                <a href="{{ route('clients.edit', $data->id) }}"
                                                    class="btn btn-info btn-sm me-1"><i class="fas fa-pen"></i></a>
                                            @endif

                                            @if (App\Helpers\FileHelper::usr()->can('clients.destroy'))
                                                <form id="deleteForm" action="{{ route('clients.destroy', $data->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this item?')"
                                                        class="btn btn-sm btn-danger"><i class="fas fa fa-trash"></i></a>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                        </div>
                        <div class="mt-3" style="height: 60vh; border: 1px solid black">
                            <div id="clientResume" class="p-3" style="display: none; height: 100%; overflow: auto;">
                                <table class="table table-bordered mb-0 bg-light" id="remarkTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Create By</th>
                                            <th>Description</th>
                                            <th>Create Time</th>
                                            <th>Create Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableContent">
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
                                        <h5 class="modal-title" id="myLargeModalLabel">Import Client</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- {{ route('client.import') }} --}}
                                        <form action="{{ route('client.import') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row mb-4">
                                                        <label for="one" class="col-sm-4 col-form-label">Import
                                                            Candidate</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" name="client_import_file"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                                        class="btn btn-sm btn-secondary me-1">Cancel</a>
                                                        <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    responsive: true
                });
            });

            function getRemark(clientId) {
                $.ajax({
                    type: 'GET',
                    url: '/ATS/get/client/remarks/' + clientId,
                    success: function(response) {
                        let clientResume = document.getElementById('clientResume');

                        if (clientResume.style.display === 'none') {
                            clientResume.style.display = 'block';
                        }

                        // Destroy DataTable if already initialized
                        if ($.fn.DataTable.isDataTable('#remarkTable')) {
                            $('#remarkTable').DataTable().destroy();
                        }

                        // Empty the table content before adding new rows
                        $('#tableContent').empty();

                        let remarkData = response.remarks;

                        for (let i = 0; i < remarkData.length; i++) {
                            let count = 1 + i;
                            let newRowHtml = '<tr>' +
                                '<th scope="row">' + count + '</th>' +
                                '<td>' + remarkData[i].created_by + '</td>' +
                                '<td>' + remarkData[i].description + '</td>' +
                                '<td>' + remarkData[i].create_time + '</td>' +
                                '<td>' + remarkData[i].create_date + '</td>' +
                                '</tr>';

                            $('#tableContent').append(newRowHtml);
                        }

                        // Reinitialize DataTable
                        $('#remarkTable').DataTable({
                            "pageLength": 5
                        });

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        </script>
    @endsection
