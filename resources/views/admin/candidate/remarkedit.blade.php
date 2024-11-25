@extends('layouts.master')
@section('title')
    Edit Candidate
@endsection
@section('css')
    <!-- quill css -->
    <link href="{{ URL::asset('build/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    @include('admin.include.select2')
@endsection
@section('page-title')
    Candidate Edit
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
                            <h6 class="card-title mb-0">Edit Candidate</h6>
                        </div>
                        <div class="p-2 bd-highlight">
                            <a href="{{ route('candidate.create') }}" class="btn btn-sm btn-success">Create New</a>
                            <a href="{{ route('candidate.index') }}" class="btn btn-sm btn-success">Search</a>
                        </div>
                    </div>
                </div>
                @include('admin.include.errors')
                <div class="card-body">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#General_info" role="tab">
                                        <span class="d-sm-block">General Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#contact_info" role="tab">
                                        <span class="d-sm-block">Contact Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#bank_info" role="tab">
                                        <span class="d-sm-block">Bank Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#qualification" role="tab">
                                        <span class="d-sm-block">Qualification</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#family" role="tab">
                                        <span class="d-sm-block">Family</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#character_referees" role="tab">
                                        <span class="d-sm-block">Character Referee's</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#declaration" role="tab">
                                        <span class="d-sm-block">Declaration</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#terms_conditions" role="tab">
                                        <span class="d-sm-block">Terms & Conditions</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#upload_resume" role="tab">
                                        <span class="d-sm-block">Upload Resume</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#upload_file" role="tab">
                                        <span class="d-sm-block">Upload File</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="remark-tab" class="nav-link" data-bs-toggle="tab" href="#remark"
                                        role="tab">
                                        <span class="d-sm-block">Remark</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#payroll" role="tab">
                                        <span class="d-sm-block">Payroll</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#working_hour" role="tab">
                                        <span class="d-sm-block">Working Hour</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="General_info" role="tabpanel">
                            <form action="{{ route('candidate.update', $candidate->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-lg-9 row">
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_code"
                                                class="col-sm-5 col-form-label fw-bold">Candidate Code</label>
                                            <div class="col-sm-7">
                                                <input type="text" id="candidate_code" name="candidate_code"
                                                    class="form-control" placeholder="Candidate code" disabled
                                                    value="{{ $candidate->candidate_code }}">
                                            </div>
                                        </div>
                                        @php
                                            $auth = Auth::user()->employe;
                                        @endphp
                                        @if ($auth->roles_id == 1)
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="managerSelect"
                                                    class="col-sm-5 col-form-label fw-bold">Manager</label>
                                                <div class="col-sm-7">
                                                    <select name="manager_id" id="managerSelect"
                                                        class="form-control single-select-field">
                                                        @if ($auth->roles_id == 4)
                                                            <option value="{{ $auth->id }}" selected
                                                                @readonly(true)>
                                                                {{ $auth->employee_name }}</option>
                                                        @elseif($auth->roles_id == 1 || $auth->roles_id == 4 || $auth->roles_id == 8)
                                                            <option selected disabled> Select One </option>
                                                            @foreach (\App\Models\Employee::where('roles_id', 4)->get() as $manager)
                                                                <option value="{{ $manager->id }}"
                                                                    {{ $candidate->manager_id == $manager->id ? 'selected' : ($auth->manager_id == $manager->id ? 'selected' : '') }}>
                                                                    {{ $manager->employee_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($auth->roles_id == 1 || $auth->roles_id == 4)
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="teamLeaderSelect"
                                                    class="col-sm-5 col-form-label fw-bold">Team
                                                    Leader</label>
                                                <div class="col-sm-7">
                                                    <select name="team_leader_id" id="teamLeaderSelect"
                                                        class="form-control single-select-field">
                                                        <option value="" selected disabled>Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($auth->roles_id == 1 || $auth->roles_id == 4 || $auth->roles_id == 11)
                                            <div class="row col-md-6 col-lg-6 mb-1">
                                                <label for="consultantSelect"
                                                    class="col-sm-5 col-form-label fw-bold">Consultant</label>
                                                <div class="col-sm-7">
                                                    <select id="consultantSelect"
                                                        class="form-control single-select-field" name="consultant_id">
                                                        <option value="" selected disabled>Select One </option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_name"
                                                class="col-sm-5 col-form-label fw-bold">Candidate Name</label>
                                            <div class="col-sm-7">
                                                <input type="text" id="candidate_name" name="candidate_name"
                                                    class="form-control" value="{{ $candidate->candidate_name }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_nric"
                                                class="col-sm-5 col-form-label fw-bold">NRIC/FIN
                                                No.</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="candidate_nric" id="candidate_nric"
                                                    class="form-control" value="{{ $candidate->candidate_nric }}">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_birthdate"
                                                class="col-sm-5 col-form-label fw-bold">Date of Birth</label>
                                            <div class="col-sm-7">
                                                <input type="date" id="candidate_birthdate"
                                                    name="candidate_birthdate" class="form-control"
                                                    value="{{ $candidate->candidate_birthdate }}">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="dbsexes_id" class="col-sm-5 col-form-label fw-bold">Gender
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="dbsexes_id" id="dbsexes_id"
                                                    class="form-control single-select-field">
                                                    <option selected disabled>Select One
                                                    </option>
                                                    <option value="1"
                                                        {{ $candidate->dbsexes_id == 1 ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="2"
                                                        {{ $candidate->dbsexes_id == 2 ? 'selected' : '' }}>
                                                        Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="races_id" class="col-sm-5 col-form-label fw-bold">Race</label>
                                            <div class="col-sm-7">
                                                <select id="races_id" name="races_id"
                                                    class="form-control single-select-field">
                                                    <option value="" selected disabled>Select One</option>
                                                    @foreach ($race_data as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ $row->id == old('races_id', $candidate->races_id) ? 'selected' : '' }}>
                                                            {{ old('races_id') . $row->race_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="religions_id"
                                                class="col-sm-5 col-form-label fw-bold">Religion</label>
                                            <div class="col-sm-7">
                                                <select name="religions_id" id="religions_id"
                                                    class="form-control single-select-field">
                                                    @foreach ($religion_data as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ old('religions_id') == $row->id || $candidate->religions_id == $row->id ? 'selected' : '' }}>
                                                            {{ $row->religion_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="mySelect"
                                                class="col-sm-5 col-form-label fw-bold">Nationality</label>
                                            <div class="col-sm-7">
                                                <select name="nationality_id" class="form-control single-select-field"
                                                    id="mySelect">
                                                    <option value="">Select One</option>
                                                    @foreach ($nationality as $nation)
                                                        <option value="{{ $nation->id }}"
                                                            {{ old('nationality_id') == $nation->id || $candidate->nationality_id == $nation->id ? 'selected' : '' }}>
                                                            {{ old('nationality_id') . $nation->en_nationality }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="marital_statuses_id"
                                                class="col-sm-5 col-form-label fw-bold">Marital Status</label>
                                            <div class="col-sm-7">
                                                <select name="marital_statuses_id" id="marital_statuses_id"
                                                    class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($marital_data as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ $row->id == old('marital_statuses_id', $candidate->marital_statuses_id) ? 'selected' : '' }}>
                                                            {{ $row->marital_statuses_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1" id="myNationality"
                                            style="display: none;">
                                            <label for="nationality_date_of_issue"
                                                class="col-sm-5 col-form-label fw-bold">Date of issue</label>
                                            <div class="col-sm-7">
                                                <input id="nationality_date_of_issue" type="date"
                                                    name="nationality_date_of_issue" class="form-control"
                                                    value="{{ $candidate->nationality_date_of_issue }}">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_mobile"
                                                class="col-sm-5 col-form-label fw-bold">Mobile</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="candidate_mobile"
                                                    value="{{ $candidate->candidate_mobile }}" required>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_home_phone"
                                                class="col-sm-5 col-form-label fw-bold">Home Tel</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="candidate_home_phone"
                                                    name="candidate_home_phone"
                                                    value="{{ $candidate->candidate_home_phone }}">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_email"
                                                class="col-sm-5 col-form-label fw-bold">Email</label>
                                            <div class="col-sm-7">
                                                <input type="email" name="candidate_email" id="candidate_email"
                                                    class="form-control" value="{{ $candidate->candidate_email }}">
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="passtypes_id" class="col-sm-5 col-form-label fw-bold">Type Of
                                                Pass</label>
                                            <div class="col-sm-7">
                                                <select id="passtypes_id" name="passtypes_id"
                                                    class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($passtype_data as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ $row->id == old('passtypes_id', $candidate->passtypes_id) ? 'selected' : '' }}>
                                                            {{ $row->passtype_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_outlet_id"
                                                class="col-sm-5 col-form-label fw-bold">Outlet</label>
                                            <div class="col-sm-7">
                                                <select class="form-control single-select-field"
                                                    id="candidate_outlet_id" name="candidate_outlet_id" required>
                                                    <option value="">Select One</option>
                                                    @foreach ($outlet_data as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ $row->id == old('candidate_outlet_id', $candidate->candidate_outlet_id) ? 'selected' : '' }}>
                                                            {{ $row->outlet_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-md-6 col-lg-6 mb-1">
                                            <label for="candidate_isBlocked"
                                                class="col-sm-5 col-form-label fw-bold">Black List</label>
                                            <div class="col-sm-7">
                                                <select name="candidate_isBlocked" id="candidate_isBlocked"
                                                    class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                    <option value="1"
                                                        {{ $candidate->candidate_isBlocked == 1 ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                    <option value="0"
                                                        {{ $candidate->candidate_isBlocked == 0 ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        @if ($candidate->avatar)
                                            <img width="200" class="img-fluid img-thumbnail"
                                                src="{{ asset('storage') }}/{{ $candidate->avatar }}" alt="avatar"
                                                id="avatar-preview">
                                        @else
                                            <img width="200" src="{{ URL::asset('build/images/avatar.png') }}"
                                                alt="avatars" id="avatar-preview" class="mb-2">
                                        @endif
                                        <input type="file" name="avatar" id="avatar-input" class="form-control"
                                            accept="images">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9 my-3">
                                        <div>
                                            <a href="{{ route('candidate.index') }}"
                                                class="btn btn-sm btn-secondary w-md">Back</a>
                                            <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                            <a href="#" class="btn btn-sm btn-warning w-md">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="contact_info" role="tabpanel">
                            <form action="{{ route('candidate.update', $candidate->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <h5>Address Information</h5>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Postal Code
                                                    1</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_postal_code"
                                                        class="form-control" placeholder="Postal Code"
                                                        value="{{ $candidate->candidate_postal_code }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Unit No
                                                    1</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_unit_number"
                                                        class="form-control" placeholder="Unit No"
                                                        value="{{ $candidate->candidate_unit_number }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Address
                                                    1</label>
                                                <div class="col-sm-9">
                                                    <textarea name="candidate_street" rows="2" class="form-control" placeholder="Address"> {{ $candidate->candidate_street }} </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Postal Code
                                                    2</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_postal_code2"
                                                        class="form-control" placeholder="Postal Code"
                                                        value="{{ $candidate->candidate_postal_code2 }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Unit No
                                                    2</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_unit_number2"
                                                        class="form-control" placeholder="Unit No"
                                                        value="{{ $candidate->candidate_unit_number2 }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Address
                                                    2</label>
                                                <div class="col-sm-9">
                                                    <textarea name="candidate_street2" rows="2" class="form-control" placeholder="Address">{{ $candidate->candidate_street2 }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h5>Emergency Contact Address Information</h5>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Contact
                                                    Person</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_emr_contact"
                                                        class="form-control" placeholder="Contact Person"
                                                        value="{{ $candidate->candidate_emr_contact }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Phone 1</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_emr_phone1"
                                                        class="form-control" placeholder="Phone 1"
                                                        value="{{ $candidate->candidate_emr_phone1 }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Address</label>
                                                <div class="col-sm-9">
                                                    <textarea name="candidate_emr_address" rows="2" class="form-control" placeholder="Address"> {{ $candidate->candidate_emr_address }} </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one"
                                                    class="col-sm-3 col-form-label">Relationship</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_emr_relation"
                                                        class="form-control" placeholder="Relationship"
                                                        value="{{ $candidate->candidate_emr_relation }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Phone 2</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_emr_phone2"
                                                        class="form-control" placeholder="Phone 2"
                                                        value="{{ $candidate->candidate_emr_phone2 }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="row">
                                                    <label for="description"
                                                        class="col-sm-3 col-form-label">Remarks</label>
                                                    {{-- <label for="description" class="col-sm-12 col-md-2 col-form-label fw-bold">Description</label> --}}
                                                    <div class="col-sm-12 col-md-10">
                                                        <div class="d-flex flex-row-reverse description_textarea">
                                                            <textarea name="candidate_emr_remarks" id="description" class="editor" rows="2"> {{ $candidate->candidate_emr_remarks }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9 ms-3 mb-3">
                                        <div>
                                            <a href="{{ route('candidate.index') }}"
                                                class="btn btn-sm btn-secondary w-md">Back</a>
                                            <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                            <a href="#" class="btn btn-sm btn-warning w-md">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="bank_info" role="tabpanel">
                            <form action="{{ route('candidate.update', $candidate->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Pay Mode</label>
                                                <div class="col-sm-9">
                                                    <select name="paymodes_id"
                                                        class="form-control  single-select-field" id="">
                                                        <option value="">Select One</option>
                                                        <option value="1"
                                                            {{ $candidate->paymodes_id == 1 ? 'selected' : '' }}>
                                                            Cash</option>
                                                        <option value="2"
                                                            {{ $candidate->paymodes_id == 2 ? 'selected' : '' }}>
                                                            Cheque
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">GIRO Account
                                                    Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_bank_acc_title"
                                                        class="form-control" placeholder="GIRO Account Name"
                                                        value="{{ $candidate->candidate_bank_acc_title }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">GIRO Bank
                                                    Code</label>
                                                <div class="col-sm-9">
                                                    <select name="candidate_bank"
                                                        class="form-control single-select-field" id="">
                                                        <option value="">Select One</option>
                                                        @foreach ($Paybanks as $data)
                                                            <option value="{{ $data->id }}"
                                                                {{ old('candidate_bank', $candidate->candidate_bank) == $data->id ? 'selected' : '' }}>
                                                                {{ $data->Paybank_code }} </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">GIRO Account
                                                    No</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_bank_acc_no"
                                                        class="form-control" placeholder="GIRO Account No"
                                                        value="{{ $candidate->candidate_bank_acc_no }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9 ms-3 mb-3">
                                        <div>
                                            <a href="{{ route('candidate.index') }}"
                                                class="btn btn-sm btn-secondary w-md">Back</a>
                                            <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                            <a href="#" class="btn btn-sm btn-warning w-md">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="qualification" role="tabpanel">
                            <form action="{{ route('candidate.update', $candidate->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <h5>Qualification and Skill</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">N-Levels</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control"
                                                        name="candidate_n_level" placeholder="Course"
                                                        value="{{ $candidate->candidate_n_level }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">O-Levels</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_o_level"
                                                        class="form-control" placeholder="Course"
                                                        value="{{ $candidate->candidate_o_level }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">A-Levels</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_a_level"
                                                        class="form-control" placeholder="Course"
                                                        value="{{ $candidate->candidate_a_level }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Diploma</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_diploma"
                                                        class="form-control" placeholder="Course"
                                                        value="{{ $candidate->candidate_diploma }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Degree</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_degree"
                                                        class="form-control" placeholder="Course"
                                                        value="{{ $candidate->candidate_degree }}">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Other</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="candidate_other" class="form-control"
                                                        placeholder="Course"
                                                        value="{{ $candidate->candidate_other }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>Please state languages and proficiency level, e.g. excellent, good, fair, poor
                                    </p>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Written</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="candidate_written" class="form-control"
                                                    placeholder="eg: English - good"
                                                    value="{{ $candidate->candidate_written }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Spoken</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="candidate_spocken" class="form-control"
                                                    placeholder="eg: English - good"
                                                    value="{{ $candidate->candidate_spocken }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9 ms-3 mb-3">
                                        <div>
                                            <a href="{{ route('candidate.index') }}"
                                                class="btn btn-sm btn-secondary w-md">Back</a>
                                            <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                            <a href="#" class="btn btn-sm btn-warning w-md">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="family" role="tabpanel">
                            @if (App\Helpers\FileHelper::usr()->can('candidate.family'))
                                <h5>Create Family Background</h5>
                                <form action="{{ route('candidate.family', $candidate->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">
                                            <div class="mt-5 mt-lg-4 mt-xl-0">
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <label for="one"
                                                        class="col-sm-3 col-form-label">Relationship</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="relationship" name="one"
                                                            class="form-control" placeholder="Relationship">
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Contact
                                                        No</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="contact_no" class="form-control"
                                                            placeholder="Contact No">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mt-5 mt-lg-4 mt-xl-0">
                                                <div class="row mb-4">
                                                    <label for="one" class="col-sm-3 col-form-label">Age</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="age" class="form-control"
                                                            placeholder="Age">
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <label for="one"
                                                        class="col-sm-3 col-form-label">Occupation</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="occupation" class="form-control"
                                                            placeholder="Occupation">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <button type="submit" class="btn btn-info btn-sm">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Age</th>
                                                <th>Relationship</th>
                                                <th>Contact</th>
                                                <th>Occuption</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($families as $family)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }} </td>
                                                    <td>{{ $family->name }} </td>
                                                    <td>{{ $family->age }} </td>
                                                    <td>{{ $family->relationship }} </td>
                                                    <td>{{ $family->contact_no }} </td>
                                                    <td>{{ $family->occupation }} </td>
                                                    <td>
                                                        @if (App\Helpers\FileHelper::usr()->can('candidate.family.delete'))
                                                            <form
                                                                action="{{ route('candidate.family.delete', $family->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                                    type="submit"><i
                                                                        class="fa fa-trash"></i></button>
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
                        <div class="tab-pane" id="character_referees" role="tabpanel">
                            <form action="{{ route('candidate.update', $candidate->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <h5>Character Referee's</h5>
                                <p>Name 2 persons who are not your relatives</p>
                                <div class="row mb-5">
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="candidate_referee_name1"
                                                    class="form-control" placeholder="Name"
                                                    value="{{ $candidate->candidate_referee_name1 }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Years
                                                Known</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="candidate_referee_year_know1"
                                                    class="form-control" placeholder="Year"
                                                    value="{{ $candidate->candidate_referee_year_know1 }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Occupation</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    name="candidate_referee_occupation1" placeholder="Occupation"
                                                    value="{{ $candidate->candidate_referee_occupation1 }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Contact No / Email
                                                Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="candidate_referee_contact1"
                                                    class="form-control" placeholder="Contact No"
                                                    value="{{ $candidate->candidate_referee_contact1 }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    name="candidate_referee_name2" placeholder="Name"
                                                    value="{{ $candidate->candidate_referee_name2 }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Years
                                                Known</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="candidate_referee_year_know2"
                                                    class="form-control" placeholder="Year"
                                                    value="{{ $candidate->candidate_referee_year_know2 }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Occupation</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="candidate_referee_occupation2"
                                                    class="form-control" placeholder="Occupation"
                                                    value="{{ $candidate->candidate_referee_occupation2 }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Contact No /
                                                Email
                                                Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="candidate_referee_contact2"
                                                    class="form-control" placeholder="Contact No"
                                                    value="{{ $candidate->candidate_referee_contact2 }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9 ms-3 mb-3">
                                        <div>
                                            <a href="{{ route('candidate.index') }}"
                                                class="btn btn-sm btn-secondary w-md">Back</a>
                                            <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                            <a href="#" class="btn btn-sm btn-warning w-md">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="declaration" role="tabpanel">
                            <form action="{{ route('candidate.update', $candidate->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <h5 class="mb-5">Declaration</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="form-group mb-2" id="bankrupt">
                                                <label for="declaration_bankrupt" class=" control-label">1. Are
                                                    you / Have you ever been an undischarged bankrupt?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="candidate_dec_bankrupt"
                                                                value="1"
                                                                {{ $candidate->candidate_dec_bankrupt == 1 ? 'checked' : '' }}>Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="candidate_dec_bankrupt"
                                                                value="0"
                                                                {{ $candidate->candidate_dec_bankrupt == 0 ? 'checked' : '' }}>No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6" id="candidate_dec_bankrupt_details"
                                                        style="display: none;">
                                                        <input type="text" class="form-control"
                                                            name="candidate_dec_bankrupt_details"
                                                            placeholder="If Yes, Please specify"
                                                            value="{{ $candidate->candidate_dec_bankrupt_details }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="declaration_bankrupt" class=" control-label">2. Are you
                                                    suffering from any physical / mental impairment or chronic /
                                                    pre-existing illness?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="candidate_dec_physical"
                                                                value="1"
                                                                {{ $candidate->candidate_dec_physical == 1 ? 'checked' : '' }}>Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="candidate_dec_physical"
                                                                value="0"
                                                                {{ $candidate->candidate_dec_physical == 0 ? 'checked' : '' }}>No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control"
                                                            id="candidate_dec_physical_details"
                                                            name="candidate_dec_physical_details"
                                                            placeholder="If Yes, Please specify"
                                                            value="{{ $candidate->candidate_dec_physical_details }}"
                                                            id="candidate_dec_physical_details"
                                                            style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="declaration_bankrupt" class=" control-label">3. Are you
                                                    currently undergoing long-term medical treatment?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="candidate_dec_lt_medical"
                                                                value="1"
                                                                {{ $candidate->candidate_dec_lt_medical == 1 ? 'checked' : '' }}>Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="candidate_dec_lt_medical"
                                                                value="0"
                                                                {{ $candidate->candidate_dec_lt_medical == 0 ? 'checked' : '' }}>No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control"
                                                            id="candidate_dec_lt_medical_details"
                                                            name="candidate_dec_lt_medical_details"
                                                            value="{{ $candidate->candidate_dec_lt_medical_details }}"
                                                            placeholder="If Yes, Please specify"
                                                            style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="declaration_bankrupt" class=" control-label">4. Have you
                                                    ever been convicted or found guilty of an offence in Court Of Law in
                                                    any country?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="candidate_dec_law"
                                                                value="1"
                                                                {{ $candidate->candidate_dec_law == 1 ? 'checked' : '' }}>Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="candidate_dec_law"
                                                                value="0"
                                                                {{ $candidate->candidate_dec_law == 0 ? 'checked' : '' }}>No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control"
                                                            id="candidate_dec_law_details"
                                                            name="candidate_dec_law_details"
                                                            value="{{ $candidate->candidate_dec_law_details }}"
                                                            placeholder="If Yes, Please specify"
                                                            style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="declaration_bankrupt" class=" control-label">5. Have you
                                                    ever been issued warning letters, suspended or dismissed from
                                                    employment before?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="candidate_dec_warning"
                                                                value="1"
                                                                {{ $candidate->candidate_dec_warning == 1 ? 'checked' : '' }}>Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="candidate_dec_warning"
                                                                value="0"
                                                                {{ $candidate->candidate_dec_warning == 0 ? 'checked' : '' }}>No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control"
                                                            id="candidate_dec_warning_details"
                                                            name="candidate_dec_warning_details"
                                                            value="{{ $candidate->candidate_dec_warning_details }}"
                                                            placeholder="If Yes, Please specify"
                                                            style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="declaration_bankrupt" class=" control-label">6. Have you
                                                    applied for any job with this company before?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="candidate_dec_applied"
                                                                value="1"
                                                                {{ $candidate->candidate_dec_applied == 1 ? 'checked' : '' }}>Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="candidate_dec_applied"
                                                                value="0"
                                                                {{ $candidate->candidate_dec_applied == 0 ? 'checked' : '' }}>No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control"
                                                            id="candidate_dec_applied_details"
                                                            name="candidate_dec_applied_details"
                                                            value="{{ $candidate->candidate_dec_applied_details }}"
                                                            placeholder="If Yes, Please specify">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-9 ms-3 mb-3">
                                        <div>
                                            <a href="{{ route('candidate.index') }}"
                                                class="btn btn-sm btn-secondary w-md">Back</a>
                                            <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                            <a href="#" class="btn btn-sm btn-warning w-md">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="terms_conditions" role="tabpanel">
                            <form action="{{ route('candidate.update', $candidate->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <h5 class="mb-5">Terms & Conditions</h5>
                                <div class="row">
                                    <div class="col-lg-11 m-auto">
                                        <h5>1. Temporary Placement</h5>
                                        <p><strong>A.</strong> Temporary candidates are required to serve 1 week notice
                                            to <strong>SUCCESS HUMAN RESOURCE CENTRE PTE LTD / SUCCESS RESOURCE CENTRE
                                                PTE LTD</strong> upon resignation, failing which salary in lieu of
                                            notice will be deducted (include OT claims).</p>
                                        <p><strong>B.</strong> All candidates shall not accept any employment offer
                                            directly from the client of <strong>SUCCESS HUMAN RESOURCE CENTRE PTE LTD /
                                                SUCCESS RESOURCE CENTRE PTE LTD</strong> within 1 year from the last
                                            working day of the assignment.</p>
                                        <h5>2. Permanent / Contract Placement</h5>
                                        <p>The candidates shall agree to commit themselves for a period of 2 months
                                            (excluding notice period) upon accepting the job offered by <strong>SUCCESS
                                                HUMAN RESOURCE CENTRE PTE LTD / SUCCESS RESOURCE CENTRE PTE LTD</strong>
                                            whether by writing or verbally, expressed or implied, failing which the
                                            candidates will have to compensate 30% of their offered salary to
                                            <strong>SUCCESS HUMAN RESOURCE CENTRE PTE LTD / SUCCESS RESOURCE CENTRE PTE
                                                LTD.</strong> This 30% compensation clause also applies to candidates
                                            who are terminated by our clients due to misconduct, poor performance or
                                            attendance, frequent medical leave, absence without calling or habitual late
                                            coming.
                                        </p>
                                        <p>All candidates shall not have any direct contact with the clients for a
                                            period of 1 year after an interview arranged by <strong>SUCCESS HUMAN
                                                RESOURCE CENTRE PTE LTD / SUCCESS RESOURCE CENTRE PTE LTD</strong>
                                            unless approval is granted by the Agency.</p>
                                        <p>I agree to all the Terms & Conditions of this employment and hereby declare
                                            that all the particulars given in this application is true, complete and
                                            accurate to the best of my knowledge and if this declaration is in any part
                                            false or incorrect, the Agency / Company will reserve the right to terminate
                                            my services instantly. </p>
                                        <p>I hereby authorize/consent <strong>SUCCESS HUMAN RESOURCE CENTRE PTE LTD /
                                                SUCCESS RESOURCE CENTRE PTE LTD</strong> to obtain and share all the
                                            information given in this application form/resume to any clients for job
                                            search purposes only. I understand and agree that all modes of communication
                                            (Call, SMS, Email and Fax) may be necessary to execute the job search. In
                                            order to opt out in the future, an email has to be submitted and
                                            acknowledged by <strong>SUCCESS HUMAN RESOURCE CENTRE PTE LTD / SUCCESS
                                                RESOURCE CENTRE PTE LTD</strong>, who will duly comply with the request,
                                            failing which, I will have no claim or recourse against the above-mentioned
                                            companies.</p>

                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Join
                                                    Date</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control"
                                                        name="candidate_joindate" placeholder="Join Date"
                                                        value="{{ $candidate->candidate_joindate }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-9 ms-3 mb-3">
                                        <div>
                                            <a href="{{ route('candidate.index') }}"
                                                class="btn btn-sm btn-secondary w-md">Back</a>
                                            <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                            <a href="#" class="btn btn-sm btn-warning w-md">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- Upload Resume tab --}}
                        <div class="tab-pane" id="upload_resume" role="tabpanel">
                            <div class="row">
                                @if (App\Helpers\FileHelper::usr()->can('candidate.resume'))
                                    <div class="col-lg-12">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Upload Resume</h4>
                                            <div class="text-end">
                                                <a data-bs-toggle="modal"
                                                    data-bs-target=".bs-example-modal-lg-create-resume"
                                                    class="btn btn-sm btn-info">Upload New Resume</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12 mt-2">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Main</th>
                                                <th>Upload By</th>
                                                <th>File Name</th>
                                                <th>Upload Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($candidate_resume as $resume)
                                                <tr>
                                                    <td>
                                                        {{ $loop->index + 1 }}
                                                    </td>
                                                    <td>
                                                        @if ($resume->isMain == 0)
                                                            <input type="radio" name="isMain"
                                                                {{ $resume->isMain == 1 ? 'checked' : '' }}
                                                                class="isMainRadio"
                                                                data-resume-id="{{ $resume->id }}"
                                                                data-candidate-id="{{ $candidate->id }}">
                                                        @else
                                                            <input type="radio" name="isMain"
                                                                {{ $resume->isMain == 1 ? 'checked' : '' }}>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $resume->modify_name->name }}
                                                    </td>
                                                    <td>
                                                        {{ $resume->resume_name }}
                                                    </td>
                                                    <td>
                                                        {{ $resume->updated_at }}
                                                    </td>
                                                    <td style="display: flex;">
                                                        <a href="{{ asset('storage') }}/{{ $resume->resume_file_path }}"
                                                            class="btn btn-info btn-sm me-3" download>Donwload</a>
                                                        @if (App\Helpers\FileHelper::usr()->can('candidate.resume.delete'))
                                                            <form
                                                                action="{{ route('candidate.resume.delete', [$resume->id, $resume->candidate_id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                                    type="submit">Delete</button>
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
                        <div class="tab-pane" id="upload_file" role="tabpanel">
                            <div class="row">
                                @if (App\Helpers\FileHelper::usr()->can('candidate.file.upload'))
                                    <div class="col-lg-12">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Upload File</h4>
                                            <div class="text-end">
                                                <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg-create"
                                                    class="btn btn-sm btn-info">Upload New File</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12 mt-2">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Upload By</th>
                                                <th>Document Type</th>
                                                <th>File Name</th>
                                                <th>Upload Date & Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($client_files as $file)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        @if ($file->created_by)
                                                            {{ \App\Models\Employee::where(['id' => $file->created_by])->pluck('employee_code')->first() }}
                                                        @else
                                                            User Not Found
                                                        @endif
                                                    </td>
                                                    <td>{{ $file->file_type->uploadfiletype_code }}</td>
                                                    <?php
                                                    $path = $file->file_path;
                                                    $parts = explode('/', $path);
                                                    $filename = end($parts);
                                                    $filenameParts = explode('_', $filename);
                                                    $cleanedFilename = end($filenameParts);
                                                    ?>
                                                    <td>{{ $cleanedFilename }}</td>
                                                    <td>{{ $file->created_at }}</td>
                                                    <td style="display: flex;">
                                                        <a href="{{ asset('storage') }}/{{ $file->file_path }}"
                                                            class="btn btn-info btn-sm me-3" download>Donwload</a>
                                                        @if (App\Helpers\FileHelper::usr()->can('candidate.file.delete'))
                                                            <form
                                                                action="{{ route('candidate.file.delete', ['id' => $file->id, 'candidate' => $file->client_id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                                    type="submit">Delete</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr class="mt-3">
                            </div>
                        </div>
                        <div class="tab-pane" id="remark" role="tabpanel">
                            {{-- <form action="{{ route('candidate.remark.update', $remark->id) }}" method="POST">
                                @csrf --}}
                                <div class="row">
                                    <h5>Update Remarks</h5>
                                    <p class="mb-0"><strong>Name:</strong> {{ $candidate->candidate_name }}</p>
                                    <p><strong>NRIC:</strong> {{ $candidate->candidate_nric }}</p>
                                    <div class="col-md-6 col-lg-6 mb-1">
                                        <div class="row">
                                            <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Remark Type</label>
                                            <div class="col-sm-9">
                                                <select name="remarkstype_id" class="form-control single-select-field"
                                                    disabled id="remark_type">
                                                    <option value="">Select One</option>
                                                    @if ($auth->roles_id == 1)
                                                        <option value="1"
                                                            {{ old('remarkstype_id', $remark->remarkstype_id) == 1 ? 'selected' : '' }}>
                                                            Assign To Manager</option>
                                                    @endif
                                                    @if ($auth->roles_id == 8)
                                                        <option value="11"
                                                            {{ old('remarkstype_id', $remark->remarkstype_id) == 11 ? 'selected' : '' }}>
                                                            Assign To Own</option>
                                                    @endif
                                                    @if ($auth->roles_id == 4 || $auth->roles_id == 11)
                                                        <option value="3"
                                                            {{ old('remarkstype_id', $remark->remarkstype_id) == 3 ? 'selected' : '' }}>
                                                            Assign To RC</option>
                                                    @endif
                                                    @if ($auth->roles_id == 4)
                                                        <option value="2"
                                                            {{ old('remarkstype_id', $remark->remarkstype_id) == 2 ? 'selected' : '' }}>
                                                            Assign To Team Leader</option>
                                                    @endif
                                                    @if ($auth->roles_id == 8 || $auth->roles_id == 11 || $auth->roles_id == 4)
                                                        <option value="9"
                                                            {{ old('remarkstype_id', $remark->remarkstype_id) == 9 ? 'selected' : '' }}>
                                                            Reassign</option>
                                                    @endif
                                                    @if ($auth->roles_id == 1 || $auth->roles_id == 4)
                                                        <option value="12"
                                                            {{ old('remarkstype_id', $remark->remarkstype_id) == 12 ? 'selected' : '' }}>
                                                            Share to Other Managers (Admin / Manager use only)</option>
                                                    @endif
                                                    <option value="4"
                                                        {{ old('remarkstype_id', $remark->remarkstype_id) == 4 ? 'selected' : '' }}>
                                                        Candidate Follow Up</option>
                                                    <option value="5"
                                                        {{ old('remarkstype_id', $remark->remarkstype_id) == 5 ? 'selected' : '' }}>
                                                        Assign Interview</option>
                                                    <option value="6"
                                                        {{ old('remarkstype_id', $remark->remarkstype_id) == 6 ? 'selected' : '' }}>
                                                        Assign To Client</option>
                                                    <option value="7"
                                                        {{ old('remarkstype_id', $remark->remarkstype_id) == 7 ? 'selected' : '' }}>
                                                        Shortlisted</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="AssignToClient" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Client
                                            </label>
                                            <div class="col-sm-9">
                                                <select name="assign_client_id" id="assign_client_id"
                                                    class="form-control single-select-field">
                                                <option value="">Choose One</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            {{ old('assign_client_id', $remark->assign_client?->client->id) == $client->id ? 'selected' : '' }}>
                                                            {{ $client->client_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="interviewTime" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Interview
                                                Time</label>
                                            <div class="col-sm-9">
                                                <input type="time" class="form-control" name="interview_time"
                                                    value="{{ old('interview_time', $remark->interview?->interview_time) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="interviewCompany"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Interview
                                                Company <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select name="interview_company" id="interview_company"
                                                    class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            {{ old('interview_company', $remark->interview?->interview_company) == $client->id ? 'selected' : '' }}>
                                                            {{ $client->client_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="expectedSalary"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Expected
                                                Salary</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    name="interview_expected_salary"
                                                    value="{{ old('interview_expected_salary', $remark->interview?->expected_salary) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="interviewPosition"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Interview
                                                Position <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="interview_position"
                                                    name="interview_position"
                                                    value="{{ old('interview_position', $remark->interview?->interview_position) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="receivedJobOffer"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Received
                                                Job Offer</label>
                                            <div class="col-sm-9">
                                                <select name="interview_received_job_offer"
                                                    class="form-control single-select-field">
                                                    <option value="pending"
                                                        {{ old('interview_received_job_offer', $remark->interview?->receive_job_offer) == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="yes"
                                                        {{ old('interview_received_job_offer', $remark->interview?->receive_job_offer) == 'yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="no"
                                                        {{ old('interview_received_job_offer', $remark->interview?->receive_job_offer) == 'no' ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="interview_id"
                                        value="{{ $remark->interview?->id }}">
                                    <input type="hidden" name="shortlist_id"
                                        value="{{ $remark->shortlist?->id }}">
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistClientCompany"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Client
                                                Company <span class="text-danger">*</span> </label>
                                            <div class="col-sm-9">
                                                <select name="client_company" id="shortlist_client_company"
                                                    class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            {{ old('client_company') == $client->id || ($remark && $remark->client_company == $client->id) ? 'selected' : '' }}>
                                                            {{ $client->client_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistDepartment"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one"
                                                class="col-sm-3 col-form-label fw-bold">Department</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    name="shortlistDepartment"
                                                    value="{{ old('shortlistDepartment', isset($remark->shortlist?->depertment) ? $remark->shortlist?->depertment : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistPlacement"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Placement
                                                / Recruitment Fee </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    name="shortlistPlacement"
                                                    value="{{ old('shortlistPlacement', isset($remark->shortlist?->placement_recruitment_fee) ? $remark->shortlist?->placement_recruitment_fee : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistJobTitle"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Job Title
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    name="shortlistJobTitle" id="shortlist_job_title"
                                                    value="{{ old('shortlistJobTitle', isset($remark->shortlist?->job_title) ? $remark->shortlist?->job_title : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistJobType"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Job Type
                                                <span class="text-danger">*</span> </label>
                                            <div class="col-sm-9">
                                                <select name="shortlistJobType" id="shortlist_job_type"
                                                    class="form-control single-select-field">
                                                    <option value="" >Select One</option>
                                                    @foreach ($job_types as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ old('shortlistJobType', $remark->shortlist?->job_type) == $type->id ? 'selected' : '' }}>
                                                            {{ $type->jobtype_code }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistProbationPeriod" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Probation
                                                Period</label>
                                            <div class="col-sm-9">
                                                <select name="shortlistProbationPeriod"
                                                    class="form-control single-select-field">
                                                    <option>Select One</option>
                                                    <option value="0"
                                                        {{ (old('shortlistProbationPeriod') ?? $remark->shortlist?->probition_period) == 0 ? 'selected' : '' }}>
                                                        No Probation</option>
                                                    <option value="1"
                                                        {{ (old('shortlistProbationPeriod') ?? $remark->shortlist?->probition_period) == 1 ? 'selected' : '' }}>
                                                        1 Month</option>
                                                    <option value="2"
                                                        {{ (old('shortlistProbationPeriod') ?? $remark->shortlist?->probition_period) == 2 ? 'selected' : '' }}>
                                                        2 Months</option>
                                                    <option value="3"
                                                        {{ (old('shortlistProbationPeriod') ?? $remark->shortlist?->probition_period) == 3 ? 'selected' : '' }}>
                                                        3 Months</option>
                                                    <option value="4"
                                                        {{ (old('shortlistProbationPeriod') ?? $remark->shortlist?->probition_period) == 4 ? 'selected' : '' }}>
                                                        4 Months</option>
                                                    <option value="5"
                                                        {{ (old('shortlistProbationPeriod') ?? $remark->shortlist?->probition_period) == 5 ? 'selected' : '' }}>
                                                        5 Months</option>
                                                    <option value="6"
                                                        {{ (old('shortlistProbationPeriod') ?? $remark->shortlist?->probition_period) == 6 ? 'selected' : '' }}>
                                                        6 Months</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistContractSigningDate"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Contract
                                                Signing
                                                Date <span class="text-danger"></span></label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control"
                                                    name="shortlistContractSigningDate"
                                                    value="{{ old('shortlistContractSigningDate', isset($remark->shortlist?->contact_signing_date) ? $remark->shortlist?->contact_signing_date : '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistEmailNoticeDate"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Email
                                                Notice Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control"
                                                    name="shortlistEmailNoticeDate"
                                                    value="{{ old('shortlistEmailNoticeDate', $remark->shortlist?->email_notice_date) ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="interviewEmailNoticeDate"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Email
                                                Notice Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control"
                                                    name="interviewEmailNoticeDate"
                                                    value="{{ old('interviewEmailNoticeDate', $remark->interview?->email_notice_date) ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1">
                                        <div class="row">
                                            <label for="one"
                                                class="col-sm-3 col-form-label fw-bold">Notice</label>
                                            <div class="col-sm-9">
                                                <select name="isNotice" class="form-control single-select-field"
                                                    required disabled>
                                                    <option value="" selected disabled>Select One</option>
                                                    <option value="1"
                                                        {{ old('isNotice') == 1 || $remark->isNotice ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ old('isNotice') == 0 || $remark->isNotice ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="AssignToManager"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Assign To
                                                <span class="text-danger">*</span> </label>
                                            <div class="col-sm-9">
                                                <select name="Assign_to_manager"
                                                    class="form-control single-select-field">
                                                    <option value="" disabled
                                                        {{ old('Assign_to_manager', $remark->assign_to) == '' ? 'selected' : '' }}>
                                                        Select One</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('Assign_to_manager', $remark->assign_to) == $user->id ? 'selected' : '' }}>
                                                            {{ $user->employee_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="reassign" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Assign To
                                                <span class="text-danger">*</span> </label>
                                            <div class="col-sm-9">
                                                <select name="Assign_to_manager_r"
                                                    class="form-control single-select-field">
                                                    <option value="" selected disabled>Select One</option>
                                                    @foreach (\App\Models\Employee::select('id', 'employee_name')->where('roles_id', '!=', 1)->get() as $user)
                                                        <option value="{{ $user->id }}" {{ old('Assign_to_manager') == $user->id || $candidate->Assign_to_manager == $user->id ? 'selected' : '' }}>
                                                            {{ $user->employee_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="clientArNo" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">AR
                                                No</label>
                                            <div class="col-sm-9">
                                                <select name="client_ar_no" id=""
                                                    class="form-control single-select-field">
                                                    <option value="0">Select On</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistSalary" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Salary
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="shortlistSalary" id="shortlist_salary" value="{{ old('shortlistSalary', $remark->shortlist?->salary) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistArNo" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">AR No</label>
                                            <div class="col-sm-9">
                                                <select name="shortlistArNo"
                                                    class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistHourlyRate" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Hourly
                                                Rate</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    name="shortlistHourlyRate" value="{{ old('shortlistHourlyRate') ?? $remark->shortlist?->hourly_rate }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistAdminFee" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Admin
                                                Fee</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    name="shortlistAdminFee" value="{{ old('shortlistAdminFee') ?? $remark->shortlist?->admin_fee }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistStartDate" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Start Date
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="shortlist_start_date"
                                                    name="shortlistStartDate"  value="{{ old('shortlistStartDate') ?? $remark->shortlist?->start_date }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistReminderPeriod" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Reminder
                                                Period <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <select name="shortlistReminderPeriod" id="shortlist_reminder_period"  class="form-control single-select-field">
                                                    <option value="1 Week Before" {{ $remark->shortlist?->reminder_period == '1 Week Before' ? 'selected' : '' }}>1 Week Before</option>
                                                    <option value="2 Week Before" {{ $remark->shortlist?->reminder_period == '1 Week Before' ? 'selected' : '' }}>2 Week Before</option>
                                                    <option value="3 Week Before" {{ $remark->shortlist?->reminder_period == '1 Week Before' ? 'selected' : '' }}>3 Week Before</option>
                                                    <option value="4 Week Before" {{ $remark->shortlist?->reminder_period == '1 Week Before' ? 'selected' : '' }}>4 Week Before</option>
                                                    <option value="5 Week Before" {{ $remark->shortlist?->reminder_period == '1 Week Before' ? 'selected' : '' }}>5 Week Before</option>
                                                    <option value="6 Week Before" {{ $remark->shortlist?->reminder_period == '1 Week Before' ? 'selected' : '' }}>6 Week Before</option>
                                                    <option value="7 Week Before" {{ $remark->shortlist?->reminder_period == '1 Week Before' ? 'selected' : '' }}>7 Week Before</option>
                                                    <option value="8 Week Before" {{ $remark->shortlist?->reminder_period == '1 Week Before' ? 'selected' : '' }}>8 Week Before</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistContractSigningTime"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Contract Signing Time <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="time" class="form-control" id="shortlist_contract_signing_time"
                                                    name="shortlistContractSigningTime" value="{{ old('shortlistContractSigningTime') ?? $remark->shortlist?->contact_signing_time }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistContractEndDate"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Contract End Time <span class="text-danger">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="shortlist_contract_end_date" name="shortlistContractEndDate" value="{{ old('shortlistContractEndDate') ?? $remark->shortlist?->end_date }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistLastDay" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Last
                                                Day</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control"
                                                    name="shortlistLastDay" value="{{ old('shortlistLastDay') ?? $remark->shortlist?->last_day }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="shortlistEmailNoticeTime"
                                        style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Email Notice Time</label>
                                            <div class="col-sm-9">
                                                <input type="time" class="form-control"
                                                    name="shortlistEmailNoticeTime"  value="{{ old('shortlistEmailNoticeTime') ?? $remark->shortlist?->email_notice_time }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="AssignToTeamLeader" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Assign To
                                                <span class="text-danger">*</span> </label>
                                            <div class="col-sm-9">
                                                <select name="team_leader" class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="AssignToRC" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Assign To
                                                <span class="text-danger">*</span> </label>
                                            <div class="col-sm-9">
                                                <select name="rc" class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="interviewDate" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Interview Date<span class="text-danger">*</span> </label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="interview_date" name="interview_date" value="{{ old('interview_date') ?? $remark->interview?->interview_date }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6  mb-1" id="interviewBy" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Interview
                                                By</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="interview_by" value="{{ old('interview_by') ?? $remark->interview?->interview_by }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="jobOfferSalary" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Jobs Offer
                                                Salary</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="inteview_job_offer_salary"
                                                    class="form-control" value="{{ old('inteview_job_offer_salary', $remark->interview?->job_offer_salary) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="attendInterview" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Attend
                                                Interview</label>
                                            <div class="col-sm-9">
                                                <select name="attendInterview"
                                                    class="form-control single-select-field">
                                                    <option>Choose one</option>
                                                    <option value="pending" {{ old('attendInterview', $remark->interview?->attend_interview) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="yes" {{ old('attendInterview', $remark->interview?->attend_interview) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ old('attendInterview', $remark->interview?->attend_interview) == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="availableDate" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Available
                                                Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="available_date" value="{{ old('available_date', $remark->interview?->available_date) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 mb-1" id="emailNoticeTime" style="display: none;">
                                        <div class="row">
                                            <label for="one" class="col-sm-3 col-form-label fw-bold">Email
                                                Notice
                                                Time</label>
                                            <div class="col-sm-9">
                                                <input type="time" name="interviewEmailNoticeTime"
                                                    class="form-control"  value="{{ old('interviewEmailNoticeTime') ?? $remark->shortlist?->email_notice_time }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <label for="remarks" class="col-sm-12 col-md-1 col-form-label fw-bold">Remark</label>
                                            <div class="col-sm-12 col-md-11">
                                                <div class="d-flex flex-row-reverse description_textarea">
                                                    <textarea name="remarks" id="ckeditor-classic" class="editor" rows="2"> {{ old('remarks', $remark->remarks ?? '') }} </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 mb-1">
                                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                                    </div> --}}
                                </div>
                            {{-- </form> --}}
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Assign</th>
                                                <th>Client</th>
                                                <th>Remarks Type</th>
                                                <th>Comments</th>
                                                <th>Created By</th>
                                                <th>Created Time</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($client_remarks as $remark)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $remark->assignTo?->employee_name }}</td>
                                                <td>{{ $remark->client?->client_name ?? $remark->assign_client?->client?->client_name  }}</td>
                                                <td>{{ $remark->remarksType->remarkstype_code }}</td>
                                                <td>{!! $remark->remarks !!}</td>
                                                <td>{{ $remark->Assign->name }}</td>
                                                <td>{{ $remark->created_at->format('H:i:s') }}
                                                </td>
                                                <td>{{ $remark->created_at->format('d-M-y') }}
                                                </td>
                                                <td style="display: flex;">
                                                    <a href="{{ route('candidates.edit.remark', ['candidate' => $candidate->id, 'remark' => $remark->id]) }}" class="btn btn-info btn-sm me-3 {{ Auth::user()->id == $remark->created_by ? '' : 'disabled' }}">Edit</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr class="mt-3">
                            </div>
                        </div>

                        <div class="tab-pane" id="payroll" role="tabpanel">
                            @if (App\Helpers\FileHelper::usr()->can('candidate.payroll'))
                                <h5>Create Payroll</h5>
                                <form action="{{ route('candidate.payroll', $candidate->id) }}" method="POST">
                                    @csrf
                                    <div class="row mb-5">
                                        <div class="col-lg-12">
                                            <label for="one" class="col-form-label"><b>Name :
                                                    {{ $candidate->candidate_name }}</b></label>
                                            <br>
                                            <label for="one" class="col-form-label"><b>NRIC:
                                                    {{ $candidate->candidate_nric }}</b></label>
                                        </div>
                                        <div class="col-lg-12 mt-5 mt-lg-4 mt-xl-0 row">
                                            <div class="row mb-4 col-lg-6">
                                                <input type="hidden" name="candidate_id"
                                                    value="{{ $candidate->id }}">
                                                <label for="one" class="col-sm-3 col-form-label">Job Type <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select name="job_type" class="form-control single-select-field"
                                                        id="jobTypes">
                                                        <option value="">Select One</option>
                                                        @foreach ($job_types as $job)
                                                            <option value="{{ $job->id }}">
                                                                {{ $job->jobtype_code }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="recruitmentFee">
                                                <label for="one" class="col-sm-3 col-form-label">Placement /
                                                    Recruitment Fee</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="recruitment_fee"
                                                        class="form-control"
                                                        placeholder="Placement / Recruitment Fee">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="adminFeeMonthly">
                                                <label for="one" class="col-sm-3 col-form-label">Admin Fee
                                                    (Monthly)</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="admin_fee_monthly"
                                                        class="form-control" placeholder="Admin Fee">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="adminFeeDaily">
                                                <label for="one" class="col-sm-3 col-form-label">Admin Fee
                                                    (Daily)</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="admin_fee_daily"
                                                        class="form-control" placeholder="Admin Fee (Daily)">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="clientCompany">
                                                <label for="one" class="col-sm-3 col-form-label">Client
                                                    Company<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <select name="client_company"
                                                        class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}"> {{ $client->client_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="arNo">
                                                <label for="one" class="col-sm-3 col-form-label">AR No.</label>
                                                <div class="col-sm-9">
                                                    <select name="ar_no" id=""
                                                        class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="invoiceRate">
                                                <label for="one" class="col-sm-3 col-form-label">Invoice
                                                    Rate</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="invoice_rate" class="form-control"
                                                        placeholder="Invoice Rate">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="salary">
                                                <label for="one" class="col-sm-3 col-form-label">Salary</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="salary" class="form-control"
                                                        placeholder="Salary">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="dailyRate">
                                                <label for="one" class="col-sm-3 col-form-label">Daily
                                                    Rate</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="daily_rate" class="form-control"
                                                        placeholder="Daily Rate">
                                                </div>
                                            </div>

                                            <div class="row mb-4 col-lg-6" id="dailyRateNightShift">
                                                <label for="one" class="col-sm-3 col-form-label">Daily Rate
                                                    (Night
                                                    Shift)</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="daily_rate_night_shift"
                                                        class="form-control" placeholder="Daily Rate (Night Shift)">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="jobTitle">
                                                <label for="one" class="col-sm-3 col-form-label">Job
                                                    Title <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="job_title" class="form-control"
                                                        placeholder="Job Title">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="programme">
                                                <label for="one"
                                                    class="col-sm-3 col-form-label">Programme</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="programme" class="form-control"
                                                        placeholder="Programme">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="department">
                                                <label for="one"
                                                    class="col-sm-3 col-form-label">Department</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="department" class="form-control"
                                                        placeholder="Department">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="hourlyRate">
                                                <label for="one" class="col-sm-3 col-form-label">Hourly
                                                    Rate</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="hourly_rate" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="wica">
                                                <label for="one" class="col-sm-3 col-form-label">WICA</label>
                                                <div class="col-sm-9">
                                                    <select name="wica" id=""
                                                        class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                        <option value="1">1</option>
                                                        <option value="0.3">0.3</option>
                                                        <option value="Fixed">Fixed</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="insuranceFee">
                                                <label for="one" class="col-sm-3 col-form-label">Insurance
                                                    Fee</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="insurance_fee"
                                                        class="form-control" placeholder="Insurance Fee">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="university">
                                                <label for="one"
                                                    class="col-sm-3 col-form-label">University</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="university" class="form-control"
                                                        placeholder="University">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="teamLead">
                                                <label for="one" class="col-sm-3 col-form-label">Team
                                                    Lead</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="team_lead" class="form-control"
                                                        placeholder="Team Lead">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="costCenter">
                                                <label for="one" class="col-sm-3 col-form-label">Cost
                                                    Centre</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="cost_center" class="form-control"
                                                        placeholder="Cost Centre">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="allowance">
                                                <label for="one"
                                                    class="col-sm-3 col-form-label">Allowance</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="allowance" class="form-control"
                                                        placeholder="Allowance">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="workingHour">
                                                <label for="one" class="col-sm-3 col-form-label">Working
                                                    Hour</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="working_hour" class="form-control"
                                                        placeholder="Working Hour">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="probationPeriod">
                                                <label for="one" class="col-sm-3 col-form-label">Probation
                                                    Period</label>
                                                <div class="col-sm-9">
                                                    <select name="probation_period" id=""
                                                        class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                        <option value="0">No Probation</option>
                                                        <option value="1">1 Month</option>
                                                        <option value="2">2 Month</option>
                                                        <option value="3">3 Month</option>
                                                        <option value="4">4 Month</option>
                                                        <option value="5">5 Month</option>
                                                        <option value="6">6 Month</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="startDate">
                                                <label for="one" class="col-sm-3 col-form-label">Start
                                                    Date <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="start_date" class="form-control"
                                                        placeholder="Start Date">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="endDate">
                                                <label for="one" class="col-sm-3 col-form-label">End
                                                    Date</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="end_date" class="form-control"
                                                        placeholder="End Date">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="salesPeriod">
                                                <label for="one" class="col-sm-3 col-form-label">Sales
                                                    Period</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="sales_period" class="form-control"
                                                        placeholder="Sales Period">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="guaranteePeriod">
                                                <label for="one" class="col-sm-3 col-form-label">Guarantee
                                                    Period</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="guarantee_period"
                                                        class="form-control" placeholder="Guarantee Period">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="invoiceNo">
                                                <label for="one" class="col-sm-3 col-form-label">Invoice
                                                    No.</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="invoice_no" class="form-control"
                                                        placeholder="Invoice No.">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="poNo">
                                                <label for="one" class="col-sm-3 col-form-label">PO No</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="po_no" class="form-control"
                                                        placeholder="PO No">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="charge">
                                                <label for="one" class="col-sm-3 col-form-label">Charge
                                                    (%)</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="charge" class="form-control"
                                                        placeholder="Charge (%)">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="contributeCpf">
                                                <label for="one" class="col-sm-3 col-form-label">Contribute
                                                    CPF</label>
                                                <div class="col-sm-9">
                                                    <select name="contribute_cpf" id=""
                                                        class="form-control single-select-field">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="closeBy1">
                                                <label for="one" class="col-sm-3 col-form-label">Closed By
                                                    1</label>
                                                <div class="col-sm-9">
                                                    <select name="close_by1" id=""
                                                        class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="closeRate1">
                                                <label for="one" class="col-sm-3 col-form-label">Closed Rate
                                                    1</label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="close_rate1" class="form-control"
                                                        placeholder="Closed Rate 1">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="closeBy2">
                                                <label for="one" class="col-sm-3 col-form-label">Closed By
                                                    2</label>
                                                <div class="col-sm-9">
                                                    <select name="close_by2" id=""
                                                        class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="closeRate2">
                                                <label for="one" class="col-sm-3 col-form-label">Closed Rate
                                                    2</label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="close_rate2" class="form-control"
                                                        placeholder="Closed Rate 2">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="closeBy3">
                                                <label for="one" class="col-sm-3 col-form-label">Closed By
                                                    3</label>
                                                <div class="col-sm-9">
                                                    <select name="close_by3" id=""
                                                        class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="closeRate3">
                                                <label for="one" class="col-sm-3 col-form-label">Closed Rate
                                                    3</label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="close_rate3" class="form-control"
                                                        placeholder="Closed Rate 3">
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="cutOff">
                                                <label for="one" class="col-sm-3 col-form-label">Cut
                                                    off</label>
                                                <div class="col-sm-9">
                                                    <select name="cut_off" id=""
                                                        class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4 col-lg-6" id="payrollRemark">
                                                <label for="one" class="col-sm-3 col-form-label">Payroll
                                                    Remarks</label>
                                                <div class="col-sm-9">
                                                    <textarea name="payroll_remark" rows="2" class="form-control" placeholder="PO Remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-sm btn-info mt-3">Save</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Salary</th>
                                                <th>Company</th>
                                                <th>Comments</th>
                                                <th>Create Time</th>
                                                <th>Create Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payrolls as $payroll)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }} </td>
                                                    <td>{{ $payroll->salary }} </td>
                                                    <td>{{ $payroll->company->client_name }} </td>
                                                    <td>{{ $payroll->payroll_remark }} </td>
                                                    <td>{{ $payroll->created_at->format('H:i:s') }}
                                                    </td>
                                                    <td>{{ $payroll->created_at->format('d-M-y') }}
                                                    </td>
                                                    <td>
                                                        @if (App\Helpers\FileHelper::usr()->can('candidate.payroll.delete'))
                                                            <form action="{{ route('candidate.payroll.delete', $payroll->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                                        type="submit">Delete</button>
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

                        <div class="tab-pane" id="working_hour" role="tabpanel">
                            <h5>Create Time Sheet</h5>
                            <form action="{{ route('candidate.working.hour', $candidate->id) }}" method="POST">
                                @csrf

                                <div class="row mb-5">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Time Sheet Type</label>
                                                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                                <div class="col-sm-9">
                                                    <select name="timesheet_id" id="sheet_type_id" class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                        @foreach ($time_sheet as $sheet)
                                                        <option value="{{ $sheet->id }}"
                                                        {{ $time?->timesheet_id == $sheet->id ? 'selected' : '' }}>
                                                        {{ $sheet->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Schedule Type</label>
                                                <div class="col-sm-9">
                                                    <select name="schedul_type" id="" class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                        <option value="Month End"
                                                        {{ $time?->schedul_type == 'Month End' ? 'selected' : '' }}>  Month End</option>
                                                        <option value="44 Hours"
                                                        {{ $time?->schedul_type == '44 Hours' ? 'selected' : '' }}> 44 Hours</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Schedule Day</label>
                                                <div class="col-sm-9">
                                                    <select name="schedul_day" id=""
                                                    class="form-control single-select-field">
                                                        <option value="">Select One</option>
                                                        @for ($i = 0; $i < 32; $i++)
                                                        <option value="{{ $i }}"
                                                        {{ $i == $time?->schedul_day ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Remarks</label>
                                                <div class="col-sm-9">
                                                    <textarea name="remarks" rows="2" class="form-control" placeholder="Remarks"> {{ $time?->remarks }} </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="mb-5">Days Setting</h5>
                                        <div class="form-group">
                                            <label style="width: 9%;" for="package_day" class="col-sm-1 control-label">Day</label>
                                            <label style="width: 25%;" for="package_day" class="col-sm-1 control-label">Time In</label>
                                            <label style="width: 25%;" for="package_day" class="col-sm-1 control-label">Time Out</label>
                                            <label style="width: 16%;" for="package_day" class="col-sm-1 control-label">Lunch Hour</label>
                                            <label style="width: 9%;" for="package_day" class="col-sm-1 control-label">Work</label>
                                                    <!-- Add labels for other days as needed -->
                                        </div>
                                        <div id="timeSheetEntries">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-sm btn-info mt-3">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade bs-example-modal-lg-create" tabindex="-1" role="dialog"  aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">Upload File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('candidate.file.upload', $candidate->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="file_type_for" value="1" class="form-control">
                                    <div class="mt-5 mt-lg-4 mt-xl-0">
                                        <div class="row mb-1">
                                            <label for="file_path" class="col-sm-3 col-form-label">Upload File</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="file_path" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="twente_four" class="col-sm-3 col-form-label">File Type</label>
                                            <div class="col-sm-9">
                                                <select name="file_type_id" class="form-control single-select-field">
                                                    <option value="">Select One</option>
                                                    @foreach ($fileTypes as $file)
                                                        <option value="{{ $file->id }}">
                                                        {{ $file->uploadfiletype_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <div class="modal fade bs-example-modal-lg-create-resume" tabindex="-1" role="dialog"  aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">Upload Resume</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('candidate.resume', $candidate->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}" class="form-control">
                                    <div class="mt-5 mt-lg-4 mt-xl-0">
                                        <div class="row mb-4">
                                            <label for="resume_name" class="col-sm-3 col-form-label">Resume Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="resume_name" class="form-control" value="{{ old('resume_name') }}">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="resume_file_path" class="col-sm-3 col-form-label">Upload File</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="resume_file_path" class="form-control">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div><!-- end card -->
        </div>
    </div>
    {{-- @include('admin.candidate.inc.timesheet') --}}
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    @include('admin.include.select2js')
    <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <!-- init js -->
    <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>

<script language="javascript" type="text/javascript">
if (window.location.hash) {
    var hash = window.location.hash;
    console.log(hash);
    document.querySelector('[href="' + hash + '"]').click();
}

window.addEventListener('DOMContentLoaded', (event) => {
    let remarkTab = document.querySelector('#remark-tab');
    if (remarkTab) {
        remarkTab.click();
    }
});

$(document).ready(function() {
    $('body').on('change', '#remark_type', function() {
        let selectedValue = $(this).val();

        if (selectedValue === '9') {
            $('#reassign').show();
        } else {
            $('#reassign').hide();
        }
        if (selectedValue === '12' || selectedValue === '1') {
            $('#AssignToManager').show();
        } else {
            $('#AssignToManager').hide();
        }

        if (selectedValue === '2') {
            $('#AssignToTeamLeader').show().css('display', 'show');
        } else {
            $('#AssignToTeamLeader').hide().css('display', 'none');
        }

        if (selectedValue === '3') {
            $('#AssignToRC').show().css('display', 'show');
        } else {
            $('#AssignToRC').hide().css('display', 'none');
        }

        if (selectedValue === '5') {
            $('#interviewTime').show().css('display', 'show');
            $('#interviewCompany').show().css('display', 'show');
            $('#interview_company').prop('required', true);
            $('#expectedSalary').show().css('display', 'show');
            $('#interviewPosition').show().css('display', 'show');
            $('#interview_position').prop('required', true);
            $('#receivedJobOffer').show().css('display', 'show');
            $('#emailNoticeDate').show().css('display', 'show');
            $('#interviewDate').show().css('display', 'show');
            $('#interview_date').prop('required', true);
            $('#interviewBy').show().css('display', 'show');
            $('#jobOfferSalary').show().css('display', 'show');
            $('#attendInterview').show().css('display', 'show');
            $('#availableDate').show().css('display', 'show');
            $('#interviewEmailNoticeDate').show().css('display', 'show');
        } else {
            $('#interviewTime').hide().css('display', 'none');
            $('#interviewCompany').hide().css('display', 'none');
            $('#interview_company').prop('required', false);
            $('#expectedSalary').hide().css('display', 'none');
            $('#interviewPosition').hide().css('display', 'none');
            $('#interview_position').prop('required', false);
            $('#receivedJobOffer').hide().css('display', 'none');
            $('#emailNoticeDate').hide().css('display', 'none');
            $('#interviewDate').hide().css('display', 'none');
            $('#interview_date').prop('required', false);
            $('#interviewBy').hide().css('display', 'none');
            $('#jobOfferSalary').hide().css('display', 'none');
            $('#attendInterview').hide().css('display', 'none');
            $('#availableDate').hide().css('display', 'none');
            $('#interviewEmailNoticeDate').hide().css('display', 'none');
        }

        if (selectedValue === '6') {
            $('#AssignToClient').show().css('display', 'show');
            $('#clientArNo').show().css('display', 'show');
            $('#assign_client_id').prop('required', true);
        } else {
            $('#AssignToClient').hide().css('display', 'none');
            $('#clientArNo').hide().css('display', 'none');
            $('#assign_client_id').prop('required', false);
        }

        if (selectedValue === '7') {
            $('#shortlistClientCompany').show().css('display', 'show');
            $('#shortlist_client_company').prop('required', true);
            $('#shortlistDepartment').show().css('display', 'show');
            $('#shortlistPlacement').show().css('display', 'show');
            $('#shortlistJobTitle').show().css('display', 'show');
            $('#shortlist_job_title').prop('required', true);
            $('#shortlistJobType').show().css('display', 'show');
            $('#shortlist_job_type').prop('required', true);
            $('#shortlistProbationPeriod').show().css('display', 'show');
            $('#shortlistContractSigningDate').show().css('display', 'show');
            $('#shortlistEmailNoticeDate').show().css('display', 'show');
            $('#shortlistSalary').show().css('display', 'show');
            $('#shortlist_salary').prop('required', true);
            $('#shortlistArNo').show().css('display', 'show');
            $('#shortlistHourlyRate').show().css('display', 'show');
            $('#shortlistAdminFee').show().css('display', 'show');
            $('#shortlistStartDate').show().css('display', 'show');
            $('#shortlist_start_date').prop('required', true);
            $('#shortlistReminderPeriod').show().css('display', 'show');
            $('#shortlist_reminder_period').prop('required', true);
            $('#shortlistContractSigningTime').show().css('display', 'show');
            $('#shortlist_contract_signing_time').prop('required', true);
            $('#shortlistLastDay').show().css('display', 'show');
            $('#shortlistEmailNoticeTime').show().css('display', 'show');
            $('#shortlistContractEndDate').show().css('display', 'show');
            $('#shortlist_contract_end_date').prop('required', true);
        } else {
            $('#shortlistClientCompany').hide().css('display', 'none');
            $('#shortlist_client_company').prop('required', false);
            $('#shortlistDepartment').hide().css('display', 'none');
            $('#shortlistPlacement').hide().css('display', 'none');
            $('#shortlistJobTitle').show().css('display', 'none');
            $('#shortlist_job_title').prop('required', false);
            $('#shortlistJobType').hide().css('display', 'none');
            $('#shortlist_job_type').prop('required', false);
            $('#shortlistProbationPeriod').hide().css('display', 'none');
            $('#shortlistContractSigningDate').hide().css('display', 'none');
            $('#shortlistEmailNoticeDate').hide().css('display', 'none');
            $('#shortlistSalary').hide().css('display', 'none');
            $('#shortlist_salary').prop('required', false);
            $('#shortlistArNo').hide().css('display', 'none');
            $('#shortlistHourlyRate').hide().css('display', 'none');
            $('#shortlistAdminFee').hide().css('display', 'none');
            $('#shortlistStartDate').hide().css('display', 'none');
            $('#shortlist_start_date').prop('required', false);
            $('#testone').hide().css('display', 'none');
            $('#shortlistReminderPeriod').hide().css('display', 'none');
            $('#shortlist_reminder_period').prop('required', false);
            $('#shortlistContractSigningTime').hide().css('display', 'none');
            $('#shortlist_contract_signing_time').prop('required', false);
            $('#shortlistLastDay').hide().css('display', 'none');
            $('#shortlistEmailNoticeTime').hide().css('display', 'none');
            $('#shortlistContractEndDate').hide().css('display', 'none');
            $('#shortlist_contract_end_date').prop('required', false);
        }

    });
    $('#remark_type').trigger();

    function loadTimeSheetDetails(timesheetId) {
        let html = '';

        $.ajax({
            url: '/ATS/time/sheet/details/' + timesheetId,
            method: 'GET',
            success: function(response) {
                let entries = response.entries;
                entries = JSON.parse(entries);

                Object.values(entries).forEach(entry => {
                    let isWorkChecked = entry.isWork === "1" ? 'checked' : '';
                    let inTime = entry.in_time ? entry.in_time.substring(0, 5) : '';
                    let outTime = entry.out_time ? entry.out_time.substring(0, 5) : '';
                    let lunch_time = entry.lunch_time;

                    html += `
                            <div class="form-group">
                                <div class="row mt-3">
                                    <label for="time_sheet_day" class="col-sm-1 control-label">${entry.day}</label>
                                    <div class="col-sm-3">
                                        <input type="time" class="form-control" name="${entry.day.toLowerCase()}_in" placeholder="Time In" value="${inTime}">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="time" class="form-control" name="${entry.day.toLowerCase()}_out" placeholder="Time Out" value="${outTime}">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control single-select-field" name="${entry.day.toLowerCase()}_lunch">
                                            <option value="30 minutes" ${lunch_time === '30 minutes' ? 'selected' : ''}>30 minutes</option>
                                            <option value="45 minutes" ${lunch_time === '45 minutes' ? 'selected' : ''}>45 minutes</option>
                                            <option value="1 hour" ${lunch_time === '1 hour' ? 'selected' : ''}>1 hour</option>
                                            <option value="1.5 hour" ${lunch_time === '1.5 hour' ? 'selected' : ''}>1.5 hour</option>
                                            <option value="2 hour" ${lunch_time === '2 hour' ? 'selected' : ''}>2 hour</option>
                                            <option value="No Lunch" ${lunch_time === 'No Lunch' ? 'selected' : ''}>No Lunch</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <label>
                                            <input type="checkbox" name="${entry.day.toLowerCase()}_isWork" ${isWorkChecked}>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        `;
                        });

                        $('#timeSheetEntries').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            loadTimeSheetDetails($('#sheet_type_id').val());

            $('#sheet_type_id').change(function() {
                let timesheetId = $(this).val();
                loadTimeSheetDetails(timesheetId);
            });
        });

        $(document).ready(function() {
            $('.isMainRadio').on('change', function() {
                var resumeId = $(this).data('resume-id');
                var candidateId = $(this).data('candidate-id');

                $.ajax({
                    type: 'POST',
                    url: '/ATS/candidate/resume/update/' + candidateId,
                    data: {
                        resumeId: resumeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.error('Ajax request failed:', error);
                    }
                });
            });
        });
    </script>
    @include('admin.candidate.inc.teamjs');
    <script src="{{ asset('build/js/ajax/candidateDeclaration.js') }}"></script>
    {{-- <script src="{{ asset('build/js/ajax/candidate/genaral.js') }}"></script> --}}
    <script src="{{ asset('build/js/ajax/candidateRemark.js') }}"></script>
    <script src="{{ asset('build/js/ajax/candidatePayroll.js') }}"></script>
    <script src="{{ asset('build/js/ajax/imagePreview.js') }}"></script>
    {{-- <script src="{{ asset('build/js/ajax/candidateTimeSheetGet.js') }}"></script> --}}
@endsection
