<form action="{{ route('file-type.update', $file_type->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">File Type
                    Code</label>
                <div class="col-sm-8">
                    <input type="text" name="uploadfiletype_code" class="form-control" placeholder="Title"
                        value="{{ $file_type->uploadfiletype_code }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">File Type Status</label>
                <div class="col-sm-9">
                    <select name="uploadfiletype_status" class="form-control">
                        <option value="1" {{ $file_type->uploadfiletype_status == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ $file_type->uploadfiletype_status == 0 ? 'selected' : '' }}>In-Active
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-12">
            <button type="button" data-bs-dismiss="modal" aria-label="Close"
                class="btn btn-sm btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-sm btn-info">Submit</button>
        </div>
    </div>
</form>
