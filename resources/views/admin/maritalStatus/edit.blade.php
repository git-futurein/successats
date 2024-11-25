<form action="{{ route('marital-status.update', $marital_status->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">Marital Code</label>
                <div class="col-sm-8">
                    <input type="text" name="marital_statuses_code" class="form-control" placeholder="Title"
                        value="{{ $marital_status->marital_statuses_code }}">
                </div>
            </div>
            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">Marital Description</label>
                <div class="col-sm-8">
                    <textarea name="marital_statuses_desc" rows="2" class="form-control" placeholder="Descriptin"> {{$marital_status->marital_statuses_desc}} </textarea>
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">List Order</label>
                <div class="col-sm-8">
                    <input type="text" name="marital_statuses_seqno" class="form-control" placeholder="List Order"
                        value="{{ $marital_status->marital_statuses_seqno }}">
                </div>
            </div>
            <div class="row mb-1">
                <label for="one" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select name="marital_statuses_status" class="form-control">
                        <option value="1"  {{ $marital_status->marital_statuses_status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0"  {{ $marital_status->marital_statuses_status == 0 ? 'selected' : '' }}>In-Active</option>
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
