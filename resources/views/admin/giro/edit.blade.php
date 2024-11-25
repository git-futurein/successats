<form action="{{ route('giro.update', $giro->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Giro No</label>
                <div class="col-sm-9">
                    <input type="text" name="giro_no" class="form-control" placeholder="Giro no"
                        value="{{ $giro->giro_no }}">
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Bank</label>
                <div class="col-sm-9">
                    <select name="bank_id" id="" class="form-control">
                        <option value="">Select One</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}" {{ $bank->id == $giro->bank_id ? 'selected' : '' }}>
                                {{ $bank->bank_code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-9">
                    <select name="status" id="" class="form-control">
                        <option value="1" {{ $giro->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $giro->status == 0 ? 'selected' : '' }}>In-Active</option>
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" rows="4" class="form-control">{{ $giro->description }} </textarea>
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
