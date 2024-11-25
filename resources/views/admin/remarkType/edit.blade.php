
<form action="{{ route('remarks-type.update', $data->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">Remarks Type Code</label>
                <div class="col-sm-9">
                    <input type="text" name="remarkstype_code" class="form-control"
                        placeholder="Title" value="{{ $data->remarkstype_code }}">
                </div>
            </div>
            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">Remarks Type Description</label>
                <div class="col-sm-9">
                    <textarea name="remarkstype_desc" rows="2" class="form-control" placeholder="Descriptin">{{$data->remarkstype_desc}} </textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">Seq No</label>
                <div class="col-sm-9">
                    <input type="text" name="remarkstype_seqno" class="form-control"
                        placeholder="Seq no" value="{{ $data->remarkstype_seqno }}">
                </div>
            </div>
            <div class="row mb-1">
                <label for="one" class="col-sm-3 col-form-label">Seq No</label>
                <div class="col-sm-9">
                        <select name="remarkstype_status" class="form-control">
                            <option value="1" {{$data->remarkstype_status == 1 ? 'selected' : '' }} >Active</option>
                            <option value="0" {{$data->remarkstype_status == 0 ? 'selected' : '' }} >In-Active</option>
                        </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-12">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-sm btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-sm btn-info">Submit</button>
        </div>
    </div>
</form>
