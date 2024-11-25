<form action="{{ route('nationality.update', $nationality->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Nationality Code</label>
                <div class="col-sm-9">
                    <input type="text" name="nationality_code" class="form-control" placeholder="Code"
                        value="{{ $nationality->nationality_code }}">
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Seq No</label>
                <div class="col-sm-9">
                    <input type="text" name="seq_no" class="form-control" placeholder="Seq no"
                        value="{{ $nationality->seq_no }}">
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-9">
                    <select name="status" id="" class="form-control">
                        <option value="1" {{ $nationality->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $nationality->status == 0 ? 'selected' : '' }}>In-Active</option>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" rows="4" class="form-control">{{ $nationality->description }} </textarea>
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
