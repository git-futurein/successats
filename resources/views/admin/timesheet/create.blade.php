@extends('layouts.master')

@section('title')
    Time Sheet Management
@endsection

@section('page-title')
    Time Sheet Management
@endsection

@section('content')
<style>
</style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex bd-highlight">
                        <div class="p-2 flex-grow-1 bd-highlight">
                            <h6 class="card-title mb-0">Create Time Sheet</h6>
                        </div>
                    </div>
                </div>
                @include('admin.include.errors')
                <div class="card-body">
                    <form action="{{ route('time-sheet.store') }}" method="POST">
                        @csrf
                        <h5>Time Sheet</h5>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 mb-1">
                                <div class="row">
                                    <label for="title" class="col-sm-3 col-md-4 col-form-label">Time Sheet Title</label>
                                    <div class="col-sm-9 col-md-8">
                                        <input type="text" class="form-control" placeholder="Time Sheet Title"
                                            name="title" id="title" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 mb-1">
                                <div class="row">
                                    <label for="print" class="col-sm-3 col-md-4 col-form-label">Printing</label>
                                    <div class="col-sm-9 col-md-8">
                                        <input type="text" class="form-control" placeholder="Printing Title"
                                            name="print" id="print">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="row">
                                    <label for="one" class="col-sm-3 col-md-2 col-form-label">Remarks</label>
                                    <div class="col-sm-9 col-md-10">
                                        <textarea name="remark" rows="4" class="form-control" placeholder="Remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                 @php
                                    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                @endphp
                                <h5 class="mb-5">Days Setting</h5>
                                <div class="time-sheet-container" style="overflow: scroll">
                                    <table class="table time-sheet">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Day</th>
                                                <th class="text-center">Time In</th>
                                                <th class="text-center">Time Out</th>
                                                <th class="text-center" style="width: 120px">Lunch Hour</th>
                                                <th class="text-center">Work</th>
                                                <th class="text-center" style="width: 120px">Next Day</th>
                                                <th class="text-center" style="width: 100px">OT Rate</th>
                                                <th class="text-center">Minimum</th>
                                                <th class="text-center">Allowance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($days as $day)
                                            <tr>
                                                <td>{{ $day }}</td>
                                                <td><input type="time" class="form-control" name="entities[{{ strtolower($day) }}][in_time]" value="" placeholder="Time In"></td>
                                                <td><input type="time" class="form-control" name="entities[{{ strtolower($day) }}][out_time]" value="" placeholder="Time Out"></td>
                                                <td>
                                                    <select class="form-control" name="entities[{{ strtolower($day) }}][lunch_time]">
                                                        <option value="">Choose One</option>
                                                        <option value="30 minutes">30 minutes</option>
                                                        <option value="45 minutes">45 minutes</option>
                                                        <option value="1 hour">1 hour</option>
                                                        <option value="2 hour">2 hour</option>
                                                        <option value="No Lunch">No Lunch</option>
                                                    </select>
                                                </td>
                                                <td class="text-center"><input type="checkbox" name="entities[{{ strtolower($day) }}][isWork]"></td>
                                                <td class="text-center"><input type="checkbox" name="entities[{{ strtolower($day) }}][next_day]"></td>
                                                <td>
                                                    <select class="form-control" name="entities[{{ strtolower($day) }}][ot_rate]">
                                                        <option value="No Rate">No Rate</option>
                                                        <option value="1.5">1.5</option>
                                                        <option value="2">2</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control" name="entities[{{ strtolower($day) }}][minimum]" value=""></td>
                                                <td><input type="text" class="form-control" name="entities[{{ strtolower($day) }}][allowance]" value=""></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <a href="{{ route('time-sheet.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-info">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
