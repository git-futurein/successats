@extends('layouts.master')
@section('title')
    User Mangement
@endsection
@section('page-title')
    Manage Users
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
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
                            <h6 class="card-title mb-0">Users Table</h6>
                        </div>
                        <div class="p-2 bd-highlight">
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Create New</a>
                        </div>
                    </div>
                    </div>
                    <div class="card-body">
                        <div class="admin-dashboard-table">
                            <table class="table table-bordered" id="myTable">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th style="padding-right: 40px !important;">Sl</th>
                                    <th style="padding-right: 40px !important;">Name</th>
                                    <th style="padding-right: 40px !important;">Email</th>
                                    <th style="padding-right: 120px !important;">Roles</th>
                                    <th style="padding-right: 40px !important;">2FA</th>
                                    <th style="padding-right: 40px !important;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                            <span class="btn btn-sm btn-info mr-1">
                                                {{ $role->name }}
                                            </span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->google2fa_secret }}</td>
                                        <td class="d-flex">
                                            <a class="btn btn-sm btn-info text-white me-2"
                                                href="{{ route('users.edit', $user->id) }}"><i
                                                    class="fa fa-pen-to-square"></i></a>
                                            <form id="deleteForm" action="{{ route('users.destroy', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure? You want to disable this user?')"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>
    @endsection
