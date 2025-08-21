<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
        <div class="card mt-2">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Lihat Data Proyek</h4>
                </div>
                <div class="card-action">
                    <a href="{{ route('proyek.edit', enkrip($data->id)) }}" class="btn btn-sm btn-warning mx-2"
                        style="min-width: 100px;" role="button">Edit</a>
                    <a href="{{ route('proyek.index') }}" class="btn btn-sm btn-primary mx-2" style="min-width: 100px;"
                        role="button">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="new-user-info">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label" for="nama">Nama Proyek:</label>
                            {{ Form::text('nama', $data->nama ?? old('nama'), ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="lokasi">Lokasi Proyek:</label>
                            {{ Form::text('lokasi', $data->lokasi ?? old('lokasi'), ['class' => 'form-control', 'placeholder' => 'Isi Data Lokasi Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="tahun_anggaran">Tahun Anggaran:</label>
                            {{ Form::text('tahun_anggaran', $data->tahun_anggaran ?? old('tahun_anggaran'), ['class' => 'form-control', 'id' => 'tahun_anggaran', 'placeholder' => 'Isi Data Tahun Anggaran', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="kontrak">Kontrak:</label>
                            {{ Form::text('kontrak', $data->kontrak ?? old('kontrak'), ['class' => 'form-control', 'id' => 'kontrak', 'placeholder' => 'Isi Data Kontrak', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="pelaksana">Pelaksana:</label>
                            {{ Form::text('pelaksana', $data->pelaksana ?? old('pelaksana'), ['class' => 'form-control', 'id' => 'pelaksana', 'placeholder' => 'Isi Data Pelaksana', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="direktur">Direktur:</label>
                            {{ Form::text('direktur', $data->direktur ?? old('direktur'), ['class' => 'form-control', 'id' => 'direktur', 'placeholder' => 'Isi Data Direktur', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="dari">Tanggal Mulai:</label>
                            {{ Form::date('dari', $data->dari ?? old('dari'), ['class' => 'form-control', 'id' => 'dari', 'placeholder' => 'Isi Data Tanggal Mulai', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="sampai">Tanggal Selesai:</label>
                            {{ Form::date('sampai', $data->sampai ?? old('sampai'), ['class' => 'form-control', 'id' => 'sampai', 'placeholder' => 'Isi Data Tanggal Selesai', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="waktu_pelaksanaan">Waktu Pelaksanaan:</label>
                            {{ Form::text('waktu_pelaksanaan', $data->waktu_pelaksanaan ?? old('waktu_pelaksanaan'), ['class' => 'form-control', 'id' => 'waktu_pelaksanaan', 'placeholder' => 'Isi Data Waktu Pelaksanaan', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="total_meter">Luas Bangunan:</label>
                            {{ Form::text('total_meter', $data->total_meter ?? old('total_meter'), ['class' => 'form-control', 'id' => 'total_meter', 'placeholder' => 'Isi Data Luas Bangunan', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label" for="user_pm">User Project Manager:</label>
                            {{ Form::text('user_pm', $data->manager->first_name . ' ' . $data->manager->last_name ?? old('user_pm'), ['class' => 'form-control', 'id' => 'user_pm', 'placeholder' => 'Isi Data Luas Bangunan', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label" for="user_spv">User Supervisor:</label>
                            {{ Form::text('user_spv', $data->supervisor->first_name . ' ' . $data->supervisor->last_name ?? old('user_spv'), ['class' => 'form-control', 'id' => 'user_spv', 'placeholder' => 'Isi Data Luas Bangunan', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label" for="user_purchasing">User Finance:</label>
                            {{ Form::text('user_purchasing', $data->purchasing->first_name . ' ' . $data->purchasing->last_name ?? old('user_purchasing'), ['class' => 'form-control', 'id' => 'user_purchasing', 'placeholder' => 'Isi Data Luas Bangunan', 'disabled']) }}
                        </div>
                        <div class="d-flex justify-content-center my-3">
                            <a href="{{ route('proyek.print-rab', enkrip($data->id)) }}"
                                class="btn btn-sm btn-success mx-4" style="min-width: 100px;" role="button">Print
                                Rencana Anggaran Biaya</a>
                            <a href="{{ route('proyek.print-rekap', enkrip($data->id)) }}"
                                class="btn btn-sm btn-success mx-4" style="min-width: 100px;" role="button">Print
                                Rekapitulasi Biaya</a>
                            <a href="{{ route('proyek.print-boq', enkrip($data->id)) }}"
                                class="btn btn-sm btn-success mx-4" style="min-width: 100px;" role="button">Print Bill
                                of Quantity</a>
                        </div>
                    </div>
                    <hr>
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Data Pekerjaan</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('proyek.detail-pekerjaan.create', enkrip($data->id)) }}"
                                class="btn btn-sm btn-primary" role="button">
                                Tambah Detail Pekerjaan
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered yajra-datatable" id="pekerjaanTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pekerjaan</th>
                                    <th>Nama</th>
                                    <th>Volume</th>
                                    <th>Bobot (%)</th>
                                    <th>Bahan</th>
                                    <th>RAB Modal Material</th>
                                    <th>RAB Modal Upah</th>
                                    <th>RAB Jual Satuan</th>
                                    <th>RAB Jual Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <hr>
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Data CCO</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('proyek.cco-pekerjaan.print', enkrip($data->id)) }}"
                                class="btn btn-sm btn-success mx-4" style="min-width: 100px;" role="button">Print
                                Rencana Anggaran Biaya dengan CCO</a>
                            <a href="{{ route('proyek.cco-pekerjaan.create', enkrip($data->id)) }}"
                                class="btn btn-sm btn-primary" role="button">
                                Tambah Data CCO
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered yajra-datatable" style="width: 100%;" id="ccoTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Volume</th>
                                    <th>Harga</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Konten akan diisi lewat JS -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $(function() {
        $('#pekerjaanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('proyek.detail-pekerjaan.index', $data->id) }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'nama_pekerjaan',
                    name: 'nama_pekerjaan'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'volume',
                    name: 'volume'
                },
                {
                    data: 'bobot',
                    name: 'bobot'
                },
                {
                    data: 'is_bahan',
                    name: 'is_bahan'
                },
                {
                    data: 'harga_modal_material',
                    name: 'harga_modal_material'
                },
                {
                    data: 'harga_modal_upah',
                    name: 'harga_modal_upah'
                },
                {
                    data: 'harga_jual_satuan',
                    name: 'harga_jual_satuan'
                },
                {
                    data: 'harga_jual_total',
                    name: 'harga_jual_total'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

        $('#ccoTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('proyek.cco-pekerjaan.index', $data->id) }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'volume',
                    name: 'volume'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'total_harga',
                    name: 'total_harga'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
    });

    $(document).on('click', '.btn-show-modal', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const detail = $(this).data('detail');
        let html = '';

        detail.forEach((item, index) => {
            html += `
            <div class="mb-3 border-bottom pb-2">
                <p><strong>${index + 1}. ${item.nama_bahan}</strong></p>
                <p>Volume: ${item.volume} ${item.satuan}</p>
                <p>Harga Satuan: Rp ${parseInt(item.harga_modal_upah ?? item.harga_modal_material).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                <p>Total: Rp ${parseInt(item.total).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
            </div>
        `;
        });

        $('#modalTitle').text(`Detail bahan dari pekerjaan ${nama}:`);
        $('#modalBody').html(html);

        $('#myModal').modal('show');
    });
</script>
