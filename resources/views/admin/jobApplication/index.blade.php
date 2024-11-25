@extends('layouts.master')
@section('title')
    Job Application
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
                                <h6 class="card-title mb-0">Job Application Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('job.lists') }}" class="btn btn-sm btn-success">Create New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered mb-0" id="jobTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Phone No</th>
                                    <th>Email</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }} </td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->phone_no }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td style="display: flex;" class="d-flex flex-row-reverse">
                                            @if ($data->candidate_id == null)
                                                <form action="{{ route('job-application.update', $data->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm me-3">Genarate to
                                                        New Candidate</button>
                                                </form>
                                            @else
                                                @if ($data->candidate->candidate_isDeleted == 0)
                                                    <a href="{{ route('candidate.edit', $data->candidate_id) }}" class="btn btn-info btn-sm">View Profile</a>
                                                @endif
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
    @endsection

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#jobTable').DataTable();
            });
        </script>
    @endsection
