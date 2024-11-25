<form action="{{ route('client-term.update', $client_term->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-12 row">
            <div class="row mb-1 col-lg-6">
                <label for="one" class="col-sm-4 col-form-label">Terms Code</label>
                <div class="col-sm-8">
                    <input type="text" name="client_term_code" class="form-control" placeholder="Title"
                        value="{{ $client_term->client_term_code }}">
                </div>
            </div>
            <div class="row mb-1 col-lg-6">
                <label for="one" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select name="client_term_status" class="form-control" >
                        <option value="1" {{ $client_term->client_term_status == 1 ? 'selected' : '' }} >Active</option>
                        <option value="0" {{ $client_term->client_term_status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="row mb-1 col-lg-6">
                <label for="one" class="col-sm-4 col-form-label">List Order</label>
                <div class="col-sm-8">
                    <input type="text" name="client_term_seqno" class="form-control" placeholder="List Order"
                        value="{{ $client_term->client_term_seqno }}">
                </div>
            </div>
            <div class="row mb-1 col-lg-6">
                <label for="one" class="col-sm-4 col-form-label">Terms Description</label>
                <div class="col-sm-8">
                    <textarea name="client_term_desc" rows="2" class="form-control" placeholder="Descriptin"> {{$client_term->client_term_desc}} </textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-12">
            <button type="button" data-bs-dismiss="modal" aria-label="Close"
                class="btn btn-sm btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-sm btn-info">Update</button>
        </div>
    </div>
</form>
