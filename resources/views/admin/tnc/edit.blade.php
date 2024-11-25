<form action="{{ route('tnc.update', $tnc->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="row p-4">
            <div class="row col-md-6 col-lg-6 mb-1">
                <label for="one" class="col-sm-4 col-form-label fw-bold">TNC Code</label>
                <div class="col-sm-8">
                    <input type="text" name="tnc_template_code" class="form-control" placeholder="Title"
                        value="{{ old('tnc_template_code',$tnc->tnc_template_code) }}">
                </div>
            </div>
            <div class="row col-md-6 col-lg-6 mb-1">
                <label for="status" class="col-sm-4 col-form-label fw-bold">Status</label>
                <div class="col-sm-8">
                    <select name="tnc_template_status" class="form-control searchBox">
                        <option value="1" {{ old('tnc_template_status',$tnc->tnc_template_status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('tnc_template_status',$tnc->tnc_template_status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="row col-md-6 col-lg-6 mb-1">
                <label for="status" class="col-sm-4 col-form-label fw-bold">Default</label>
                <div class="col-sm-8">
                    <select name="tnc_template_isDefault" class="form-control searchBox">
                        <option value="1" {{ old('tnc_template_isDefault',$tnc->tnc_template_isDefault) == 1 ? 'selected' : '' }}>Default</option>
                        <option value="0" {{ old('tnc_template_isDefault',$tnc->tnc_template_isDefault) == 0 ? 'selected' : '' }}>None</option>
                    </select>
                </div>
            </div>
            <div class="row col-md-6 col-lg-6 mb-1">
                <label for="one" class="col-sm-4 col-form-label fw-bold">List Order</label>
                <div class="col-sm-8">
                    <input type="text" name="tnc_template_seqno" class="form-control" placeholder=""
                        value="{{ old('tnc_template_seqno',$tnc->tnc_template_seqno) }}">
                </div>
            </div>
            <div class="row col-md-6 col-lg-6 mb-1">
                <label for="one" class="col-sm-4 col-form-label">TNC
                    Description</label>
                <div class="col-sm-8">
                    <textarea name="tnc_template_desc" rows="2" class="form-control" placeholder="Description"> {{ old('tnc_template_desc',$tnc->tnc_template_desc) }} </textarea>
                </div>
            </div>
            <div class="row col-md-6 col-lg-6 mb-1">
                <label for="one" class="col-sm-4 col-form-label fw-bold">Upload Template File</label>
                <div class="col-sm-8">
                    <input type="file" name="tnc_template_file_path" class="form-control" value="{{old('tnc_template_file_path')}}">
                    <div class="col-sm-12">
                        <a href="{{ asset('storage') }}/{{ $tnc->tnc_template_file_path }}" target="_blank">
                            <i class="fas fa fa-eye"> <small>Download Template</small></i>
                        </a>
                    </div>
                </div>
            </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-sm btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-sm btn-info">Submit</button>
        </div>
    </div>
</form>
