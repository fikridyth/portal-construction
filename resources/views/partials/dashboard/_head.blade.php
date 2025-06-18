<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/adp.png') }}" />

{{-- Other --}}
<link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/hope-ui.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/custom.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/dark.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/rtl.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/customizer.css?v=1.1.0') }}">
<link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}" />
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">\ --}}
{{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}

<!-- Fullcalender CSS -->
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/core/main.css') }}" />
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/daygrid/main.css') }}" />
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/timegrid/main.css') }}" />
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/list/main.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/Leaflet/leaflet.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}" />

<link rel="stylesheet" href="{{ asset('vendor/aos/dist/aos.css') }}" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">

{{-- Select 2 --}}<!-- Select2 with Bootstrap 4 theme -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.3.1/dist/select2-bootstrap4.min.css" rel="stylesheet" />

{{-- Font --}}
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Lato', sans-serif;
    }

    th.hide-search input {
        display: none;
    }

    /* table.table-bordered th,
    table.table-bordered td,
    table.table-bordered tr {
        border: 1px solid black !important;
    }

    table.table-bordered {
        border-collapse: collapse !important;
    } */

    .placeholder-grey::placeholder {
        color: #c4ced9;
        opacity: 1;
    }
</style>
@stack('styles')
