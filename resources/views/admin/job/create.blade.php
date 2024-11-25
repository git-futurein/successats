@extends('layouts.master')
@section('title')
    Job Posting
@endsection
@section('page-title')
    Job Posting Management
@endsection
@section('body')
    <body>
    @endsection
    @section('css')
        <!-- quill css -->
        <link href="{{ URL::asset('build/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
        @include('admin.include.select2')
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6 class="card-title mb-0">Create Job Posting</h6>
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
                        <form action="{{ route('job.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="job_title" class="col-sm-5 col-form-label fw-bold">Job Title <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" id="job_title" class="form-control" placeholder="Job Title" name="job_title" value="{{ old('job_title') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="client_id" class="col-sm-5 col-form-label fw-bold">Client <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <select id="client_id" name="client_id" class="form-control single-select-field" required>
                                                <option value="" selected disabled>Select One</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}" {{old('client_id') == $client->id }}>{{ $client->client_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="job_category_id" class="col-sm-5 col-form-label fw-bold">Job Category <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <select name="job_category_id" id="job_category_id" class="form-control single-select-field" required>
                                                <option value="" selected disabled>Select One</option>
                                                @foreach ($jobCategory as $category)
                                                    <option value="{{ $category->id }}" {{old('job_category_id') == $category->id }}> {{ $category->jobcategory_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="person_incharge" class="col-sm-5 col-form-label fw-bold">Person In Charge <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <select name="person_incharge" class="form-control single-select-field" required id="person_incharge">
                                                <option value=""> Choose One</option>
                                                @foreach($incharges as $incharge)
                                                    <option value="{{ $incharge->id }}" {{ old('person_incharge', $incharge->id) == Auth::user()->employe->id ? 'selected' : '' }}>
                                                        {{ $incharge->employee_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="co_owner_id" class="col-sm-5 col-form-label fw-bold">Co Owner</label>
                                        <div class="col-sm-7">
                                            <select name="co_owner_id" class="form-control single-select-field" required id="co_owner_id">
                                                <option value=""> Choose One</option>
                                                @foreach($incharges as $incharge)
                                                    <option value="{{ $incharge->id }}" {{ old('co_owner_id', $incharge->id) == Auth::user()->employe->id ? 'selected' : '' }}>
                                                        {{ $incharge->employee_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="job_salary" class="col-sm-5 col-form-label fw-bold">Job Salary <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" placeholder="Job Salary" value="{{ old('job_salary') }}" name="job_salary" id="job_salary" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="job_type_id" class="col-sm-5 col-form-label fw-bold">Job Type <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <select id="job_type_id" name="job_type_id" class="form-control single-select-field" required>
                                                <option value=""  selected disabled>Select One</option>
                                                @foreach ($jobType as $type)
                                                    <option value="{{ $type->id }}" {{ old('job_type_id') == $type->id ? 'selected' : ''}}>{{ $type->jobtype_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="job_added_date" class="col-sm-5 col-form-label fw-bold">Job Added Date</label>
                                        <div class="col-sm-7">
                                            <input type="date" id="job_added_date" name="job_added_date" class="form-control" placeholder="Job Added Date" value="{{ old('job_added_date') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="postal_code" class="col-sm-5 col-form-label fw-bold">Postal Code</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Postal Code" value="{{ old('postal_code') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="job_link" class="col-sm-5 col-form-label fw-bold">Job Link</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="job_link" name="job_link" class="form-control" placeholder="Job Link" value="{{ old('job_link') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="unit_no" class="col-sm-5 col-form-label fw-bold">Unit No</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="unit_no" name="unit_no" class="form-control" placeholder="Unit No" value="{{ old('unit_no') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="job_status" class="col-sm-5 col-form-label fw-bold">Status  <span class="text-danger">*</span></label>
                                        <div class="col-sm-7">
                                            <select id="job_status" name="job_status" class="form-control single-select-field" required>
                                                <option value="" selected disabled>Select One</option>
                                                <option value="1">Open</option>
                                                <option value="0">Close</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="address" class="col-sm-5 col-form-label fw-bold">Street</label>
                                        <div class="col-sm-7">
                                            <textarea name="address" id="address" rows="2" class="form-control" placeholder="Street"> {{ old('address') }} </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="display_address" class="col-sm-5 col-form-label fw-bold">Display Address</label>
                                        <div class="col-sm-7">
                                            <textarea rows="2" id="display_address" name="display_address" class="form-control" placeholder="Display Address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="remark" class="col-sm-5 col-form-label fw-bold">Internal Remark</label>
                                        <div class="col-sm-7">
                                            <textarea id="remark" name="remark" rows="2" class="form-control editor" placeholder="Internal Remark"> {{ old('remark') }} </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="short_desc" class="col-sm-5 col-form-label fw-bold">Short Description</label>
                                        <div class="col-sm-7">
                                            <textarea name="short_desc" id="short_desc" rows="2" class="form-control editor" placeholder="Short Description"> {{ old('short_desc') }} </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-1">
                                    <div class="row">
                                        <label for="description" class="col-sm-12 col-md-2 col-form-label fw-bold">Description</label>
                                        <div class="col-sm-12 col-md-10">
                                            <div class="d-flex flex-row-reverse description_textarea">
                                                <textarea name="description" id="description" class="editor" rows="2"> {{ old('description') }} </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h5 class="mt-4"><u>SEO Search</u></h5>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="meta_title" class="col-sm-5 col-form-label fw-bold">Meta Tag Title</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Search Title" value="{{ old('meta_title') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-1">
                                    <div class="row">
                                        <label for="meta_tag" class="col-sm-5 col-form-label fw-bold">Meta Tag Keyword</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="meta_tag" id="meta_tag" class="form-control" placeholder="Search Keyword" value="{{ old('meta_tag') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-1">
                                    <div class="row">
                                        <label for="meta_description" class="col-sm-12 col-md-2 col-form-label fw-bold">Meta Tag Description</label>
                                        <div class="col-sm-12 col-md-10">
                                            <div class="d-flex flex-row-reverse description_textarea">
                                                <textarea name="meta_description" id="meta_description" class="editor" rows="2"> {{ old('meta_description') }} </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="{{ route('job.index') }}" class="btn btn-sm btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @include('admin.include.select2js')
    <script>
        $(document).ready(function() {
            $('#clientSelect').change(function() {
                var clientId = $(this).val();
                if (clientId) {
                    $.ajax({
                        type: 'GET',
                        url: '/ATS/get/client/team/' + clientId,
                        success: function(data) {
                            $('#leadersContainer').empty();
                            $.each(data.team, function(key, value) {
                                $('#leadersContainer').append($('<option>', {
                                    value: value.id,
                                    text: value.employee_name
                                }));
                            });
                        }
                    });
                } else {
                    $('#leadersContainer').empty();
                    $('#leadersContainer').append($('<option>', {
                        value: '',
                        text: 'Select One'
                    }));
                }
            });
        });
    </script>

        <!-- ckeditor -->
        <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
        <script>
            var allEditors = document.querySelectorAll('.editor');
            for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i]);
            }
        </script>
        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script>
        <script>
            function job_link() {
                var copyText = document.getElementById("job_link");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);
            }
        </script>
    @endsection
