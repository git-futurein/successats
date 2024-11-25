@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('page-title')
    Dashboard
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
    <div class="min-vh-100" style="background: url(build/images/bg-2.png) top;">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('data.insert')}}" method="post">
                        @csrf
                        <button type="submit">insert</button>
                    </form>
                   
                    <form action="{{route('data.update','7')}}" method="post">
                        @csrf
                        <button type="submit">update</button>
                    </form>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end authentication section -->
        
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
