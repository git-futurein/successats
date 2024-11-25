@extends('layouts.master')
@section('title')
    Company Profile
@endsection
@section('page-title')
    Create Company Profile
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create Company Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('company.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Company Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Company Name"
                                                name="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Fax</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Fax" name="fax">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <select name="nationality_id" id="" class="form-control" required>
                                                <option value="">Select One</option>
                                                @foreach ($nationalities as $nationality)
                                                    <option value="{{ $nationality->id }}">
                                                        {{ $nationality->en_nationality }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">GST No</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="GST No" name="gst_no">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea name="address" rows="2" placeholder="Address" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Remark Time Set (in
                                            Minute)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"
                                                placeholder="Remark Time Set (in Minute)" name="remark_time">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Tel</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Tel" name="tel">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" placeholder="Email" name="email">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Website</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Website" name="website">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">GST %</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="%" name="gst_percent">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="one" class="col-sm-3 col-form-label">Remark</label>
                                        <div class="col-sm-9">
                                            <textarea name="remark" rows="2" placeholder="Remark" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="{{ route('company.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
