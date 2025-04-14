<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
        <div class="card mt-2">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Lihat Data Proyek</h4>
                </div>
                <div class="card-action">
                    <a href="{{route('proyek.index')}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
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
                            {{ Form::text('lokasi', $data->lokasi ?? old('lokasi'), ['class' => 'form-control', 'placeholder' => 'Isi Data Lokasi Proyek' ,'disabled']) }}
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
                            <a href="{{route('proyek.detail-pekerjaan.create', $data->id)}}" class="btn btn-sm btn-success" role="button">Tambah Detail Pekerjaan</a>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered yajra-datatable" id="progressTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </x-app-layout>
 
 @push('scripts')
    <script type="text/javascript">
    $(function () {
        $('#progressTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('proyek.detail-pekerjaan.index', $data->id) }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama', name: 'nama' },
            ]
        });
    });
    </script>
@endpush