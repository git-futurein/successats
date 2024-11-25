<form action="{{ route('pass-type.update', $data->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">Pass Type Code</label>
                <div class="col-sm-8">
                    <input type="text" name="passtype_code" class="form-control" placeholder="Title"
                        value="{{ $data->passtype_code }}">
                </div>
            </div>
            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">Pass Type Description</label>
                <div class="col-sm-8">
                    <textarea name="passtype_desc" rows="2" class="form-control"
                        placeholder="Descriptin">{{ $data->passtype_desc }} </textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">List Order</label>
                <div class="col-sm-8">
                    <input type="text" name="passtype_seqno" class="form-control" placeholder="List Order"
                        value="{{ $data->passtype_seqno }}">
                </div>
            </div>
            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select name="passtype_status" class="form-control">
                        <option value="1"{{$data->passtype_status == 1 ? 'selected' : ''}} >Active</option>
                        <option value="0" {{$data->passtype_status == 0 ? 'selected' : ''}}>In-Active</option>
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
