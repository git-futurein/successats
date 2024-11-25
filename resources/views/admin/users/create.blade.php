@extends('layouts.master')
@section('title')
    User Mangement
@endsection
@section('page-title')
    Manage Users
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
                            <h6 class="card-title mb-0">Create User</h6>
                        </div>
                        <div class="p-2 bd-highlight">
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-success">Search</a>
                        </div>
                    </div>
                    </div>
                    @include('admin.include.errors')
                    <div class="card-body p-4">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="form-row row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="name">Employee Name</label>
                                    <select name="name" id="name" class="form-control">
                                    <option value="">Select One</option>
                                        @foreach ($employees as $row)
                                            <option value="{{ $row->employee_name }}">{{ $row->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="email">Login Email</label>
                                    <input id="email" name="email" class="form-control" type="text">
                                </div>
                            </div>

                            <div class="form-row row mt-2">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                                </div>
                            </div>

                            <div class="form-row row mt-2">
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="password">Assign Roles</label>
                                    <select name="roles[]" id="roles" class="form-control">
                                    <option value="">Select user role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Get Authenticator Code</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#name').on('change', function () {
                var empName = this.value;

                $("#email").html('');
                $.ajax({
                    url: "{{route('email.searchapi')}}",
                    type: "POST",
                    data: {
                        name: empName,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        $.each(result.email, function (key, value) {
                            $("#email").val(value.employee_email);
                        });
                    }
                });
            });
             });
  </script>

    @endsection
