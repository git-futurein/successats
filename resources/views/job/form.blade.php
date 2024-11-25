



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
        <form action="{{ route('job.apply')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <fieldset>
                <legend class="fw-bold"><u>Apply for this job</u></legend>

                <input type="hidden" name="job_id" value="{{ $job->id }}">
                <div class="row">
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="name">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="0178956744">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="cv" class="form-label">Cv</label>
                            <input type="file" class="form-control" name="cv" id="cv">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="mb-3">
                            <label for="remark" class="form-label">remark</label>
                            <textarea class="form-control" name="remark" id="remark"  rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Apply For Job</button>
            </fieldset>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  </body>
</html>
