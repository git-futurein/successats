<form action="{{ route('job-type.update', $job_type->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">Type Code</label>
                <div class="col-sm-9">
                    <input type="text" name="jobtype_code" class="form-control" placeholder="Name" value="{{$job_type->jobtype_code}}">
                </div>
            </div>
            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="jobtype_desc" rows="4" class="form-control"> {{$job_type->jobtype_desc}} </textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">Seq
                    No</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="jobtype_seqno" placeholder="Seq No" value="{{$job_type->jobtype_seqno}}">
                </div>
            </div>
            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">Seq
                    No</label>
                <div class="col-sm-9">
                    <select name="jobtype_status" class="form-control">
                        <option value="1" {{$job_type->jobtype_status == 1 ? 'selected' : ''}}>Active</option>
                        <option value="0" {{$job_type->jobtype_status == 0 ? 'selected' : ''}}>In-Active</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                aria-label="Close">Cancel</button>
            <button type="submit" class="btn btn-sm btn-info">Submit</button>
        </div>
    </div>
</form>
