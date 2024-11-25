
<form action="{{ route('industry-type.update', $industry_type->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row p-4">
        <div class="col-lg-12 row">
            <div class="row mb-4 col-lg-6">
                <label for="one" class="col-sm-4 col-form-label">Industy
                    Code</label>
                <div class="col-sm-8">
                    <input type="text" name="industry_code" class="form-control"
                        placeholder="Title" value="{{ $industry_type->industry_code }}">
                </div>
            </div>
            <div class="row mb-4 col-lg-6">
                <label for="one" class="col-sm-4 col-form-label">Industry
                    Description</label>
                <div class="col-sm-8">
                    <textarea name="industry_desc" rows="2" class="form-control" placeholder="Descriptin"> {{$industry_type->industry_desc}} </textarea>
                </div>
            </div>
            <div class="row mb-4 col-lg-6">
                <label for="one" class="col-sm-4 col-form-label">List Order</label>
                <div class="col-sm-8">
                    <input type="text" name="industry_seqno" class="form-control"
                        placeholder="List Order" value="{{ $industry_type->industry_seqno }}">
                </div>
            </div>
            <div class="row mb-4 col-lg-6">
                <label for="one" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select name="industry_status" class="form-control">
                        <option value="1" {{$industry_type->industry_status == 1 ? 'selected' : ''}} >Active</option>
                        <option value="0" {{$industry_type->industry_status == 0 ? 'selected' : ''}} >In-Active</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <button type="button" data-bs-dismiss="modal" aria-label="Close"
                class="btn btn-sm btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-sm btn-info">Submit</button>
        </div>
    </div>
</form>
