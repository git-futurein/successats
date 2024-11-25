@extends('layouts.master')
@section('title')
    Job Management
@endsection
@section('page-title')
    Job Management
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    @include('admin.include.select2')
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-2">Filter</h6>
                    </div>
                    <div class="card-body">
                        <form id="jobFilter" action="{{ route('filter.job') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="row col-md-6 col-lg-6 mb-1">
                                    <label for="display_address" class="col-sm-5 col-form-label fw-bold">Person In-Charge</label>
                                    <div class="col-sm-7">
                                        <select name="employees_id" id="employees_id" class="form-control single-select-field" required>
                                            @foreach (\Spatie\Permission\Models\Role::select('id', 'name')->whereNotIn('id', [1])->get() as $role)
                                                <option value="" disabled>{{$role->name}}</option>
                                                @foreach (\App\Models\Employee::where('roles_id', $role->id)->get() as $incharge)
                                                    <option value="{{ $incharge->id }}"  {{ isset($jobdetails['employees_id']) && $jobdetails['employees_id'] == $incharge->id ? 'selected' : '' }}>
                                                        {{ $incharge->employee_name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-md-6 col-lg-6 mb-1">
                                    <label for="display_address" class="col-sm-5 col-form-label fw-bold">Job Status</label>
                                    <div class="col-sm-7">
                                        <select name="job_status" id="job_status" class="form-control single-select-field">
                                            <option value="" selected disabled>Select One</option>
                                            <option value="1"  {{ isset($jobdetails['job_status']) && $jobdetails['job_status'] == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0"  {{ isset($jobdetails['job_status']) && $jobdetails['job_status'] == 0 ? 'selected' : '' }}>Close</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                {{-- <h6 class="card-title mb-0">Job Summary Table</h6> --}}
                            </div>
                            <div class="p-2 bd-highlight">
                                @if (App\Helpers\FileHelper::usr()->can('job.create'))
                                    <a href="{{ route('job.create') }}" class="btn btn-sm btn-success">Create New</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered mb-0" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Owner</th>
                                    <th>Status</th>
                                    <th>Job Type</th>
                                    <th>Create Date</th>
                                    <th>Last Updated By</th>
                                    <th style="width:100px">Internal Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>
                                            {{ $data->job_title }}
                                        </td>
                                        <td>
                                            {{ $data->job_category->jobcategory_name }}
                                        </td>
                                        <td>
                                            {{ $data->client->client_name }}
                                        </td>
                                        <td>
                                            <span class="btn btn-{{\App\Enums\JobStatus::from($data->job_status)->message()}} btn-sm">{{ \App\Enums\JobStatus::from($data->job_status)->title()}}</span>
                                        </td>
                                        <td>
                                            {{ $data?->job_type?->jobtype_code }}
                                        </td>
                                        <td>
                                            {{ $data->created_at }}
                                        </td>
                                        <td>
                                            {{ App\Helpers\FileHelper::modify_name($data->modify_by) }}
                                        </td>
                                        <td>
                                            {!! $data->remark !!}
                                        </td>
                                        <td style="display: flex;">
                                            @if (App\Helpers\FileHelper::usr()->can('job.edit'))
                                            <a href="{{ route('job.edit', $data->id) }}"
                                                class="btn btn-info btn-sm me-3"><i class="fas fa-pen"></i></a>
                                            @endif
                                            @if (App\Helpers\FileHelper::usr()->can('job.destroy'))
                                            <form id="deleteForm" action="{{ route('job.destroy', $data->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                    class="btn btn-sm btn-danger"> <i class="fas fa fa-trash"></i> </a>
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
    @endsection

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        @include('admin.include.select2js')

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();

                $('#employees_id, #job_status').change(function() {
                    if ($('#employees_id').val() && $('#job_status').val()) {
                        $('#jobFilter').submit();
                    }
                });
            });
        </script>

    @endsection
