<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Success HR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Build with Digipixel Singapore" name="description" />
    <meta content="Digipixel" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">

    <!-- include head css -->
    @include('layouts.head-css')
</head>

<body>
    <div class="authentication-bg min-vh-100">
        <!--<div class="bg-overlay bg-light"></div> -->
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="mb-4 pb-2">
                            <a href="index" class="d-block auth-logo">
                                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="50"
                                    class="auth-logo-dark me-start">
                                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="50"
                                    class="auth-logo-light me-start">
                            </a>
                        </div>

                        @yield('content')

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center p-4">
                            <p>©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Success HR, Design & Developed By <a class="text-dark" href="https://digipixel.sg"
                                    traget="_blank">Digipixel</a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>
    <!-- end authentication section -->
    <!-- vendor-scripts -->
    @include('layouts.vendor-scripts')

</body>

</html>