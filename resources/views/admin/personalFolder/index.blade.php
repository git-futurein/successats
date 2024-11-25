@extends('layouts.master')
@section('title')
Personal Folder Management
@endsection
@section('page-title')
Personal Folder Management
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Personal Folder Table</h4>
                    <div class="text-end">
                        <a href="/personal-folder/create" class="btn btn-sm btn-info">Create New</a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Here place table --}}
                </div>
            </div>
        </div>
    </div>
    @endsection
