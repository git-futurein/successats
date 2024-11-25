@extends('layouts.master')
@section('title')
Search Function
@endsection
@section('page-title')
Search Candidate Detail
@endsection
@section('body')
<body>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
@endsection
@section('content')


<style>
    .fixed-table-container {
        position: fixed;
        bottom: 0;
        width: 78%;
        background-color: #fff;
        border-top: 1px solid #ddd;
        padding: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        height: 250px;
        overflow:scroll;
    }

    @keyframes slideInFromBottom {
        from {
            transform: translate3d(0, 100%, 0);
        }
        to {
            transform: translate3d(0, 0, 0);
        }
    }

    .modal.bottom .modal-dialog {
        animation: slideInFromBottom 0.8s ease-out;
        transform-origin: 50% 100%;
        height: 400px;
        margin: 0;
    }

    .modal.bottom .modal-content {
        width: 100vw;
        border-radius: 0;
    }

    .highlight {
        background-color: yellow;
        font-weight: bold;
    }

</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">
                        <h6 class="card-title mb-0">Search Table</h6>
                    </div>
                    <div class="p-2 bd-highlight">
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
                <form action="{{ route('candidate.search.resutl') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row mb-1">
                                <label for="one" class="col-sm-3 col-form-label">Keyword</label>
                                <div class="col-sm-8">
                                    <input type="text" name="keyword" class="form-control" placeholder="Keyword">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="one" class="col-sm-3 col-form-label">Grouping</label>
                                <div class="col-sm-8">
                                    <select name="" id="" class="form-control">
                                        <option value="">Yes</option>
                                        <option value="">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-1">
                                <label for="one" class="col-sm-3 col-form-label">Date Range</label>
                                <div class="col-sm-8">
                                    <input type="text" name="daterange" value="{{ isset($dateRange) ? $dateRange : old('dateRange') }}" class="form-control" id="daterangeInput" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <label for="one" class="col-sm-3 col-form-label">Existing Folder</label>
                                <div class="col-sm-8">
                                    <select name="" id="" class="form-control">
                                        <option value="">Create New</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-5 text-center">
                            <button type="submit" class="btn btn-info btn-sm">Search</button>
                            <button type="submit" class="btn btn-warning btn-sm">Save to Profile</button>
                            <button type="submit" class="btn btn-success btn-sm">Save All</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-lg-12 mt-2">
                        <table class="table table-bordered mb-0"  id="candidateTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Candidate</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Resume Detail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data))
                                    @foreach($data as $key => $item)
                                        <tr style="cursor: pointer" class="accordion-row" id="row_{{ $item['candidate_id'] }}"  data-candidate-name="{{ $item['candidate_name'] }}" >
                                            <th>{{ ++$key }}</th>
                                            <th>{!! str_replace($keyword, '<span class="highlight">' . $keyword . '</span>', $item['candidate_name']) !!}</th>
                                            <th>{!! str_replace($keyword, '<span class="highlight">' . $keyword . '</span>', $item['candidate_mobile']) !!}</th>
                                            <th>{!! str_replace($keyword, '<span class="highlight">' . $keyword . '</span>', $item['candidate_email']) !!}</th>
                                            <td>
                                                <p style="height:200px; overflow:scroll">{!! str_replace($keyword, '<span class="highlight">' . $keyword . '</span>', $item['resume_text']) !!}</p>
                                            </td>
                                            <th>
                                                {{-- @if (App\Helpers\FileHelper::usr()->can('candidate.update')) --}}
                                                <button type="button" class="btn btn-info btn-sm me-2 mb-2 resumePath" data-bs-toggle="modal" data-bs-target="#showResume" data-file-path="{{$item['resume_file_path']}}">
                                                    D
                                                </button>
                                                {{-- @endif --}}
                                                @if (App\Helpers\FileHelper::usr()->can('candidate.remark'))
                                                <a href="{{ route('candidate.edit', $item['candidate_id']) }}#remark"
                                                    class="btn btn-warning btn-sm me-2">R</a>
                                                @endif
                                            </th>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Candidate</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Resume Detail</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fixed-table-container" id="resumeTable" style="display: none">
    <div class="d-flex bd-highlight">
        <div class="flex-grow-1 bd-highlight">
            <h6><span id="cand_name"></span> Remarks</h6>
        </div>
        <div class="bd-highlight" style="margin: 0"><h1 onclick="removeRemark()" style="cursor: pointer; margin: 0 0 0;">-</h1></div>
    </div>

    <table class="table" id="resumeDataTable">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Client</th>
                <th scope="col">Remark Type</th>
                <th scope="col">Remarks</th>
                <th scope="col">Create By</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody id="candidateResume">

        </tbody>
    </table>
</div>

@include('admin.candidate.inc.resume__modal')

@endsection
@section('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#candidateTable').DataTable();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let rows = document.querySelectorAll('.accordion-row');
            let dataTableInitialized = false;

            rows.forEach(function (row) {
                row.addEventListener('click', function () {
                    let candidate_id = this.id.split('_')[1];

                    let candidate_name = this.getAttribute('data-candidate-name');
                    document.getElementById('cand_name').innerHTML = candidate_name;

                    $.ajax({
                        type: 'GET',
                        url: '/ATS/get/candidate/remarks/' + candidate_id,
                        success: function (response) {
                            let resumeTable = document.getElementById('resumeTable');

                            if (resumeTable.style.display === 'none') {
                                resumeTable.style.display = 'block';
                            }

                            var remarkData = response.remarks;

                            // Clear existing DataTable before appending new data
                            if (dataTableInitialized) {
                                $('#resumeDataTable').DataTable().destroy();
                            }
                            $('#candidateResume').empty();
                            for (var i = 0; i < remarkData.length; i++) {
                                let count = 1 + i;
                                var newRowHtml = '<tr>' +
                                    '<th scope="row">' + count + '</th>' +
                                    '<td>' + remarkData[i].candidate_name + '</td>' +
                                    '<td>' + remarkData[i].remarkstype + '</td>' +
                                    '<td>' + remarkData[i].remarks + '</td>' +
                                    '<td>' + remarkData[i].created_by + '</td>' +
                                    '<td>' + remarkData[i].date + '</td>' +
                                    '</tr>';

                                $('#candidateResume').append(newRowHtml);
                            }

                            if (!dataTableInitialized) {
                                $('#resumeDataTable').DataTable({
                                    "pageLength": 3
                                });
                                dataTableInitialized = true;
                            } else {
                                $('#resumeDataTable').DataTable().destroy();
                                $('#resumeDataTable').DataTable({
                                    "pageLength": 3
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.resumePath').on('click', function() {
                var filePath = $(this).data('file-path');
                const iframe = document.getElementById('pdfViewer');
                var publicUrl = "{{ asset(Storage::url('')) }}" + "/" + filePath;
                iframe.src = publicUrl;
                iframe.width = "100%";
                iframe.height = "600px";
            });
        });

        $(function() {
            var initialValue = $('#daterangeInput').val();
            if (!initialValue) {
                initialValue = moment().format('YYYY-MM-DD');
            }

            $('#daterangeInput').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                },
                endDate: moment().format('YYYY-MM-DD'),
                startDate: initialValue
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });

        function removeRemark()
        {
            let resumeTable = document.getElementById('resumeTable');
            if (resumeTable.style.display === 'block') {
                resumeTable.style.display = 'none';
            }
            $('#candidateResume').empty();
        }
    </script>
@endsection
