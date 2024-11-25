<!-- JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/jquery"></script>

<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/eva-icons/eva.min.js') }}"></script>
<!-- apexcharts -->
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- gridjs js -->
<script src="{{ URL::asset('build/libs/gridjs/gridjs.umd.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/gridjs.init.js') }}"></script>

<!-- datepicker js -->
<script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
<!-- App js -->
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/metismenu"></script>
<script>
    $('#side-menu').metisMenu();
    $('#side-menu').metisMenu();
    $('#side-menu').metisMenu({
        preventDefault: true
    });
</script>
@yield('scripts')
