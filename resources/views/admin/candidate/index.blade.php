@extends('layouts.master')
@section('title')
    Candidate Management
@endsection
@section('page-title')
    Candidate Management
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
                                <h6 class="card-title mb-0">Candidate Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                @if (App\Helpers\FileHelper::usr()->can('candidate.create'))
                                    <a href="{{ route('candidate.create') }}" class="btn btn-sm btn-success">Create New</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="admin-dashboard-table">
                            <table class="table table-bordered mb-0" id="myTable">
                            <thead>
                                <tr>
                                    <th style="padding-right: 20px !important">No</th>
                                    <th style="padding-right: 20px !important">ID</th>
                                    <th style="padding-right: 20px !important">Name</th>
                                    <th style="padding-right: 20px !important">Email</th>
                                    <th style="padding-right: 20px !important">Mobile</th>
                                    <th style="padding-right: 20px !important">Last Update Date</th>
                                    <th style="padding-right: 20px !important">Assign</th>
                                    <th style="padding-right: 20px !important">Group</th>
                                    <th style="padding-right: 20px !important">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>{{ $data->id }}</td>
                                        <td  onclick="getRemark({{ $data->id }})">{{ $data->candidate_name }}</td>
                                        <td  onclick="getRemark({{ $data->id }})">{{ $data->candidate_email }}</td>
                                        <td>{{ $data->candidate_mobile }}</td>
                                        <td>{{ $data->updated_at }}</td>
                                        <td>
                                            @if($data->manager_id == null)
                                                <a href="#" class="btn btn-success bg-info btn-sm me-3">Unassigned</a>
                                            @else
                                                <a href="{{ route('candidate.edit', $data->id) }}#remark" class="btn btn-success btn-sm me-3">Assigned</a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ candidate_group($data->id) }}
                                        </td>
                                        {{-- <td class="text-{{ \App\Enums\Status::from($data->candidate_status)->message() }}">
                                            {{ \App\Enums\Status::from($data->candidate_status)->title() }}
                                        </td> --}}
                                        <td class="d-flex justify-content-end">
                                            @if($data->getMainResumeFilePath() != null)
                                            <button type="button"
                                                class="btn btn-info btn-sm me-1 resumePath"
                                                data-bs-toggle="modal"
                                                data-bs-target="#showResume"
                                                data-file-path="{{ $data->getMainResumeFilePath() }}">D</button>
                                            <a target="__blank" href="{{ asset('storage') }}/{{ $data->getMainResumeFilePath() }}" class="btn btn-info btn-sm me-1"><i class="fas fa-download"></i></a></a>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('candidate.remark'))
                                                <a href="{{ route('candidate.edit', $data->id) }}#remark"
                                                    class="btn btn-warning btn-sm me-1 d-flex justify-content-start" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Add Remark"><i class="fas fa-plus mt-1 me-1"></i> R</a>
                                                <a onclick="getRemark({{ $data->id }})" class="btn btn-success btn-sm me-1">R</a>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('candidate.update'))
                                                <a href="{{ route('candidate.edit', $data->id) }}"
                                                    class="btn btn-info btn-sm me-1" title="Edit"><i
                                                        class="fas fa-pen"></i></a>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('candidate.destroy'))
                                                <form id="deleteForm" action="{{ route('candidate.destroy', $data->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="NOT SUITABLE"
                                                        onclick="return confirm('By selecting “NOT SUITABLE”, candidate will be deleted. Do you want to proceed?')"
                                                        class="btn btn-sm btn-danger"> <i class="fas fa fa-x"></i> </a>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>

                        <div class="mt-3" style="height: 60vh; border: 1px solid black">
                            <div id="candidateResume" class="p-3" style="display: none; height: 100%; overflow: auto;">
                                <table id="candidateRemarkTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>Count</th>
                                            <th>Assign To</th>
                                            <th>Client</th>
                                            <th>Remarks Type</th>
                                            <th>Remarks</th>
                                            <th>Created By</th>
                                            <th>Create Time</th>
                                            <th>Create Date</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.candidate.inc.resume__modal')
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

                $('.resumePath').on('click', function() {
                    let filePath = $(this).data('file-path');
                    const iframe = document.getElementById('pdfViewer');
                    let publicUrl = "{{ asset(Storage::url('')) }}" + "/" + filePath;
                    iframe.src = publicUrl;
                    iframe.width = "100%";
                    iframe.height = "600px";
                });
            });

            function getRemark(candidateId) {
                $.ajax({
                    type: 'GET',
                    url: '/ATS/get/candidate/remarks/' + candidateId,
                    success: function(response) {
                        let remarkData = response.remarks;
                        let candidateResume = document.getElementById('candidateResume');

                        if (candidateResume.style.display === 'none') {
                            candidateResume.style.display = 'block';
                        }
                        // Destroy DataTable if already initialized
                        if ($.fn.DataTable.isDataTable('#candidateRemarkTable')) {
                            $('#candidateRemarkTable').DataTable().destroy();
                        }

                        // Clear existing rows
                        $('#candidateRemarkTable').find('tbody').empty();

                        // Populate table with data
                        for (let i = 0; i < remarkData.length; i++) {
                            let count = 1 + i;
                            let newRowHtml = '<tr>' +
                                    '<th scope="row">' + count + '</th>' +
                                    '<td>' + remarkData[i].assign_to + '</td>' +
                                    '<td>' + remarkData[i].client + '</td>' +
                                    '<td>' + remarkData[i].remarkstype + '</td>' +
                                    '<td>' + remarkData[i].remarks + '</td>' +
                                    '<td>' + remarkData[i].created_by + '</td>' +
                                    '<td>' + remarkData[i].create_time + '</td>' +
                                    '<td>' + remarkData[i].create_date + '</td>' +
                                '</tr>';

                            $('#candidateRemarkTable').append(newRowHtml);
                        }

                        // Initialize DataTable
                        $('#candidateRemarkTable').DataTable({
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
