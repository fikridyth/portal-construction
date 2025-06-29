<!-- Backend Bundle JavaScript -->
<script src="{{ asset('js/libs.min.js') }}"></script>
@if (in_array('data-table', $assets ?? []))
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endif
@if (in_array('chart', $assets ?? []))
    <!-- apexchart JavaScript -->
    <script src="{{ asset('js/charts/apexcharts.js') }}"></script>
    <!-- widgetchart JavaScript -->
    <script src="{{ asset('js/charts/widgetcharts.js') }}"></script>
    <script src="{{ asset('js/charts/dashboard.js') }}"></script>
@endif

<!-- mapchart JavaScript -->
<script src="{{ asset('vendor/Leaflet/leaflet.js') }} "></script>
<script src="{{ asset('js/charts/vectore-chart.js') }}"></script>


<!-- fslightbox JavaScript -->
<script src="{{ asset('js/plugins/fslightbox.js') }}"></script>
<script src="{{ asset('js/plugins/slider-tabs.js') }}"></script>
<script src="{{ asset('js/plugins/form-wizard.js') }}"></script>

<!-- settings JavaScript -->
<script src="{{ asset('js/plugins/setting.js') }}"></script>

<script src="{{ asset('js/plugins/circle-progress.js') }}"></script>
@if (in_array('animation', $assets ?? []))
    <!--aos javascript-->
    <script src="{{ asset('vendor/aos/dist/aos.js') }}"></script>
@endif

@if (in_array('calender', $assets ?? []))
    <!-- Fullcalender Javascript -->
    <script src="{{ asset('vendor/fullcalendar/core/main.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/daygrid/main.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/timegrid/main.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/list/main.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/interaction/main.js') }}"></script>
    <script src="{{ asset('vendor/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/calender.js') }}"></script>
@endif

<script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker-full.js') }}"></script>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DataTables Buttons extension -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- JSZip untuk export Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

{{-- Daterange Picker --}}
<script src="{{ asset('js/daterangepicker.min.js') }}"></script>

@stack('scripts')

<script src="{{ asset('js/plugins/prism.mini.js') }}"></script>

<!-- Custom JavaScript -->
<script src="{{ asset('js/hope-ui.js') }}"></script>
<script src="{{ asset('js/modelview.js') }}"></script>
