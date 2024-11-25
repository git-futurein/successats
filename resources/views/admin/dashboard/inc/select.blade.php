<select class="form-select me-2 single-select-field" id="followUpStatusChange_{{ $candidate['id'] }}" style="width: 145px"
    aria-label="Default select example">
    <option disabled {{ $candidate['remark_id'] == 0 ? 'selected' : '' }}>
        Active Resume</option>
    <option disabled {{ $candidate['remark_id'] == 6 ? 'selected' : '' }}>
        Follow Up</option>
    <option value="2" {{ $candidate['remark_id'] == 2 ? 'selected' : '' }}>
        FAJ</option>
    <option value="3" {{ $candidate['remark_id'] == 3 ? 'selected' : '' }}>
        Not Suitable</option>
    <option disabled {{ $candidate['remark_id'] == 4 ? 'selected' : '' }}>
        Interview</option>
    <option disabled {{ $candidate['remark_id'] == 5 ? 'selected' : '' }}>
        Send To</option>
    <option value="7" {{ $candidate['remark_id'] == 7 ? 'selected' : '' }}>
        KIV</option>
    <option value="10" {{ $candidate['remark_id'] == 10 ? 'selected' : '' }}>
        Drop</option>
    <option value="8" {{ $candidate['remark_id'] == 8 ? 'selected' : '' }}>
        Blacklist</option>
</select>
