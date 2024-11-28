{{-- @php
    if()
@endphp --}}
<div class="modal fade" id="showInterviewModal" tabindex="-1" aria-labelledby="showResumeLabel" aria-hidden="true">
    <div class="modal-dialog modal-xxl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showResumeLabel">Create Remark</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="resumeFilePath">

            <div class="tab-pane" id="remark" role="tabpanel">
                <form action="" method="POST" id="interviewForm">
                    @csrf
                    <div class="row">

                        <h5>Create Remarks</h5>

                        <div class="col-md-6 col-lg-6 mb-1" >
                            <div class="row">
                                <label class="col-sm-3 col-form-label fw-bold">Interview Time <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="time" class="form-control" name="interview_time" value="{{old('interview_time')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-1" >
                            <div class="row">
                                <label class="col-sm-3 col-form-label fw-bold">Interview Company <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select name="interview_company" id="interview_company"
                                        class="form-control single-select-field">
                                        <option value="">Select One</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('interview_company') == $client->id ? 'selected' : '' }}>
                                                {{ $client->client_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-1" >
                            <div class="row">
                                <label for="one" class="col-sm-3 col-form-label fw-bold">Expected Salary</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"
                                        name="interview_expected_salary" value="{{ old('interview_expected_salary') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-1">
                            <div class="row">
                                <label for="one" class="col-sm-3 col-form-label fw-bold">Interview Position <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="interview_position" id="interview_position" value="{{ old('interview_position') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-1" >
                            <div class="row">
                                <label for="one" class="col-sm-3 col-form-label fw-bold">Received Job Offer</label>
                                <div class="col-sm-9">
                                    <select name="interview_received_job_offer"
                                        class="form-control single-select-field">
                                        <option value="pending" {{ old('interview_received_job_offer') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="yes" {{ old('interview_received_job_offer') == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ old('interview_received_job_offer') == 'no' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-1" id="interviewEmailNoticeDate"
                            style="display: none;">
                            <div class="row">
                                <label for="one" class="col-sm-3 col-form-label fw-bold">Email Notice  Date</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control"
                                        name="interviewEmailNoticeDate" value="{{old('interviewEmailNoticeDate')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-1">
                            <div class="row">
                                <label for="one"
                                class="col-sm-3 col-form-label fw-bold">Notice</label>
                                <div class="col-sm-9">
                                    <select name="isNotice" class="form-control single-select-field">
                                        <option value="" selected>Select One</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 mb-1" >
                            <div class="row">
                                <label for="one" class="col-sm-3 col-form-label fw-bold">Interview Date<span class="text-danger">*</span> </label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="interview_date" id="interview_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6  mb-1" >
                            <div class="row">
                                <label for="one" class="col-sm-3 col-form-label fw-bold">Interview By</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="interview_by">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-1" >
                            <div class="row">
                                <label for="one" class="col-sm-3 col-form-label fw-bold">Jobs Offer Salary</label>
                                <div class="col-sm-9">
                                    <input type="text" name="inteview_job_offer_salary"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-1" >
                            <div class="row">
                                <label for="one" class="col-sm-3 col-form-label fw-bold">Available
                                Date</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="available_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-1">
                            <div class="row">
                                <label for="remarks" class="col-sm-12 col-md-1 col-form-label fw-bold">Remarks <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-11">
                                    <div class="d-flex flex-row-reverse description_textarea">
                                        <textarea name="remarks" id="ckeditor-classic" class="editor " rows="2"> {{ old('remarks') }} </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
