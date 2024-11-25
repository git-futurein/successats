@extends('layouts.master')
@section('title')
    Create Employee
@endsection
@section('page-title')
    Employee Create
@endsection
@section('css')
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
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6 class="card-title mb-0">Create New Employee</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('employee.index') }}" class="btn btn-sm btn-success">Search</a>
                            </div>
                        </div>
                    </div>
                    @include('admin.include.errors')

                    <div class="card-body">
                        <!-- Nav tabs -->
                        <div class="row">
                            <div class="col-lg-7">
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#General_info" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">General Info</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#contact_info" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Contact Info</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#job_info" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Job Info</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#bank_info" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Bank Info</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#foreign_worker" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Foreign Worker</span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#leave" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Leave</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>

                        <!-- Tab panes -->
                        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="General_info" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-9 row">
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="one" class="col-sm-5 col-form-label fw-bold">Reg No</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="reg_no" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1 form-group required">
                                                <label for="two" class="col-sm-5 col-form-label fw-bold">User Right</label>
                                                <div class="col-sm-7">
                                                    <select name="roles_id" class="form-control searchBox single-select-field"
                                                        id="mySelect" required>
                                                        <option value="">Select One</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @php
                                                $auth = Auth::user()->employe;
                                            @endphp
                                            {{-- @if($auth->roles_id == 1) --}}
                                            <div class="row col-md-6 col-lg-6 mb-1" id="role7input" style="display: none;">
                                                <label for="two" class="col-sm-5 col-form-label fw-bold">Manager</label>
                                                <div class="col-sm-7">
                                                    <select id="role7manager" class="form-control searchBox single-select-field" name="manager_users_id">
                                                        <option value="" selected disabled>Select One</option>
                                                        @foreach ($managers as $user)
                                                            @if ($auth->roles_id == 4)
                                                                <option value="{{ $user->id }}"
                                                                    {{ $auth->id == $user->id ? 'selected' : 'disabled hidden' }}>
                                                                    {{ $user->employee_name }}</option>
                                                            @else
                                                                <option value="{{ $user->id }}"
                                                                    {{ $auth->id == $user->id ? 'selected' : '' }}>
                                                                    {{ $user->employee_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- @endif --}}
                                            {{-- @if($auth->roles_id == 1 || $auth->roles_id == 4) --}}
                                            <div class="row col-md-6 col-lg-6 mb-1" id="role7inputanother" style="display: none;">
                                                <label for="role7team_leader" class="col-sm-5 col-form-label fw-bold">Team Leader</label>
                                                <div class="col-sm-7">
                                                    <select id="role7team_leader" class="form-control searchBox single-select-field" name="team_leader_users_id">

                                                    </select>
                                                </div>
                                            </div>
                                            {{-- @endif --}}
                                            <div class="row col-md-6 col-lg-6 mb-1 form-group required">
                                                <label for="employee_name" class="col-sm-5 col-form-label fw-bold">Name <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="employee_name" class="form-control"
                                                        placeholder="Name" required>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="employee_code" class="col-sm-5 col-form-label fw-bold">Initial</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="employee_code" class="form-control"
                                                        placeholder="Employee Intial">
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="employee_birthdate" class="col-sm-5 col-form-label fw-bold">Birthday</label>
                                                <div class="col-sm-7">
                                                    <input type="date" name="employee_birthdate"
                                                        class="form-control" placeholder="Birthday" required>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="employee_email" class="col-sm-5 col-form-label fw-bold">Email Address<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="employee_email" class="form-control" id="employee_email" placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="employee_phone" class="col-sm-5 col-form-label fw-bold">Phone No</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="employee_phone" class="form-control"
                                                        placeholder="Phone no">
                                                </div>
                                            </div>
                                            <input type="hidden" name="employee_outlet_id" value="0">
                                            {{-- <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="one" class="col-sm-5 col-form-label fw-bold">Outlet <span class="text-danger">*</span> </label>
                                                <div class="col-sm-7">
                                                    <select name="employee_outlet_id" class="form-control searchBox single-select-field"
                                                        required>
                                                        <option value="">Select One</option>
                                                        @foreach ($outlets as $outlet)
                                                            <option value="{{ $outlet->id }}">
                                                                {{ $outlet->outlet_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="two" class="col-sm-5 col-form-label fw-bold">Pass Type</label>
                                                <div class="col-sm-7">
                                                    <select name="passtypes_id" class="form-control searchBox single-select-field">
                                                        <option value="">Select One</option>
                                                        @foreach ($passes as $pass)
                                                            <option value="{{ $pass->id }}">
                                                                {{ $pass->passtype_code }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="one" class="col-sm-5 col-form-label fw-bold">NRIC</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="employee_nric" class="form-control"
                                                        placeholder="NRIC">
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1 form-group required" id="role4input"
                                                style="display: none;">
                                                <label for="one" class="col-sm-5 col-form-label fw-bold">SHRC/SRC<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-7">
                                                    <input id type="text" name="employee_shrc"
                                                        class="form-control" placeholder="SHRC">
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1 form-group required">
                                                <label for="two" class="col-sm-5 col-form-label fw-bold">Sex</label>
                                                <div class="col-sm-7">
                                                    <select name="dbsexes_id" class="form-control searchBox single-select-field">
                                                        <option value="">Select One</option>
                                                        @foreach ($sexs as $sex)
                                                            <option value="{{ $sex->id }}">
                                                                {{ $sex->dbsexes_code }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="two" class="col-sm-5 col-form-label fw-bold">Marital
                                                    Status</label>
                                                <div class="col-sm-7">
                                                    <select name="marital_statuses_id" class="form-control searchBox single-select-field">
                                                        <option value="">Select One</option>
                                                        @foreach ($marital_status as $marital)
                                                            <option value="{{ $marital->id }}">
                                                                {{ $marital->marital_statuses_code }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="two" class="col-sm-5 col-form-label fw-bold">Religion</label>
                                                <div class="col-sm-7">
                                                    <select name="religions_id" class="form-control searchBox single-select-field">
                                                        <option value="">Select One</option>
                                                        @foreach ($religions as $religion)
                                                            <option value="{{ $religion->id }}">
                                                                {{ $religion->religion_code }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="two" class="col-sm-5 col-form-label fw-bold">Race</label>
                                                <div class="col-sm-7">
                                                    <select name="races_id" class="form-control searchBox single-select-field">
                                                        <option value="">Select One</option>
                                                        @foreach ($races as $race)
                                                            <option value="{{ $race->id }}">
                                                                {{ $race->race_code }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="toggleCheckbox" class="col-sm-8 col-form-label fw-bold">Click to set credential</label>
                                                <div class="col-sm-4">
                                                    <input type="checkbox" class="mt-2" id="toggleCheckbox" onclick="setCredential()">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="row mb-4">
                                                <div class="col-sm-7">
                                                    <img src="{{ URL::asset('build/images/avatar.png') }}" alt="avatar"
                                                        class="mb-2">
                                                    <input type="file" name="employee_avater" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4" id="login_info" style="display: none;">
                                        <h5>Login Information</h5>
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="two" class="col-sm-4  col-form-label fw-bold">Login Email <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="email" class="form-control" id="email" name="email">
                                                    <small>Google Authenticator secret key will send this email!</small>
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="two" class="col-sm-4  col-form-label fw-bold">Password<span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" name="password">
                                                </div>
                                            </div>
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="two" class="col-sm-4  col-form-label fw-bold">Confirm Password<span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control"
                                                        name="password_confirmation">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="contact_info" role="tabpanel">
                                    <div class="row">
                                        <h5>Address Information</h5>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Postal Code
                                                1</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_postal_code"
                                                    class="form-control" placeholder="Postal Code">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Unit No
                                                1</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_unit_number"
                                                    class="form-control" placeholder="Unit No">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Postal Code
                                                2</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_postal_code2"
                                                    class="form-control" placeholder="Postal Code">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Unit No
                                                2</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_unit_number2"
                                                    class="form-control" placeholder="Unit No">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label fw-bold">Address
                                                1</label>
                                            <div class="col-sm-7">
                                                <textarea name="employee_street" rows="2" class="form-control" placeholder="Address"></textarea>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label fw-bold">Address
                                                2</label>
                                            <div class="col-sm-7">
                                                <textarea name="employee_street2" rows="2" class="form-control" placeholder="Address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h5 class="mt-3">Emergency Contact Address Information</h5>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Contact
                                                Person</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_emr_contact"
                                                    class="form-control" placeholder="Contact Person">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one"
                                                class="col-sm-5 col-form-label fw-bold">Relationship</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_emr_relation"
                                                    class="form-control" placeholder="Relationship">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Phone 1</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_emr_phone1"
                                                    class="form-control" placeholder="Phone 1">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Phone 2</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_emr_phone2"
                                                    class="form-control" placeholder="Phone 2">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label fw-bold">Address</label>
                                            <div class="col-sm-7">
                                                <textarea name="employee_emr_address" rows="2" class="form-control" placeholder="Address"></textarea>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label fw-bold">Remarks</label>
                                            <div class="col-sm-7">
                                                <textarea name="employee_emr_remarks" rows="2" class="form-control" placeholder="Remarks"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="job_info" role="tabpanel">
                                    <div class="row">
                                        <h5>Job Information</h5>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Department</label>
                                            <div class="col-sm-7">
                                                <select name="departments_id" class="form-control searchBox single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">
                                                            {{ $department->department_code }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Work time
                                                (Start)</label>
                                            <div class="col-sm-7">
                                                <input type="time" name="employee_work_time_start"
                                                    class="form-control" placeholder="Unit No">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label fw-bold">Join
                                                Date</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="employee_joindate"
                                                    class="form-control" placeholder="Join Date">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label fw-bold">Confirmation
                                                Date</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="employee_confirmationdate"
                                                    class="form-control" placeholder="Confirmation Date">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label fw-bold">PR Date</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="employee_prdate" class="form-control"
                                                    placeholder="PR Date">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one"
                                                class="col-sm-5 col-form-label fw-bold">Designation</label>
                                            <div class="col-sm-7">
                                                <select name="designations_id" class="form-control searchBox single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($designations as $designation)
                                                        <option value="{{ $designation->id }}">
                                                            {{ $designation->designation_code }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Work time
                                                (End)</label>
                                            <div class="col-sm-7">
                                                <input type="time" name="employee_work_time_end"
                                                    class="form-control" placeholder="Work time (End)">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Probation
                                                Period</label>
                                            <div class="col-sm-7">
                                                <select name="employee_probation" class="form-control searchBox single-select-field"
                                                    id="employee_probation">

                                                    <option value='0'>Select One</option>
                                                    <option value='1'
                                                        {{ old('employee_probation') == 1 ? 'selected' : '' }}>
                                                        1
                                                    </option>
                                                    <option value='2'
                                                        {{ old('employee_probation') == 2 ? 'selected' : '' }}>
                                                        2
                                                    </option>
                                                    <option value='3'
                                                        {{ old('employee_probation') == 3 ? 'selected' : '' }}>
                                                        3
                                                    </option>
                                                    <option value='4'
                                                        {{ old('employee_probation') == 4 ? 'selected' : '' }}>
                                                        4
                                                    </option>
                                                    <option value='5'
                                                        {{ old('employee_probation') == 5 ? 'selected' : '' }}>
                                                        5
                                                    </option>
                                                    <option value='6'
                                                        {{ old('employee_probation') == 6 ? 'selected' : '' }}>
                                                        6
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Extention of
                                                Probation</label>
                                            <div class="col-sm-7">
                                                <select name="employee_extentionprobation"
                                                    class="form-control searchBox single-select-field" id="employee_extentionprobation">
                                                    <option value='0'>Select One</option>
                                                    <option value='1'
                                                        {{ old('employee_extentionprobation') == 1 ? 'selected' : '' }}>
                                                        1</option>
                                                    <option value='2'
                                                        {{ old('employee_extentionprobation') == 2 ? 'selected' : '' }}>
                                                        2</option>
                                                    <option value='3'
                                                        {{ old('employee_extentionprobation') == 3 ? 'selected' : '' }}>
                                                        3</option>
                                                    <option value='4'
                                                        {{ old('employee_extentionprobation') == 4 ? 'selected' : '' }}>
                                                        4</option>
                                                    <option value='5'
                                                        {{ old('employee_extentionprobation') == 5 ? 'selected' : '' }}>
                                                        5</option>
                                                    <option value='6'
                                                        {{ old('employee_extentionprobation') == 6 ? 'selected' : '' }}>
                                                        6</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Termination /
                                                Resignation Date</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="employee_resigndate"
                                                    class="form-control"
                                                    placeholder="Termination / Resignation Date">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Terminate Reason</label>
                                            <div class="col-sm-7">
                                                <textarea name="employee_resignreason" rows="2" placeholder="Terminate Reason" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h5>Alert Supervisor</h5>
                                        <div class="col-lg-6">
                                            <div class="row mb-1">
                                                <h6><u>Leave</u></h6>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="leave_aprv1_users_id" class="col-sm-5 col-form-label fw-bold">Approved level 1</label>
                                                <div class="col-sm-7">
                                                    <select name="leave_aprv1_users_id" class="form-control searchBox single-select-field"
                                                        id="leave_aprv1_users_id">
                                                        <option value="">Select One</option>
                                                        @foreach ($emp_admin as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('leave_aprv1_users_id') == $data->id ? 'selected' : '' }}>
                                                                {{ $data->employee_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="leave_aprv2_users_id" class="col-sm-5 col-form-label fw-bold">Approved level
                                                    2</label>
                                                <div class="col-sm-7">
                                                    <select name="leave_aprv2_users_id" class="form-control searchBox single-select-field"
                                                        id="leave_aprv2_users_id">
                                                        <option value="">Select One</option>
                                                        @foreach ($emp_admin as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('leave_aprv2_users_id') == $data->id ? 'selected' : '' }}>
                                                                {{ $data->employee_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="leave_aprv3_users_id" class="col-sm-5 col-form-label fw-bold">Approved level
                                                    3</label>
                                                <div class="col-sm-7">
                                                    <select name="leave_aprv3_users_id" class="form-control searchBox single-select-field"
                                                        id="leave_aprv3_users_id">
                                                        <option value="">Select One</option>
                                                        @foreach ($emp_admin as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('leave_aprv3_users_id') == $data->id ? 'selected' : '' }}>
                                                                {{ $data->employee_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row mb-1">
                                                <h6><u>Claims</u></h6>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="claims_aprv1_users_id" class="col-sm-5 col-form-label fw-bold">Approved level
                                                    1</label>
                                                <div class="col-sm-7">
                                                    <select name="claims_aprv1_users_id"
                                                        class="form-control searchBox single-select-field" id="claims_aprv1_users_id">
                                                        <option value="">Select One</option>
                                                        @foreach ($emp_admin as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('claims_aprv1_users_id') == $data->id ? 'selected' : '' }}>
                                                                {{ $data->employee_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="claims_aprv2_usersid" class="col-sm-5 col-form-label fw-bold">Approved level
                                                    2</label>
                                                <div class="col-sm-7">
                                                    <select name="claims_aprv2_usersid" class="form-control searchBox single-select-field" id="claims_aprv2_usersid">
                                                        <option value="">Select One</option>
                                                        @foreach ($emp_admin as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('claims_aprv2_usersid') == $data->id ? 'selected' : '' }}>
                                                                {{ $data->employee_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="claims_aprv3_users_id" class="col-sm-5 col-form-label fw-bold">Approved level
                                                    3</label>
                                                <div class="col-sm-7">
                                                    <select name="claims_aprv3_users_id"
                                                        class="form-control searchBox single-select-field" id="claims_aprv3_users_id">
                                                        <option value="">Select One</option>
                                                        @foreach ($emp_admin as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('claims_aprv3_users_id') == $data->id ? 'selected' : '' }}>
                                                                {{ $data->employee_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="bank_info" role="tabpanel">
                                    <div class="row">
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="paymodes_id" class="col-sm-5 col-form-label fw-bold">Pay Mode</label>
                                            <div class="col-sm-7">
                                                <select name="paymodes_id" class="form-control searchBox single-select-field"
                                                    id="paymodes_id">
                                                    <option value="">Select One</option>
                                                    <option value="1">Cash</option>
                                                    <option value="2">Cheque</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="employee_bank" class="col-sm-5 col-form-label fw-bold">GIRO Bank
                                                Code</label>
                                            <div class="col-sm-7">
                                                <select name="employee_bank" class="form-control single-select-field" id="employee_bank">
                                                    <option value="">Select One</option>
                                                    @foreach ($Paybanks as $data)
                                                        <option value="{{ $data->id }}"
                                                            {{ old('employee_bank') == $data->id ? 'selected' : '' }}>
                                                            {{ $data->Paybank_code }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">GIRO Account
                                                Name</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_bank_acc_title"
                                                    class="form-control" placeholder="GIRO Account Name">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">GIRO Account
                                                No</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_bank_acc_no"
                                                    class="form-control" placeholder="GIRO Account No">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="foreign_worker" role="tabpanel">
                                    <h5>Work Permit Information</h5>
                                    <div class="row">
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Work Permit
                                                Number</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_fw_permit_number"
                                                    class="form-control" placeholder="Work Permit Number">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Date of
                                                Arrival</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="employee_fw_arrival_date"
                                                    class="form-control" placeholder="Date of Arrival">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Application
                                                Date</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="employee_fw_application_date"
                                                    class="form-control" placeholder="Application Date">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Issue
                                                Date</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="employee_fw_issue_date"
                                                    class="form-control" placeholder="Pass Issuance Date">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Renewal
                                                Date</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="employee_fw_renewal_date"
                                                    class="form-control" placeholder="Renewal Date">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Levy
                                                Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="employee_fw_levy_amount"
                                                    class="form-control" placeholder="Levy Amount">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="leave" role="tabpanel">
                                    <div class="form-group mb-2">
                                        <label for="emplleave_leavetype" class="col-sm-2 control-label fw-bold">Leave
                                            Title</label>
                                        <label for="emplleave_leavetype" class="col-sm-1 control-label fw-bold">Hide</label>
                                        <label for="emplleave_leavetype" class="col-sm-3 control-label fw-bold">Balance
                                            (2023)</label>
                                        <label for="emplleave_leavetype" class="col-sm-3 control-label fw-bold">Entitled
                                            (2023)</label>
                                    </div>
                                    @foreach ($leave_types as $leave)
                                        <div class="form-group mb-1">
                                            <div class="row">
                                                <label for="emplleave_leavetype"
                                                    class="col-sm-2 control-label d-flex align-items-center fw-bold">{{ $leave->leavetype_code }}</label>
                                                <div class="col-sm-1 d-flex align-items-center">
                                                    <input type="checkbox" value="1" name="medical_reimbursement">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control"
                                                        name="medical_reimbursement"
                                                        value="{{ $leave->leavetype_default }}" placeholder="Days">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control"
                                                        name="medical_reimbursement" value="0" placeholder="Days">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7">
                                    <div>
                                        <a href="#" class="btn btn-sm btn-secondary w-md">Back</a>
                                        <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        @include('admin.include.select2js')

        <script>
            $(document).ready(function() {
                $('#mySelect').change(function() {
                    var selectedValue = $(this).val();

                    if (selectedValue === '8') {
                        manager();
                        teamleader();
                    } else if (selectedValue === '12') {
                        manager();
                        teamleader();
                    } else if (selectedValue === '11') {
                        manager();
                        $('#role7inputanother').hide();
                    } else {
                        $('#role7input').hide();
                        $('#role7inputanother').hide();
                    }

                    function teamleader() {
                        $('#role7inputanother').show();
                        $('#role7team_leader').attr('name', 'team_leader_users_id');
                    }

                    function cons() {
                        $('#role7inputcons').show();
                        $('#role7team_leader').attr('name', 'team_leader_users_id');
                    }

                    function manager() {
                        $('#role7input').show();
                        $('#role7manager').attr('name', 'manager_users_id');
                    }

                });
            });

            function setCredential()
            {
                var div = document.getElementById("login_info");
                let employee_email = $('#employee_email').val();
                console.log(employee_email);
                $('#email').val(employee_email);
                div.style.display = div.style.display === "none" ? "block" : "none";
            }

            $(document).ready(function() {
                let auth_role = '{{ $auth->roles_id }}';
                let auth = '{{ $auth->id }}';

                function getLeadaer(managerId)
                {
                    $.ajax({
                        type: 'GET',
                        url: '/ATS/get/teamleader/' + managerId,
                        success: function(data) {
                            console.log(data);
                            $('#role7team_leader').empty();

                            let option = $('<option>', {
                                value: '',
                                text: 'Choose One',
                            });
                            $('#role7team_leader').append(option);
                            $.each(data, function(key, value) {
                                option = $('<option>', {
                                    value: value.id,
                                    text: value.employee_name
                                });
                                $('#role7team_leader').append(option);
                            });
                            $('#role7team_leader').trigger('change');
                        }
                    });
                }
                $('#role7manager').change(function() {
                    let managerId = $(this).val();
                    if (managerId) {
                        getLeadaer(managerId);
                    } else {
                        $('#role7team_leader').empty();
                    }
                });

                if(auth_role == 4)
                {
                    let managerId = auth;
                    getLeadaer(managerId);
                }
            });
        </script>
    @endsection
