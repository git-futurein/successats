@extends('layouts.master')
@section('title')
User Mangement
@endsection
@section('page-title')
Manage User Google Authenticator
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
    
                <h4 class="card-heading text-center mt-4">Set up Google Authenticator</h4>
   
                <div class="card-body" style="text-align: center;">
                    <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code <strong>{{ $secret }}</strong></p>
                    <div>
                        {!! $QR_Image !!}
                    </div>
                    <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                    <div>
                        <a href="{{ route('user.authenticate') }}" class="btn btn-primary">Complete Registration</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
