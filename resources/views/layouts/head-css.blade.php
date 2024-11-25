@yield('css')
<!-- Bootstrap Css -->
{{-- <link href="{{ URL::asset('build/css/bootstrap.css') }}"  rel="stylesheet" type="text/css" /> --}}
<link href="{{ URL::asset('build/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
{{-- <link href="{{ URL::asset('build/css/icons.css') }}" rel="stylesheet" type="text/css" /> --}}
<link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ URL::asset('build/libs/gridjs/theme/mermaid.min.css') }}">

<!-- datepicker css -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">

{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" rel="stylesheet" /> --}}
<style>
    .form-group.required .form-label:after {
        content: "*" !important;
        color: red !important;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff !important;
    }

    .form-control {
        border-radius: 0.25rem !important;
    }

    .nav-tabs.nav-item {
        height: 100% !important;
    }

    body {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-weight: 400;
        overflow-x: hidden;

    }

    label,
    td,
    th,
    .col-form-label {
        font-size: 13px;
    }

    a.nav-link {
        padding: 5px 2px;
    }
</style>

<link rel="stylesheet" href="{{ asset('custom/custom.css') }}">
