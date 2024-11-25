<form action="{{ route('department.update', $department->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-12">
            <div class="row mb-4">
                <label for="one" class="col-sm-2 col-form-label">Department Code</label>
                <div class="col-sm-9">
                    <input type="text" name="department_code" class="form-control" placeholder="Department Code"
                        value="{{ $department->department_code }}">
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-2 col-form-label">List Order</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="department_seqno" placeholder="Seq No"
                        value="{{ $department->department_seqno }}">
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-9">
                    <select name="department_status" id="" class="form-control">
                        <option value="1" {{ $department->department_status == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ $department->department_status == 0 ? 'selected' : '' }}>In-Active
                        </option>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="department_desc" rows="2" class="form-control" placeholder="Description">{{ $department->department_desc }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('department.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-sm btn-info">Submit</button>
        </div>
    </div>
</form>
