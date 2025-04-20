<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
        <div class="card mt-2">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Lihat Data Proyek</h4>
                </div>
                <div class="card-action">
                    <a href="{{ route('proyek.print', $data->id) }}" class="btn btn-sm btn-success mx-2" style="min-width: 100px;" role="button">Print</a>
                    <a href="{{ route('proyek.index') }}" class="btn btn-sm btn-primary" style="min-width: 100px;" role="button">Kembali</a>
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
                        {{-- <div class="form-group col-md-12">
                            <label class="form-label" for="cname">Company Name: <span class="text-danger">*</span></label>
                            {{ Form::text('userProfile[company_name]', old('userProfile[company_name]'), ['class' => 'form-control', 'disabled', 'placeholder' => 'Company Name']) }}
                        </div> --}}
                    </div>
                    <hr>
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Data Pekerjaan</h4>
                        </div>
                        <div class="card-action">
                            @if ($dataLaporan)
                                <button class="btn btn-sm btn-secondary" disabled title="Tidak bisa tambah detail, sudah ada laporan">
                                    Tambah Detail Pekerjaan
                                </button>
                            @else
                                <a href="{{ route('proyek.detail-pekerjaan.create', $data->id) }}"
                                    class="btn btn-sm btn-success" role="button">
                                    Tambah Detail Pekerjaan
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered yajra-datatable" id="progressTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Action</th>
                                    <th>Pekerjaan</th>
                                    <th>Nama</th>
                                    <th>Volume</th>
                                    <th>Bobot (%)</th>
                                    <th>Bahan</th>
                                    <th>RAB Modal Material</th>
                                    <th>RAB Modal Upah</th>
                                    <th>RAB Jual Satuan</th>
                                    <th>RAB Jual Total</th>
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
        $('#progressTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('proyek.detail-pekerjaan.index', $data->id) }}",
            columns: [{
                    data: 'no',
                    name: 'no'
                },
                {
                    data: 'action',
                    name: 'action'
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
            ]
        });
    });

    $(document).on('click', '.btn-show-modal', function () {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const detail = $(this).data('detail');
        let html = '';

        detail.forEach((item, index) => {
        html += `
            <div class="mb-3 border-bottom pb-2">
                <p><strong>${index + 1}. ${item.nama_bahan}</strong></p>
                <p>Volume: ${item.volume} ${item.satuan}</p>
                <p>Harga Satuan: Rp ${parseInt(item.harga_modal_upah).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                <p>Total: Rp ${parseInt(item.total).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
            </div>
        `;
        });

        $('#modalTitle').text(`Detail bahan dari pekerjaan ${nama}:`);
        $('#modalBody').html(html);

        $('#myModal').modal('show');
    });
</script>
