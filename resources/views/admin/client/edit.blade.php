@extends('layouts.master')
@section('title')
    Edit Client
@endsection
@section('css')
    <!-- quill css -->
    <link href="{{ URL::asset('build/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
        @include('admin.include.select2')
@endsection
@section('page-title')
    Client Edit
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
                                <h6 class="card-title mb-0">Edit Client</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('clients.create') }}" class="btn btn-sm btn-success">Create New</a>
                                <a href="{{ route('clients.index') }}" class="btn btn-sm btn-success">Search</a>
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
                        <!-- Nav tabs -->
                        <div class="row">
                            <div class="col-lg-8">
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#General" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">General</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#upload_file" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Upload File</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#follow_up" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Follow Up</span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#department" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Department</span>
                                        </a>
                                    </li> --}}
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#supervisor" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Supervisor</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="General" role="tabpanel">
                                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row mb-4">
                                        <div class="row col-lg-6 mb-1">
                                            <label for="one" class="col-sm-5 col-form-label fw-bold">Client
                                                Name <span class="text-danger">*</span> </label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $client->client_name) }}" required>
                                            </div>
                                        </div>

                                        <div class="row col-lg-6 mb-1">
                                            <label for="two" class="col-sm-5 col-form-label fw-bold">Manager / Consultant (In Charge) <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <select name="employees_id" id="employees_id" class="form-control single-select-field" required>
                                                    @foreach (\Spatie\Permission\Models\Role::select('id', 'name')->whereNotIn('id', [1])->get() as $role)
                                                        <option disabled><strong>{{$role->name}}</strong></option>
                                                        @foreach (\App\Models\Employee::where('roles_id', $role->id)->get() as $incharge)
                                                            <option value="{{ $incharge->id }}">
                                                                {{ $incharge->employee_name }}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="three" class="col-sm-5 col-form-label fw-bold">Payroll
                                                Person In Charge</label>
                                            <div class="col-sm-7">
                                                <select name="payroll_employees_id" class="form-control single-select-field">
                                                    <option value="" selected disabled>Select One</option>
                                                    @foreach ($data['payrolls'] as $payroll)
                                                        <option value="{{ $payroll->id }}"
                                                            {{ $client->payroll_employees_id == $payroll->id ? 'selected' : '' }}>
                                                            {{ $payroll->employee_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="six" class="col-sm-5 col-form-label fw-bold">Renewal
                                                TNC</label>
                                            <div class="col-sm-7">
                                                <input type="date" name="tnc_renewal_date" class="form-control"
                                                    placeholder="Renewal Date" value="{{ $client->tnc_renewal_date }}">
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="seven" class="col-sm-5 col-form-label fw-bold">Industry /Job
                                                category
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <select name="industry_types_id" class="form-control single-select-field" required
                                                    data-trigger>
                                                    <option value=""  disabled selected>Select One</option>
                                                    @foreach ($data['job_categories'] as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $client->industry_types_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->jobcategory_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="nine" class="col-sm-5 col-form-label fw-bold">TNC Template
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <select name="tnc_templates_id" class="form-control single-select-field" required
                                                    data-trigger>
                                                    <option value=""  disabled selected>Select One</option>
                                                    @foreach ($data['tncs'] as $tnc)
                                                        <option value="{{ $tnc->id }}"
                                                            {{ $client->tnc_templates_id == $tnc->id ? 'selected' : '' }}>
                                                            {{ $tnc->tnc_template_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="client_terms_id" class="col-sm-5 col-form-label fw-bold">Terms
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="client_terms_id" class="form-control single-select-field"
                                                    id="client_terms_id" placeholder="">
                                                    <option value=""  disabled selected>Select One</option>
                                                    @foreach ($data['client_terms'] as $term)
                                                        <option value="{{ $term->id }}"
                                                            {{ $client->client_terms_id == $term->id ? 'selected' : '' }}>
                                                            {{ $term->client_term_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="four" class="col-sm-5 col-form-label fw-bold">Remark</label>
                                            <div class="col-sm-7">
                                                <textarea name="client_remarks" rows="2" class="form-control" placeholder="Remark">{{ $client->client_remarks }} </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <h5>Address Information</h5>
                                        <div class="row col-lg-6  mb-1">
                                            <label for="eleven" class="col-sm-5 col-form-label fw-bold">Attention
                                                Person</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_attention_person" class="form-control"
                                                    placeholder="Attention Person"
                                                    value="{{ $client->client_attention_person }}">
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-1">
                                            <label for="twelve" class="col-sm-5 col-form-label fw-bold">Contact
                                                Person <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_contact_person" class="form-control"
                                                    placeholder="Contact Person"
                                                    value="{{ $client->client_contact_person }}" required>
                                            </div>
                                        </div>
                                        @php
                                            $client_contact_number = $client->client_contact_number;
                                            $country_code = substr($client_contact_number, 0, 3);
                                            $phone_number = substr($client_contact_number, 4);
                                        @endphp
                                        <div class="row col-lg-6 mb-1">
                                            <label for="thirteen" class="col-sm-5 col-form-label fw-bold">Contact @php
                                            $client_contact_number = $client->client_contact_number;
                                            $country_code = substr($client_contact_number, 0, 3);
                                            $phone_number = substr($client_contact_number, 4);
                                        @endphp <span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <select class="form-control" id="country_code" name="country_code">
                                                            <option value="+65" {{$country_code == '+65' ? 'selected' : ''}}>+65</option>
                                                            <option value="+60"  {{$country_code == '+60' ? 'selected' : ''}}>+60</option>
                                                        </select>
                                                    </div>
                                                    <input type="text" name="client_contact_number" class="form-control" placeholder="Contact Number" value="{{ old('client_contact_number', $phone_number) }}" required maxlength="10">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-1">
                                            <label for="fourteen" class="col-sm-5 col-form-label fw-bold">Fax</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_fax" class="form-control"
                                                    placeholder="Fax" value="{{ $client->client_fax }}">
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-1">
                                            <label for="fifteen" class="col-sm-5 col-form-label fw-bold">Postal
                                                Code</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_postal_code" class="form-control"
                                                    placeholder="Postal Code" value="{{ $client->client_postal_code }}">
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-1">
                                            <label for="seventeen" class="col-sm-5 col-form-label fw-bold">Attention
                                                Designation</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_attention_designation"
                                                    class="form-control" value="{{ $client->client_attention_designation }}">
                                            </div>
                                        </div>
                                        @php
                                            $client_phone = $client->client_phone;
                                            $client_country_code = substr($client_phone, 0, 3);
                                            $client_phone_n = substr($client_phone, 4);
                                        @endphp
                                        <div class="row col-lg-6  mb-1">
                                            <label for="nineteen" class="col-sm-5 col-form-label fw-bold">Phone Number</label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <select class="form-control" id="client_country_code" name="client_country_code">
                                                            <option value="+65" {{$client_country_code == '+65' ? 'selected' : ''}}>+65</option>
                                                            <option value="+60" {{$client_country_code == '+60' ? 'selected' : ''}}>+60</option>
                                                        </select>
                                                    </div>
                                                    <input type="text" name="client_phone" class="form-control" placeholder="Phone Number" value="{{ old('client_phone', $client_phone_n) }}" axlength="10">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-1">
                                            <label for="twenteen" class="col-sm-5 col-form-label fw-bold">Email</label>
                                            <div class="col-sm-7">
                                                <input type="email" name="client_email" class="form-control"
                                                    placeholder="Email" value="{{ $client->client_email }}">
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-1">
                                            <label for="twente_one" class="col-sm-5 col-form-label fw-bold">Unit
                                                No</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="client_unit_number" class="form-control"
                                                    placeholder="Unit No" value="{{ $client->client_unit_number }}">
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-1">
                                            <label for="twente_two" class="col-sm-5 col-form-label fw-bold">Web
                                                Site</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="client_website"
                                                    placeholder="Web Site" value="{{ $client->client_website }}">
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-1">
                                            <label for="sixteen" class="col-sm-5 col-form-label fw-bold">Street</label>
                                            <div class="col-sm-7">
                                                <textarea name="client_street" rows="2" class="form-control" placeholder="Address">{{ $client->client_street }} </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div>
                                                <a href="#" class="btn btn-sm btn-secondary w-md">Cancel</a>
                                                <button type="submit" class="btn btn-sm btn-info w-md">Submit</button>
                                                <a href="{{ route('client.tnctemplate.download', $client->id) }}" target="__blank"  class="btn btn-sm btn-primary w-md">Print TNC SRC</a>
                                                <a href="#" class="btn btn-sm btn-primary w-md">Print TNC SHRC</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="upload_file" role="tabpanel">
                                <div class="row">
                                    @if (App\Helpers\FileHelper::usr()->can('client.file.upload'))
                                        <div class="col-lg-12">
                                            <form action="{{ route('client.file.upload', $client->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" value="0" name="file_type_for">
                                                <div class="mt-5 mt-lg-4 mt-xl-0">
                                                    <div class="row mb-1">
                                                        <label for="file_path" class="col-sm-3 col-form-label">Upload File (<small class="text-danger">Pdf only</small>)</label>
                                                        <div class="col-sm-9">
                                                            <input type="file" name="file_path" class="form-control"
                                                                value="{{ old('file_path') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <label for="twente_four" class="col-sm-3 col-form-label">File Type</label>
                                                        <div class="col-sm-9">
                                                            <select name="file_type_id" id="" class="form-control single-select-field">
                                                                <option value="">Choose One</option>
                                                                @foreach ($data['fileTypes'] as $file)
                                                                    <option value="{{ old('file_type_id', $file->id) }}">
                                                                        {{ $file->uploadfiletype_code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                                                </div>
                                            </form>
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
                                                @foreach($data['client_files'] as $file)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>
                                                            @if ($file->created_by)
                                                                {{ \App\Models\Employee::where(['user_table_id' => $file->created_by])->pluck('employee_code')->first() }}
                                                            @else
                                                                User Not Found
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $file->file_type->uploadfiletype_code }}
                                                        </td>
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
                                                            @if (App\Helpers\FileHelper::usr()->can('client.file.delete'))
                                                                <form
                                                                    action="{{ route('client.file.delete', $file->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="file_delete"
                                                                        value="{{ $client->id }}">
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
                            <div class="tab-pane" id="follow_up" role="tabpanel">
                                <div class="row" id="follow_upeditClient">
                                    @if (App\Helpers\FileHelper::usr()->can('client.followup'))
                                        <div class="col-lg-12">
                                            <h5>Create Follow Up</h5>
                                            <form action="{{ route('client.followup', $client->id) }}" method="POST">
                                                @csrf

                                                <div class="row mb-4">
                                                    <label for="twente_four"
                                                        class="col-sm-2 col-form-label">Description</label>
                                                    <div class="col-sm-8">
                                                        <input type="hidden" name="clients_id"
                                                            value="{{ $client->id }}">
                                                        <textarea name="description" id="ckeditor-classic" rows="2">{{ old('description') }} </textarea>
                                                    </div>
                                                    <div class="col-sm-2"></div>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-info mt-2">Save</button>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="col-lg-12 mt-2">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Create By</th>
                                                    <th>Description</th>
                                                    <th>Create Date & Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['client_followup'] as $file)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>
                                                            @if ($file->created_by)
                                                                {{ \App\Models\Employee::where(['user_table_id' => $file->created_by])->pluck('employee_code')->first() }}
                                                            @else
                                                                User Not Found
                                                            @endif
                                                        </td>
                                                        <td>{!! $file->description !!}</td>
                                                        <td>{{ Carbon\Carbon::parse($file->created_at)->format('h:i a j M Y') }}
                                                        </td>
                                                        <td style="display: flex;">
                                                            <button class="btn btn-info btn-sm me-2"
                                                                onclick="editClient({{ $file->clients_id }}, {{ $file->id }}, '{{ $file->description }}')"
                                                                type="button">Show</button>

                                                            @if (App\Helpers\FileHelper::usr()->can('client.followup.delete'))
                                                                <form
                                                                    action="{{ route('client.followup.delete', $file->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <input type="hidden" name="followup_delete"
                                                                        value="{{ $client->id }}">
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

                            <div class="tab-pane" id="department" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('client.department.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="client_id" value="{{ $client->id }}">

                                                <div class="row mb-1">
                                                    <div class="row col-12 mb-1">
                                                        <label for="twente_four"
                                                            class="col-sm-3 col-form-label">Department Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="name" class="form-control"
                                                                placeholder="Department name">
                                                        </div>
                                                    </div>
                                                    <div class="row col-12 mb-1">
                                                        <label for="twente_four"
                                                            class="col-sm-3 col-form-label">Remarks</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="remarks" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-info">Save</button>

                                        </form>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Department</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['departments'] as $department)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{{ $department->name }}</td>
                                                        <td>{{ $department->remarks }}</td>
                                                        <td style="display: flex;">
                                                            <form
                                                                action="{{ route('client.department.delete', $department->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="department_delete"
                                                                    value="{{ $client->id }}">
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                                    type="submit">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr class="mt-3">
                                </div>
                            </div>
                            <div class="tab-pane" id="supervisor" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('client.supervisor.store', $client->id) }}"
                                            method="POST">
                                            @csrf

                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 d-flex mb-1">
                                                    <label for="twente_four" class="col-sm-3 col-form-label">Name <strong
                                                            class="text-danger">*</strong></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 d-flex mb-1">
                                                    <label for="twente_four" class="col-sm-3 col-form-label">Mobile
                                                        <strong class="text-danger">*</strong></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="mobile" class="form-control"
                                                            placeholder="Mobile">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 d-flex mb-1">
                                                    <label for="twente_four" class="col-sm-3 col-form-label">Email <strong
                                                            class="text-danger">*</strong></label>
                                                    <div class="col-sm-9">
                                                        <input type="email" name="email" class="form-control"
                                                            placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 d-flex mb-1">
                                                    <label for="twente_four"
                                                        class="col-sm-3 col-form-label">Department</label>
                                                    <div class="col-sm-9">
                                                        <select name="department" class="form-control single-select-field" required>
                                                            <option value="">Select One</option>
                                                            @foreach ($data['departments'] as $department)
                                                                <option value="{{ $department->id }}">
                                                                    {{ $department->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 d-flex mb-1">
                                                    <label for="twente_four" class="col-sm-3 col-form-label">Direct Number
                                                        (DID)</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="direct_number" class="form-control"
                                                            placeholder="Direct Number (DID)">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 d-flex mb-1">

                                                </div>
                                                <div class="col-sm-12 col-md-6 d-flex mb-1">
                                                    <label for="twente_four"
                                                        class="col-sm-3 col-form-label">Remark</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="remark" cols="30" rows="2" placeholder="remark" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 d-flex mb-1">
                                                    <label for="twente_four"
                                                        class="col-sm-3 col-form-label">Defination</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="defination" cols="30" rows="2" placeholder="Defination" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="mt-3">Login Information</h4>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-8 d-flex mt-1">
                                                    <label for="twente_four" class="col-sm-3 col-form-label">Login ID
                                                        <strong class="text-danger">*</strong></label>
                                                    <div class="col-sm-9">
                                                        <input type="email" name="log_email" class="form-control"
                                                            placeholder="Login Email" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-8 d-flex mt-1">
                                                    <label for="twente_four" class="col-sm-3 col-form-label">Password
                                                        <strong class="text-danger">*</strong></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" name="password" class="form-control"
                                                            placeholder="Password" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-8 d-flex mt-1">
                                                    <label for="twente_four" class="col-sm-3 col-form-label">Confirm
                                                        Password <strong class="text-danger">*</strong></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control" placeholder="Confirm Password" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-info my-3">Save</button>
                                    </div>
                                    </form>
                                    <div class="col-lg-12 mt-2">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Department</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($client->supervisors as $supervisor)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{{ $supervisor->name }}</td>
                                                        <td>{{ $supervisor->email }}</td>
                                                        <td>{{ $supervisor->mobile }}</td>
                                                        <td>{{ $supervisor->department_name->name }}</td>
                                                        <td style="display: flex;">
                                                            <form
                                                                action="{{ route('client.supervisor.delete', $supervisor->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                                                    type="submit">
                                                                    Delete
                                                                </button>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr class="mt-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        @include('admin.include.select2js')
        <!-- ckeditor -->
        <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>
        <script>
            function editClient(clients_id, id, description) {
                var formAction = "{{ route('client.followup.update', '') }}";
                formAction = formAction + '/' + id;

                console.log(formAction);
                $('#follow_upeditClient').html('');
                $('#follow_upeditClient').html('<div class="col-lg-12">\
                                                    <h5>Edit Follow Up</h5>\
                                                    <form action="' + formAction +'" method="POST">\
                                                         @csrf\
                                                        <div class="row mb-4">\
                                                            <label for="twente_four" class="col-sm-2 col-form-label fw-bold">Description</label>\
                                                            <div class="col-sm-8">\
                                                                <input type="hidden" name="clients_id" value="' + clients_id + '">\
                                                                <div id="ckeditor-container-' + id + '"></div>\
                                                                <input type="hidden" name="description">\
                                                            </div>\
                                                            <div class="col-sm-2"></div>\
                                                        </div>\
                                                        <button type="submit" class="btn btn-sm btn-info mt-2">Update</button>\
                                                   </form>\
                                                </div>');

                // Dynamically initialize CKEditor for the added textarea
                ClassicEditor
                    .create(document.querySelector('#ckeditor-container-' + id))
                    .then(editor => {
                        editor.setData(description);

                        // Update the hidden input with CKEditor content before form submission
                        $('form').submit(function() {
                            $('input[name="description"]').val(editor.getData());
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }

            // function editClient(clients_id, id, description) {
            //    var formAction = "{{ route('client.followup.update', '') }}";
            //     formAction = formAction + '/' + id;

            //     console.log(formAction);
            //     $('#follow_upeditClient').html('');
            //     $('#follow_upeditClient').html('<div class="col-lg-12">\
            //         <h5>Edit Follow Up</h5>\
            //         <form action="' + formAction + '" method="POST">\
            //             @csrf\
            //             <div class="row mb-4">\
            //                 <label for="twente_four" class="col-sm-2 col-form-label">Description</label>\
            //                 <div class="col-sm-8">\
            //                     <input type="hidden" name="clients_id" value="' + clients_id + '">\
            //                     <div id="ckeditor-container-' + id + '"></div>\
            //                 </div>\
            //                 <div class="col-sm-2"></div>\
            //             </div>\
            //             <button type="submit" class="btn btn-sm btn-info mt-2">Update</button>\
            //         </form>\
            //     </div>');

            //     // Dynamically initialize CKEditor for the added textarea
            //     ClassicEditor
            //         .create(document.querySelector('#ckeditor-container-' + id))
            //         .then(editor => {
            //             editor.setData(description);
            //         })
            //         .catch(error => {
            //             console.error(error);
            //         });
            // }
        </script>


        <script language="javascript" type="text/javascript">
            if (window.location.hash) { // Check if url hash is not empty
                var hash = window.location.hash; // nav-y1
                document.querySelector('[href="' + hash + '"]').click();
            }
        </script>
    @endsection
