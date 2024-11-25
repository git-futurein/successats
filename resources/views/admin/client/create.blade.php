@extends('layouts.master')
@section('title')
    Create Client
@endsection
@section('page-title')
    Client Create
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />
    @include('admin.include.select2')
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex bd-highlight">
                                <div class="p-2 flex-grow-1 bd-highlight">
                                    <h6 class="card-title mb-0">Create New Client</h6>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <a href="{{ route('clients.index') }}" class="btn btn-sm btn-success">Search</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-3">
                            <!-- Nav tabs -->
                            <div class="row">
                                <div class="col-lg-1">
                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#General" role="tab">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">General</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @include('admin.include.errors')
                            <div class="tab-content text-muted">
                                <div class="tab-pane active mb-4" id="General" role="tabpanel">
                                    <div class="row">
                                        {{-- <div class="row col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label">Client
                                                Code <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_code" class="form-control"
                                                    placeholder="Client Code" value="{{ old('client_code') }}" required>
                                            </div>
                                        </div> --}}
                                        <div class="row col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label">Client
                                                Name <span class="text-danger">*</span> </label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_name" class="form-control"
                                                    placeholder="Client Name" value="{{ old('client_name') }}" required>
                                            </div>
                                        </div>

                                        <div class="row col-lg-6 mb-1">
                                            <label for="two" class="col-sm-5 col-form-label">Manager /
                                                Consultant (In Charge) <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <select name="employees_id" id="employees_id" class="form-control single-select-field" required>
                                                    <option value="">Choose One</option>
                                                    @foreach (\Spatie\Permission\Models\Role::select('id', 'name')->whereNotIn('id', [1])->get() as $role)
                                                        <option disabled class="bg-danger">{{$role->name}}</option>
                                                        @foreach (\App\Models\Employee::where('roles_id', $role->id)->get() as $incharge)
                                                            <option value="{{ $incharge->id }}" {{old('employees_id') == $incharge->id ? 'selected' : ''}}>{{ $incharge->employee_name }}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="three" class="col-sm-5 col-form-label">Payroll
                                                Person In Charge</label>
                                            <div class="col-sm-7">
                                                <select name="payroll_employees_id" class="form-control single-select-field">
                                                    <option value=""  selected disabled>Select One</option>
                                                    @foreach ($data['payrolls'] as $payroll)
                                                        <option value="{{ $payroll->id }}"
                                                            {{ old('payroll_employees_id') == $payroll->id ? 'selected' : '' }}>
                                                            {{ $payroll->employee_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="six" class="col-sm-5 col-form-label">Renewal
                                                TNC</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="tnc_renewal_date" class="form-control"
                                                    placeholder="Renewal Date" value="{{ old('tnc_renewal_date') }}">
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="seven" class="col-sm-5 col-form-label">Industry /Job
                                                category
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <select name="industry_types_id" class="form-control single-select-field" required>
                                                    <option value="" disabled selected>Select One</option>
                                                    @foreach ($data['job_categories'] as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('industry_types_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->jobcategory_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row col-lg-6 mb-1">
                                            <label for="nine" class="col-sm-5 col-form-label">TNC Template
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <select name="tnc_templates_id" class="form-control single-select-field" required>
                                                    <option value=""  disabled selected>Select One</option>
                                                    @foreach ($data['tncs'] as $tnc)
                                                        <option value="{{ $tnc->id }}"
                                                            {{ old('tnc_templates_id') == $tnc->id ? 'selected' : '' }}>
                                                            {{ $tnc->tnc_template_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="client_terms_id" class="col-sm-5 col-form-label">Terms
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="client_terms_id" class="form-control single-select-field"
                                                    id="client_terms_id" placeholder="">
                                                    <option value=""  disabled selected>Select One</option>
                                                    @foreach ($data['client_terms'] as $term)
                                                        <option value="{{ $term->id }}"
                                                            {{ old('client_terms_id') == $term->id ? 'selected' : '' }}>
                                                            {{ $term->client_term_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label">Remark</label>
                                            <div class="col-sm-7">
                                                <textarea name="client_remarks" rows="2" class="form-control" placeholder="Remark">{{ old('client_remarks') }} </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h5>Address Information</h5>
                                    <div class="row col-lg-6  mb-1">
                                        <label for="eleven" class="col-sm-5 col-form-label">Attention
                                            Person</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="client_attention_person" class="form-control"
                                                placeholder="Attention Person"
                                                value="{{ old('client_attention_person') }}">
                                        </div>
                                    </div>
                                    <div class="row col-lg-6 mb-1">
                                        <label for="twelve" class="col-sm-5 col-form-label">Contact
                                            Person <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" name="client_contact_person" class="form-control"
                                                placeholder="Contact Person" value="{{ old('client_contact_person') }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row col-lg-6 mb-1">
                                        <label for="thirteen" class="col-sm-5 col-form-label">Contact Number <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <select class="form-control" id="country_code" name="country_code">
                                                        <option value="+65">+65</option>
                                                        <option value="+60">+60</option>
                                                    </select>
                                                </div>
                                                <input type="text" name="client_contact_number" class="form-control" placeholder="Contact Number" value="{{ old('client_contact_number') }}" required maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-6  mb-1">
                                        <label for="fourteen" class="col-sm-5 col-form-label">Fax</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="client_fax" class="form-control"
                                                placeholder="Fax" value="{{ old('client_fax') }}">
                                        </div>
                                    </div>
                                    <div class="row col-lg-6  mb-1">
                                        <label for="fifteen" class="col-sm-5 col-form-label">Postal
                                            Code</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="client_postal_code" class="form-control"
                                                placeholder="Postal Code" value="{{ old('client_postal_code') }}">
                                        </div>
                                    </div>
                                    <div class="row col-lg-6  mb-1">
                                        <label for="seventeen" class="col-sm-5 col-form-label">Attention
                                            Designation</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="client_attention_designation"
                                                class="form-control" placeholder="Attention Designation"
                                                value="{{ old('client_attention_designation') }}">
                                        </div>
                                    </div>
                                    <div class="row col-lg-6 mb-1">
                                        <label for="nineteen" class="col-sm-5 col-form-label">Phone Number</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <select class="form-control" id="client_country_code" name="client_country_code">
                                                        <option value="+65">+65</option>
                                                        <option value="+60">+60</option>
                                                    </select>
                                                </div>
                                                <input type="text" name="client_phone" class="form-control" placeholder="Phone Number" value="{{ old('client_phone') }}" axlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-6  mb-1">
                                        <label for="twenteen" class="col-sm-5 col-form-label">Email</label>
                                        <div class="col-sm-7">
                                            <input type="email" name="client_email" class="form-control"
                                                placeholder="Email" value="{{ old('client_email') }}">
                                        </div>
                                    </div>
                                    <div class="row col-lg-6  mb-1">
                                        <label for="twente_one" class="col-sm-5 col-form-label">Unit
                                            No</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="client_unit_number" class="form-control"
                                                placeholder="Unit No" value="{{ old('client_unit_number') }}">
                                        </div>
                                    </div>
                                    <div class="row col-lg-6  mb-1">
                                        <label for="twente_two" class="col-sm-5 col-form-label">Web
                                            Site</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="client_website"
                                                placeholder="Web Site" value="{{ old('client_website') }}">
                                        </div>
                                    </div>
                                    <div class="row col-lg-6  mb-1">
                                        <label for="sixteen" class="col-sm-5 col-form-label">Street</label>
                                        <div class="col-sm-7">
                                            <textarea name="client_street" rows="2" class="form-control" placeholder="Address">{{ old('client_street') }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 ms-1">
                            <div class="col-sm-9">
                                <div>
                                    <a href="{{ route('clients.index') }}"
                                        class="btn btn-sm btn-secondary w-md">Cancel</a>
                                    <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                    <a href="#" class="btn btn-sm btn-primary w-md">Print TNC SRC</a>
                                    <a href="#" class="btn btn-sm btn-primary w-md">Print TNC SHRC</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- end card-body -->
        </div>
        </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        @include('admin.include.select2js')
        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
    @endsection
