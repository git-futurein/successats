<div class="modal fade" id="remarkSwiceModal" tabindex="-1" aria-labelledby="showResumeLabel" aria-hidden="true">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showResumeLabel">Create Remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="resumeFilePath">
                <div class="tab-pane" id="remark" role="tabpanel">
                    @if (App\Helpers\FileHelper::usr()->can('candidate.remark'))
                        <form action="{{ route('dashboard.candidate.remark') }}" method="POST">
                            @csrf
                            <input type="text" name="remarkId" value="" id="remarkId" hidden>
                            <input type="text" name="dashboardId" value="" id="dashboardId" hidden>
                            <div class="row">

                                <h5>Create Remarks</h5>
                                <p class="mb-0"><strong>Name: <span id="candidate_name"></span></strong></p>
                                <p><strong>NRIC:  <span id="candidate_nric"></span></strong> </p>

                                <div class="col-md-6 col-lg-6 mb-2" style="display: none">
                                    <input type="hidden" value="{{ $candidate->id }}" name="candidate_id">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Remark
                                            Type</label>
                                        <div class="col-sm-9">
                                            <select name="remarkstype_id" class="form-control single-select-field"
                                                id="remark_type_test">
                                                <option value="" selected disabled>Select One</option>

                                                @if ($auth->roles_id == 1 || $auth->roles_id == 4)
                                                    <option value="12"
                                                        {{ old('remarkstype_id') == 12 ? 'selected' : '' }}>Share to
                                                        Other Managers (Admin / Manager use only)</option>
                                                @endif
                                                <option value="4"
                                                    {{ old('remarkstype_id') == 4 ? 'selected' : '' }}>Candidate
                                                    Follow Up</option>
                                                <option value="5"
                                                    {{ old('remarkstype_id') == 5 ? 'selected' : '' }}>Assign
                                                    Interview</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="AssignToClient" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Client <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="assign_client_id" id="assign_client_id"
                                                class="form-control single-select-field">
                                                <option value="">Select One</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">
                                                        {{ $client->client_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="interviewTime" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Interview Time
                                            <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="time" class="form-control" name="interview_time"
                                                value="{{ old('interview_time') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="callbackDate" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Callback Date
                                            <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="callbackDateInput"
                                                name="callbackDate" value="{{ old('callbackDate') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="callbackTime" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Callback Time
                                            <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="time" class="form-control" id="callbackTimeInput"
                                                name="callbackTime" value="{{ old('callbackTime') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="interviewCompany" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Interview
                                            Company <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="interview_company" id="interview_company"
                                                class="form-control single-select-field">
                                                <option value="">Select One</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        {{ old('interview_company') == $client->id ? 'selected' : '' }}>
                                                        {{ $client->client_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="expectedSalary" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Expected
                                            Salary</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                name="interview_expected_salary"
                                                value="{{ old('interview_expected_salary') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="interviewPosition" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Interview
                                            Position <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="interview_position"
                                                id="interview_position" value="{{ old('interview_position') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="receivedJobOffer" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Received Job
                                            Offer</label>
                                        <div class="col-sm-9">
                                            <select name="interview_received_job_offer"
                                                class="form-control single-select-field">
                                                <option value="pending"
                                                    {{ old('interview_received_job_offer') == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="yes"
                                                    {{ old('interview_received_job_offer') == 'yes' ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="no"
                                                    {{ old('interview_received_job_offer') == 'no' ? 'selected' : '' }}>
                                                    No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistClientCompany"
                                    style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Client Company
                                            <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select name="client_company_s" id="shortlist_client_company"
                                                class="form-control single-select-field">
                                                <option value="">Select One</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">
                                                        {{ $client->client_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistDepartment" style="display: none;">
                                    <div class="row">
                                        <label for="one"
                                            class="col-sm-3 col-form-label fw-bold">Department</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="shortlistDepartment">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistPlacement" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Placement /
                                            Recruitment Fee
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="shortlistPlacement">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistJobTitle" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Job Title <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="shortlistJobTitle"
                                                id="shortlist_job_title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistJobType" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Job Type <span
                                                class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select name="shortlistJobType" id="shortlist_job_type"
                                                class="form-control single-select-field">
                                                <option value="">Select One</option>
                                                @foreach ($job_types as $type)
                                                    <option value="{{ $type->id }}">
                                                        {{ $type->jobtype_code }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistProbationPeriod"
                                    style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Probation
                                            Period</label>
                                        <div class="col-sm-9">
                                            <select name="shortlistProbationPeriod"
                                                class="form-control single-select-field">
                                                <option value="">Select One</option>
                                                <option value="0">No Probation</option>
                                                <option value="1">1 Month</option>
                                                <option value="2">2 Months</option>
                                                <option value="3">3 Months</option>
                                                <option value="4">4 Months</option>
                                                <option value="5">5 Months</option>
                                                <option value="6">6 Months</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistContractSigningDate"
                                    style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Contract Signing
                                            Date <span class="text-danger"></span></label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control"
                                                name="shortlistContractSigningDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistEmailNoticeDate"
                                    style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Email Notice
                                            Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control"
                                                name="shortlistEmailNoticeDate"
                                                value="{{ old('shortlistEmailNoticeDate') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="interviewEmailNoticeDate"
                                    style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Email Notice
                                            Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control"
                                                name="interviewEmailNoticeDate"
                                                value="{{ old('interviewEmailNoticeDate') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Notice</label>
                                        <div class="col-sm-9">
                                            <select name="isNotice" class="form-control single-select-field">
                                                <option value="" selected>Select One</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="AssignToManager" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Assign To
                                            <span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select name="Assign_to_manager" class="form-control single-select-field">
                                                <option value="">Select One</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('Assign_to_manager', $candidate->Assign_to_manager) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->employee_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="reassign" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Assign To <span
                                                class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select name="Assign_to_manager_r"
                                                class="form-control single-select-field">
                                                <option value="">Select One</option>
                                                @foreach (\App\Models\Employee::select('id', 'employee_name')->where('roles_id', '!=', 1)->get() as $user)
                                                    <option value="{{ $user->id }}" {{ old('Assign_to_manager', $candidate->Assign_to_manager) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->employee_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 mb-2" id="clientArNo" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">AR
                                            No</label>
                                        <div class="col-sm-9">
                                            <select name="client_ar_no" class="form-control single-select-field">
                                                <option value="0">Select On</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistSalary" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Salary
                                            <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="shortlist_salary"
                                                name="shortlistSalary"
                                                value="{{ old('shortlistSalary', $candidate->shortlistSalary) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistArNo" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">AR
                                            No</label>
                                        <div class="col-sm-9">
                                            <select name="shortlistArNo" class="form-control single-select-field">
                                                <option value="">Select One</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistHourlyRate" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Hourly
                                            Rate</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="shortlistHourlyRate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistAdminFee" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Admin
                                            Fee</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="shortlistAdminFee">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistStartDate" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Start Date <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="shortlistStartDate"
                                                id="shortlist_start_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistReminderPeriod"
                                    style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Reminder Period
                                            <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <select name="shortlistReminderPeriod" id="shortlist_reminder_period"
                                                class="form-control single-select-field">
                                                <option value="1 Week Before">1 Week Before</option>
                                                <option value="2 Week Before">2 Week Before</option>
                                                <option value="3 Week Before">3 Week Before</option>
                                                <option value="4 Week Before">4 Week Before</option>
                                                <option value="5 Week Before">5 Week Before</option>
                                                <option value="6 Week Before">6 Week Before</option>
                                                <option value="7 Week Before">7 Week Before</option>
                                                <option value="8 Week Before">8 Week Before</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistContractSigningTime"
                                    style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Contract Signing
                                            Time <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="time" class="form-control"
                                                name="shortlistContractSigningTime"
                                                id="shortlist_contract_signing_time">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistContractEndDate"
                                    style="display: none">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Contract End
                                            Date <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control"
                                                name="shortlistContractEndDate" id="shortlist_contract_end_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistLastDay" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Last Day</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="shortlistLastDay">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="shortlistEmailNoticeTime"
                                    style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Email Notice
                                            Time</label>
                                        <div class="col-sm-9">
                                            <input type="time" class="form-control"
                                                name="shortlistEmailNoticeTime">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="AssignToTeamLeader" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Assign To <span
                                                class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select id="team_leader_option" name="team_leader"
                                                class="form-control single-select-field">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="AssignToRC" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Assign To <span
                                                class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <select id="selected_rc" name="rc"
                                                class="form-control single-select-field">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="interviewDate" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Interview
                                            Date<span class="text-danger">*</span> </label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="interview_date"
                                                id="interview_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6  mb-2" id="interviewBy" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Interview
                                            By</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="interview_by">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="jobOfferSalary" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Jobs Offer
                                            Salary</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="inteview_job_offer_salary"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="attendInterview" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Attend
                                            Interview</label>
                                        <div class="col-sm-9">
                                            <select name="attendInterview" class="form-control single-select-field">
                                                <option value="pending">Pending</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="availableDate" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Available
                                            Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="available_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2" id="emailNoticeTime" style="display: none;">
                                    <div class="row">
                                        <label for="one" class="col-sm-3 col-form-label fw-bold">Email Notice
                                            Time</label>
                                        <div class="col-sm-9">
                                            <input type="time" name="interviewEmailNoticeTime"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <label for="remarks"
                                            class="col-sm-12 col-md-1 col-form-label fw-bold">Remarks <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12 col-md-11 d-flex flex-row-reverse description_textarea">
                                            <textarea name="remarks" id="ckeditor-classic" class="editor" rows="2"> {{ old('remarks') }} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="submit" class="btn btn-sm btn-info">Save</button>
                        </form>
                    @endif
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Assign</th>
                                        <th>Client</th>
                                        <th>Remarks Type</th>
                                        <th>Comments</th>
                                        <th>Created By</th>
                                        <th>Created Time</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody id="CandidateRemarks">

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


{{-- @section('scripts')

@endsection --}}
