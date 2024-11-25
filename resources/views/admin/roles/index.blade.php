@extends('layouts.master')
@section('title')
Role Mangement
@endsection
@section('page-title')
Manage Roles
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
                            <h6 class="card-title mb-0">Roles Table</h6>
                        </div>
                        <div class="p-2 bd-highlight">
                            <a href="{{route('roles.create')}}" class="btn btn-sm btn-success">Create New</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{$loop->index+1}} </td>
                                <td>{{$role->name}}</td>
                                <td>
                                    @foreach ($role->permissions as $perm)
                                        <span class="btn btn-sm btn-info me-1 mb-1">
                                            {{ $perm->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="d-flex">
                                    @if (App\Helpers\FileHelper::usr()->can('roles.update'))
                                    <a href="{{route('roles.edit', $role->id)}}" class="btn btn-info me-2"><i class="fa fa-pen"></i></a>
                                    @endif
                                    @if (App\Helpers\FileHelper::usr()->can('roles.destroy'))
                                    <form id="deleteForm" action="{{route('roles.destroy', $role->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this item?')"
                                            class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
