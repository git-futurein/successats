<form action="{{ route('bank.update', $bank->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Bank No</label>
                <div class="col-sm-9">
                    <input type="text" name="bank_no" class="form-control" placeholder="Bank no"
                        value="{{ $bank->bank_no }}">
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Seq
                    No</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="seq_no" placeholder="Seq No"
                        value="{{ $bank->seq_no }}">
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-9">
                    <select name="status" class="form-control">
                        <option value="1" {{ $bank->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $bank->status == 0 ? 'selected' : '' }}>In-Active</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Bank Code</label>
                <div class="col-sm-9">
                    <input type="text" name="bank_code" class="form-control" placeholder="Bank code"
                        value="{{ $bank->bank_code }}">
                </div>
            </div>
            <div class="row mb-4">
                <label for="one" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" rows="4" class="form-control">{{ $bank->description }}</textarea>
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
