@extends('layouts.master')
@section('title')
Create Candidate
@endsection
@section('page-title')
Candidate Create
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Create New Candidate</h4>
                    <div class="text-end">
                        <a href="#" class="btn btn-sm btn-success">Create New</a>
                        <a href="#" class="btn btn-sm btn-success">Search</a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Nav tabs -->
                    <div class="row">
                        <div class="col-lg-10">
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
                                    <a class="nav-link" data-bs-toggle="tab" href="#bank_info" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Bank Info</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#qualification" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Qualification</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#character_referees" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Character Referee's</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#declaration" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Declaration</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#terms_conditions" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Terms & Conditions</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Tab panes -->
                    <form>
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="General_info" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-4 col-form-label">Candidate Code</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="candidate_code" class="form-control"
                                                        placeholder="--System Genarated--" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Date of Birth</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="dob" class="form-control"
                                                        placeholder="Date of Birth">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="two" class="col-sm-3 col-form-label">Race</label>
                                                <div class="col-sm-9">
                                                    <select name="race" class="form-control">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="two" class="col-sm-3 col-form-label">Natinality</label>
                                                <div class="col-sm-9">
                                                    <select name="race" class="form-control">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="three" class="col-sm-3 col-form-label">Mobile</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="mobile"
                                                        placeholder="Mobile">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="three" class="col-sm-3 col-form-label">Home Tel</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="home_tel"
                                                        placeholder="Home Tel">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="two" class="col-sm-3 col-form-label">Type Of Pass</label>
                                                <div class="col-sm-9">
                                                    <select name="two" name="type_of_pass" class="form-control">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="three" class="col-sm-3 col-form-label">Height</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="height"
                                                        placeholder="Height">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-4 col-form-label">Position
                                                    Applied</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="position_applied" class="form-control"
                                                        placeholder="Position Applied">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">NRIC/FIN No.</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="fin_no" class="form-control"
                                                        placeholder="NRIC/FIN No.">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Gender</label>
                                                <div class="col-sm-9">
                                                    <select name="two" name="gender" class="form-control">
                                                        <option value="">Select One</option>
                                                        <option value="">Male</option>
                                                        <option value="">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="two" class="col-sm-3 col-form-label">Religion</label>
                                                <div class="col-sm-9">
                                                    <select name="two" name="religion" class="form-control">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="two" class="col-sm-3 col-form-label">Marital Status</label>
                                                <div class="col-sm-9">
                                                    <select name="marital_status" class="form-control">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-4 col-form-label">Numbers of
                                                    Children</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="no_children" class="form-control"
                                                        placeholder="Numbers of Children">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="email" name="email" class="form-control"
                                                        placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select name="two" name="status" class="form-control">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Weight</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="weight" class="form-control"
                                                        placeholder="Weight">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">

                                        <div class="row mb-4">
                                            {{-- <label for="one" class="col-sm-3 col-form-label">User Right</label> --}}
                                            <div class="col-sm-9">
                                                <img src="{{ URL::asset('build/images/avatar.png') }}"
                                                    alt="avatar" class="mb-2">
                                                <input type="file" name="avatar" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="contact_info" role="tabpanel">
                                <div class="row">
                                    <h5>Address Information</h5>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Postal Code 1</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="postal_code_1" class="form-control"
                                                        placeholder="Postal Code">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Unit No 1</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="unite_no_1" class="form-control"
                                                        placeholder="Unit No">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Address 1</label>
                                                <div class="col-sm-9">
                                                    <textarea name="address_1" rows="2" class="form-control"
                                                        placeholder="Address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Postal Code 2</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="postal_code_2" class="form-control"
                                                        placeholder="Postal Code">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Unit No 2</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="unit_no_2" class="form-control"
                                                        placeholder="Unit No">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Address 2</label>
                                                <div class="col-sm-9">
                                                    <textarea name="address_2" rows="2" class="form-control"
                                                        placeholder="Address"></textarea>
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
                                                <label for="one" class="col-sm-3 col-form-label">Contact Person</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="contact_person" class="form-control"
                                                        placeholder="Contact Person">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Phone 1</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="phone_1" class="form-control"
                                                        placeholder="Phone 1">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Address</label>
                                                <div class="col-sm-9">
                                                    <textarea name="address" rows="2" class="form-control"
                                                        placeholder="Address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Relationship</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="relationship" class="form-control"
                                                        placeholder="Relationship">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Phone 2</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="phone_2" class="form-control"
                                                        placeholder="Phone 2">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="four" class="col-sm-3 col-form-label">Remarks</label>
                                                <div class="col-sm-9">
                                                    <textarea name="remarks" rows="2" class="form-control"
                                                        placeholder="Remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="bank_info" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Pay Mode</label>
                                                <div class="col-sm-9">
                                                    <select name="pay_mode" class="form-control" id="">
                                                        <option value="">Select One</option>
                                                        <option value="">Cash</option>
                                                        <option value="">Cheque</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">GIRO Account
                                                    Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="account_name" class="form-control"
                                                        placeholder="GIRO Account Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Pay Mode</label>
                                                <div class="col-sm-6">
                                                    <select name="pay_mode_2" class="form-control" id="">
                                                        <option value="">Select One</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">GIRO Account No</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="account_no" class="form-control"
                                                        placeholder="GIRO Account No">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="qualification" role="tabpanel">
                                <h5>Qualification and Skill</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">N-Levels</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="n_levels"
                                                        placeholder="Course">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">O-Levels</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="o_levels" class="form-control"
                                                        placeholder="Course">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">A-Levels</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="a_levels" class="form-control"
                                                        placeholder="Course">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Diploma</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="diploma" class="form-control"
                                                        placeholder="Course">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Degree</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="degree" class="form-control"
                                                        placeholder="Course">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Other</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="other" class="form-control"
                                                        placeholder="Course">
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
                                                <input type="text" name="written" class="form-control"
                                                    placeholder="eg: English - good">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-3 col-form-label">Spoken</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="spoken" class="form-control"
                                                    placeholder="eg: English - good">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="character_referees" role="tabpanel">
                                <h5>Character Referee's</h5>
                                <p>Name 2 persons who are not your relatives</p>
                                <div class="row mb-5">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="not_relative_name" class="form-control"
                                                        placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Years Known</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="year" class="form-control"
                                                        placeholder="Year">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Occupation</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="occupation"
                                                        placeholder="Occupation">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-4 col-form-label">Contact No / Email
                                                    Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="contact_no" class="form-control"
                                                        placeholder="Contact No">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name_2"
                                                        placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Years Known</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="year_2" class="form-control"
                                                        placeholder="Year">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-3 col-form-label">Occupation</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="occupation_2" class="form-control"
                                                        placeholder="Occupation">
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="one" class="col-sm-4 col-form-label">Contact No / Email
                                                    Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="contact_2" class="form-control"
                                                        placeholder="Contact No">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>May we write to the following for a reference?</p>
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-2 col-form-label">Your present
                                                employer</label>
                                            <div class="col-sm-8">
                                                <input type="radio" name="present_employer"> Yes
                                                <input type="radio" name="present_employer"> No
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="one" class="col-sm-2 col-form-label">Your previous
                                                employer(s)</label>
                                            <div class="col-sm-8">
                                                <input type="radio" name="present_employer"> Yes
                                                <input type="radio" name="present_employer"> No
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="declaration" role="tabpanel">
                                <h5 class="mb-5">Declaration</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-5 mt-lg-4 mt-xl-0">
                                            <div class="form-group mb-2">
                                                <label for="declaration_bankrupt" class=" control-label">1. Are
                                                    you / Have you ever been an undischarged bankrupt?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="question_1" value="1">Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="question_1" value="0">No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="db_specify"
                                                            name="question_1_field" value=""
                                                            placeholder="If Yes, Please specify">
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
                                                            <input type="radio" name="question_2" value="1">Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="question_2" value="0">No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="db_specify"
                                                            name="question_2_field" value=""
                                                            placeholder="If Yes, Please specify">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="declaration_bankrupt" class=" control-label">3. Are you
                                                    currently undergoing long-term medical treatment?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="question_3" value="1">Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="question_3" value="0">No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="db_specify"
                                                            name="question_3_field" value=""
                                                            placeholder="If Yes, Please specify">
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
                                                            <input type="radio" name="question_4" value="1">Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="question_4" value="0">No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="db_specify"
                                                            name="question_4_field" value=""
                                                            placeholder="If Yes, Please specify">
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
                                                            <input type="radio" name="question_5" value="1">Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="question_5" value="0">No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="db_specify"
                                                            name="question_5_field" value=""
                                                            placeholder="If Yes, Please specify">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="declaration_bankrupt" class=" control-label">6. Have you
                                                    applied for any job with this company before?</label>
                                                <div class="radio d-flex">
                                                    <div class="col-sm-3">
                                                        <label>
                                                            <input type="radio" name="question_6" value="1">Yes
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="question_6" value="0">No
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="db_specify"
                                                            name="question_6_field" value=""
                                                            placeholder="If Yes, Please specify">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="terms_conditions" role="tabpanel">
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
                                            coming.</p>
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
                                                <label for="one" class="col-sm-2 col-form-label">Join Date</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" name="join_date"
                                                        placeholder="Join Date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-sm-9 ms-5 mb-5">
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
