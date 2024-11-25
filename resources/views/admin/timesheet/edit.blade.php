@extends('layouts.master')

@section('title')
    Edit Time Sheet
@endsection

@section('page-title')
    Edit Time Sheet
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-header">
                    <h4 class="card-title mb-0 ">Edit Time Sheet</h4>
                </div>
                @include('admin.include.errors')
                <div class="card-body">
                    <form action="{{ route('time-sheet.update', $time_sheet->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Main time sheet fields -->
                        <div class="row">
                            <div class="col-md-6 col-lg-6 mb-2">
                                <div class="row">
                                    <label for="title" class="col-sm-3 col-md-4 col-form-label">Time Sheet Title</label>
                                    <div class="col-sm-9 col-md-8">
                                        <input type="text" class="form-control"  value="{{ old('title', $time_sheet->title) }}"
                                            name="title" id="title" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 mb-2">
                                <div class="row">
                                    <label for="print" class="col-sm-3 col-md-4 col-form-label">Printing</label>
                                    <div class="col-sm-9 col-md-8">
                                        <input type="text" class="form-control" value="{{ old('print', $time_sheet->print) }}" name="print" id="print">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="row">
                                    <label for="one" class="col-sm-3 col-md-2 col-form-label">Remarks</label>
                                    <div class="col-sm-9 col-md-10">
                                        <textarea name="remark" rows="4" class="form-control" placeholder="Remarks">{{ old('remark', $time_sheet->remark) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            @php
                                $entities = json_decode($time_sheet->entities);
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
                                        @foreach ($entities as $entity)
                                        <tr>
                                            <td>{{ $entity->day }}
                                                <input type="hidden" name="entities[{{ strtolower($entity->day) }}][day]" value="{{$entity->day}}">
                                            </td>
                                            <td><input type="time" class="form-control"  name="entities[{{ strtolower($entity->day) }}][in_time]" value="{{$entity->in_time}}"></td>
                                            <td><input type="time" class="form-control"  name="entities[{{ strtolower($entity->day) }}][out_time]" value="{{ $entity->out_time }}"></td>
                                            <td>
                                                <select class="form-control" name="entities[{{ strtolower($entity->day) }}][lunch_time]">
                                                    <!-- Add appropriate options based on your requirements -->
                                                    <option value="30 minutes"
                                                        {{ $entity->lunch_time == '30 minutes'? 'selected': '' }}>
                                                        30 minutes</option>
                                                    <option value="45 minutes"
                                                        {{ $entity->lunch_time == '45 minutes'? 'selected': '' }}>
                                                        45 minutes</option>
                                                    <option value="1 hour"
                                                        {{ $entity->lunch_time == '1 hour'? 'selected': '' }}>
                                                        1 hour</option>
                                                    <option value="2 hour"
                                                        {{ $entity->lunch_time == '2 hour'? 'selected': '' }}>
                                                        2 hour</option>
                                                    <option value="No Lunch"
                                                        {{ $entity->lunch_time == 'No Lunch'? 'selected': '' }}>
                                                        No Lunch</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="entities[{{ strtolower($entity->day) }}][isWork]" {{ isset($entity->isWork) ? 'checked': '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="entities[{{ strtolower($entity->day) }}][next_day]" {{ isset($entity->next_day) ? 'checked': '' }}>
                                            </td>
                                            <td>
                                                <select class="form-control" name="entities[{{ strtolower($entity->day) }}][ot_rate]">
                                                    <option value="No Rate"
                                                        {{ isset($entity->ot_rate) == 'No Rate'? 'selected': '' }}>
                                                        No Rate</option>
                                                    <option value="1.5"
                                                        {{ isset($entity->ot_rate) == '1.5'? 'selected': '' }}>
                                                        1.5</option>
                                                    <option value="2"
                                                        {{ isset($entity->ot_rate) == '2'? 'selected': '' }}>
                                                        2</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="entities[{{ strtolower($entity->day) }}][minimum]"
                                                value="{{$entity->minimum }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="entities[{{ strtolower($entity->day) }}][allowance]" value="{{ $entity->allowance }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <a href="{{ route('time-sheet.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-info">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
