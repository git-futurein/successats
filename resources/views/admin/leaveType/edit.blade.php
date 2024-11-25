
    <form action="{{route('leave-type.update', $leave_type->id)}}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row p-4">
            <div class="col-lg-6">
                <div class="row mb-1">
                    <label for="one" class="col-sm-4 col-form-label">Leave Type Code</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="leavetype_code" placeholder="Leave Type Code" value="{{$leave_type->leavetype_code}}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="one" class="col-sm-4 col-form-label">Default Leave Days</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="leavetype_default" placeholder="Default Leave Days" value="{{$leave_type->leavetype_default}}">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="one" class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-8">
                        <select name="leavetype_status" id="" class="form-control">
                            <option value="1" {{$leave_type->leavetype_status == 1 ? 'selected' : ''}}>Active</option>
                            <option value="0" {{$leave_type->leavetype_status == 0 ? 'selected' : ''}}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row mb-1">
                    <label for="one" class="col-sm-4 col-form-label">List Order</label>
                    <div class="col-sm-8">
                        <input type="text" name="industry_seqno" class="form-control" value="{{$leave_type->industry_seqno}}" placeholder="List Order">
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="one" class="col-sm-4 col-form-label">Block Candidate</label>
                    <div class="col-sm-8">
                        <select name="leavetype_block" id="" class="form-control">
                            <option value="1"{{$leave_type->leavetype_block == 1 ? 'selected' : ''}}>Yes</option>
                            <option value="0"{{$leave_type->leavetype_block == 0 ? 'selected' : ''}}>No</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="one" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <textarea name="leavetype_desc" rows="2" placeholder="Description" class="form-control"> {{$leave_type->leavetype_desc}} </textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="{{route('leave-type.index')}}" class="btn btn-sm btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-sm btn-info">Submit</button>
            </div>
        </div>
    </form>
