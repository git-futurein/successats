<div class="modal fade bs-example-modal-lg-edit-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Update Nationality</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <form action="{{ route('countries.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row mb-4">
                                <label for="one" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="en_country_name" class="form-control"
                                        placeholder="Country Name"
                                        value="{{ old('en_country_name') ?? $data->en_country_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-4">
                                <label for="one" class="col-sm-3 col-form-label">Nationality
                                    Code</label>
                                <div class="col-sm-9">
                                    <input type="text" name="country_code" class="form-control"
                                        placeholder="Nationality code" value="{{ old('country_code') ?? $data->country_code  }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-4">
                                <label for="one" class="col-sm-3 col-form-label">Nationality</label>
                                <div class="col-sm-9">
                                    <input type="text" name="en_nationality" class="form-control"
                                        placeholder="Nationality" value="{{ old('en_nationality') ?? $data->en_nationality  }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-4">
                                <label for="one" class="col-sm-3 col-form-label">Alpha 2 Code</label>
                                <div class="col-sm-9">
                                    <input type="text" name="alpha_2_code" class="form-control"
                                        placeholder="alpha 2 code" value="{{ old('alpha_2_code') ?? $data->alpha_2_code  }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-4">
                                <label for="one" class="col-sm-3 col-form-label">Alpha 3 Code</label>
                                <div class="col-sm-9">
                                    <input type="text" name="alpha_3_code" class="form-control"
                                        placeholder="alpha 3 code" value="{{ old('alpha_3_code') ?? $data->alpha_3_code  }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-info">Update</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
