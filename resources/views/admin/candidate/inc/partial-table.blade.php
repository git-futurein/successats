<table class="table table-bordered dataTable no-footer">
    <thead>
        <tr>
            <th>NO</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Resume</th>
            <th class="text-end">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $data)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->phone_no }}</td>
                <td><a target="_blank" href="{{ asset('storage') }}/{{ $data->resume_path }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a></td>
                <td class="d-flex flex-row-reverse">
                    <form action="{{ route('temporary.data.delete', $data->id) }}" method="POST">
                        @csrf
                        <button {{$data->status == 0 ? '' : 'hidden'}} class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i></button>
                    </form>
                    @if($data->status == 1)
                        <a href="{{ route('candidate.edit', $data->candidate_id) }}"  class="btn btn-success btn-sm">Candidate</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
