@if($errors->any())
    <div class="col-md-12">
        <div class="alert alert-danger">
            <strong>{{$errors->first()}}</strong>
        </div>
    </div>
@endif
