<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Success HR</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Build with Digipixel Singapore" name="description" />
    <meta content="Digipixel" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    <script src="https://kit.fontawesome.com/6cc5870d50.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!-- include head css -->
    @include('layouts.head-css')
    <!--link rel="stylesheet" href="{{asset('build/css/style.css')}}"-->
</head>

@yield('body')

<!-- Begin page -->
<div id="layout-wrapper">
    <!-- topbar -->
    @include('layouts.topbar')

    <!-- sidebar components -->
    @include('layouts.sidebar')
    @include('layouts.horizontal')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        @include('layouts.footer')

    </div>
</div>
@include('layouts.right-sidebar')

@include('layouts.vendor-scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });

    // $(document).ready(function() {
    //     $('.notification-item').click(function(event) {
    //         event.preventDefault();
    //         let $notificationItem = $(this);
    //         let notificationId = $notificationItem.data('notification-id');

    //         $.ajax({
    //             url: '/notifications/' + notificationId + '/mark-as-read',
    //             type: 'POST',
    //             dataType: 'json',
    //             data: {
    //                 _token: '{{ csrf_token() }}'
    //             },
    //             success: function(response) {
    //                 console.log(response);
    //                 if (response.status == true) {
    //                     $notificationItem.removeClass('text-reset').addClass('text-muted');
    //                     $notificationItem.find('.avatar-title i').removeClass('fa-phone').addClass('fa-phone-slash');
    //                 } else {
    //                     console.error('Failed to mark notification as read:', response.message);
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error(xhr.responseText);
    //             }
    //         });
    //     });
    // });

    // document.addEventListener('keydown', function(event) {
    //     if (event.ctrlKey && event.shiftKey && event.key === 'I') {
    //         event.preventDefault();
    //     }
    // });
</script>
</body>
</html>
