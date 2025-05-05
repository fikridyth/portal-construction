@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div class="mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mt-3">{{ $pageTitle ?? 'List' }}</h4>
                        </div>
                        <div class="card-action">
                            <div class="d-flex justify-content-end">
                                <div class="d-flex align-items-center mt-2 mb-2 fw-bold">
                                    <form action="{{ route('approval.index') }}" method="GET" class="d-flex align-items-center gap-3 flex-wrap">
                                        <div class="d-flex align-items-center me-3">
                                            <label for="statusSelect" class="form-label fw-semibold me-2 mt-2" style="font-size: 18px">Status:</label>
                                            <select class="form-select status-select" id="statusSelect" name="status">
                                                <option value="">Pilih Status</option>
                                                <option value="1">Menunggu Approval Project Manager</option>
                                                <option value="2">Menunggu Approval Owner</option>
                                                <option value="3">Menunggu Pembayaran Finance</option>
                                                <option value="4">Disetujui</option>
                                                <option value="5">Ditolak</option>
                                            </select>
                                        </div>
                                    
                                        <div class="d-flex align-items-center me-3">
                                            <label for="periode" class="form-label fw-semibold me-2 mt-2" style="font-size: 18px">Periode:</label>
                                            <input class="form-control form-control-solid" placeholder="Pilih Periode" autocomplete="off"
                                                id="periode" name="periode" value="{{ request('periode') }}" />
                                        </div>
                                    
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-secondary me-2" id="clear">Clear</button>
                                            <button type="submit" class="btn btn-success" id="apply">Apply</button>
                                        </div>
                                    </form>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table text-center table-striped w-100'], true) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $("#periode").daterangepicker({
        locale: {
            cancelLabel: "Clear",
            format: "YYYY-MM-DD",
            monthNames: [
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
            ],
        },
        dateLimit: {
            days: 375
        },
        autoApply: true
    });

    document.getElementById("periode").value = "{{ request('periode') }}";

    $("#periode").on(
        "apply.daterangepicker",
        function(ev, picker) {
            $(this).val(picker.startDate.format("YYYY-MM-DD") + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        }
    );

    $("#periode").on(
        "cancel.daterangepicker",
        function() {
            $(this).val('');
        }
    );

    var periode = document.getElementById("periode");
    document.getElementById("clear").addEventListener("click", function() {
        periode.value = '';
    });
</script>