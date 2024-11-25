@extends('layouts.master')
@section('title')
    Outlet Profile
@endsection
@section('page-title')
    Edit Outlet Profile
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                @include('layouts.bootstrap-error')
                <div class="card  p-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Outlet Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('outlets.update', $outlet->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Outlet Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Outlet Name"
                                                name="outlet_name" required
                                                value="{{ old('outlet_name') ?? optional($outlet)->outlet_name }}">

                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Outlet Fax</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Outlet Fax" name="outlet_fax" value="{{ old('outlet_fax') ?? $outlet->outlet_fax}}">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <select name="countries_id" id="" class="form-control" required>
                                                <option readonly>Select One</option>
                                                @foreach ($countries as $countrie)
                                                    <option value="{{ $countrie->id }}" {{ old('countries_id') ?? optional($outlet)->countries_id ==  $countrie->id ? 'selected' : '' }}>{{ $countrie->en_country_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">GST No</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="GST No" name="outlet_gstno" value="{{$outlet->outlet_gstno ?? old('outlet_gstno')}}">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea name="outlet_address" rows="2" placeholder="Address" class="form-control">{{ $outlet->outlet_address ?? old('outlet_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Outlet Tel</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Outlet Name"
                                                name="outlet_tel" required
                                                value="{{ old('outlet_tel') ?? optional($outlet)->outlet_tel }}">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" placeholder="Email" name="outlet_email" value="{{ $outlet->outlet_email ?? old('outlet_email')}}">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Website</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Website" name="outlet_website" value="{{ $outlet->outlet_website ?? old('outlet_website')}}">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">GST %</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="%" name="outlet_gstpercent" value="{{ $outlet->outlet_gstpercent ??  old('outlet_gstpercent')}}">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Outlet UEN</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Outlet UEN" name="outlet_license" value="{{ $outlet->outlet_license ?? old('outlet_license')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="row mb-1">
                                        <label for="one" class="col-sm-3 col-form-label">Outlet Description</label>
                                        <div class="col-sm-9">
                                            <textarea name="outlet_description" class="form-control" cols="4" rows="3" placeholder="Outlet Description">{{ $outlet->outlet_description ??  old('outlet_description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="{{ route('outlets.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
