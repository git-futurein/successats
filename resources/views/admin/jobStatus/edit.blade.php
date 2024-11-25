<form action="{{ route('job-status.update', $data->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <label for="reason_of_blacklist">Name</label>
    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name', $data->name) }}">
    <label for="reason_of_blacklist">Status</label>
    <select name="status" id="" class="form-control">
        <option value="1"{{ $data->status == 1 ? 'selected' : '' }}>Action</option>
        <option value="0"{{ $data->status == 0 ? 'selected' : '' }}>In-Action</option>
    </select>
    <button type="submit" class="btn btn-sm btn-info mt-3">Submit</button>
</form>
