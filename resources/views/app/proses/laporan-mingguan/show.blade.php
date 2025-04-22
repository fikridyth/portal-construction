<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
        <div class="card mt-2">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Lihat Data Laporan Mingguan</h4>
                </div>
                <div class="card-action">
                    <a href="{{ route('laporan-mingguan.print', $data->id) }}" class="btn btn-sm btn-success mx-2"
                        style="min-width: 100px;" role="button">Print</a>
                    <a href="{{ route('laporan-mingguan.index') }}" class="btn btn-sm btn-primary" style="min-width: 100px;"
                        role="button">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="new-user-info">
                    <div class="row">
                        <div class="form-group col-md-5">
                            <label class="form-label" for="nama">Nama Pekerjaan:</label>
                            {{ Form::text('nama', $data->proyek->nama, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-1">
                            <label class="form-label" for="nama">Minggu Ke:</label>
                            {{ Form::text('nama', $data->minggu_ke, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Masa Pelaksanaan:</label>
                            {{ Form::text('nama', $masaPelaksanaan, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        {{-- <div class="form-group col-md-2">
                            <label class="form-label" for="nama">Selesai:</label>
                            {{ Form::text('nama', $data->proyek->sampai, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div> --}}
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Tahun Anggaran:</label>
                            {{ Form::text('nama', $data->proyek->tahun_anggaran, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Lokasi Pekerjaan:</label>
                            {{ Form::text('nama', $data->proyek->lokasi, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Kontrak:</label>
                            {{ Form::text('nama', $data->proyek->kontrak, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Pelaksana:</label>
                            {{ Form::text('nama', $data->proyek->pelaksana, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Direktur:</label>
                            {{ Form::text('nama', $data->proyek->direktur, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                    </div>
                    <hr>
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Total Progress</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Bobot Rencana:</label>
                            {{ Form::text('nama', $data->bobot_rencana, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Bobot Minggu Lalu:</label>
                            {{ Form::text('nama', $data->bobot_minggu_lalu, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Bobot Minggu Ini:</label>
                            {{ Form::text('nama', $data->bobot_minggu_ini, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Total Bobot:</label>
                            {{ Form::text('nama', $data->bobot_total, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                    </div>
                    <hr>
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Detail Progress</h4>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered yajra-datatable" id="progressTable">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">No</th>
                                    <th rowspan="2" class="text-center align-middle">Pekerjaan</th>
                                    <th rowspan="2" class="text-center align-middle">Uraian Pekerjaan</th>
                                    <th rowspan="2" class="text-center align-middle">Volume</th>
                                    <th rowspan="2" class="text-center align-middle">Satuan</th>
                                    <th class="text-center align-middle">Bobot</th>
                                    <th colspan="2" class="text-center align-middle">Total Progress Minggu Lalu</th>
                                    <th colspan="2" class="text-center align-middle">Total Progress Minggu Ini</th>
                                    <th colspan="2" class="text-center align-middle">Total Progress</th>
                                </tr>
                                <tr>
                                    <th class="text-center align-middle">%</th>
                                    <th class="text-center align-middle">Prestasi</th>
                                    <th class="text-center align-middle">Bobot</th>
                                    <th class="text-center align-middle">Prestasi</th>
                                    <th class="text-center align-middle">Bobot</th>
                                    <th class="text-center align-middle">Prestasi</th>
                                    <th class="text-center align-middle">Bobot</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (json_decode($data->list_pekerjaan, true) as $dt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $job[$dt['id_pekerjaan']]->nama ?? '-' }}</td>
                                        <td>{{ $dt['nama_pekerjaan'] }}</td>
                                        <td class="text-end">{{ $dt['volume'] }}</td>
                                        <td class="text-center">{{ $dt['satuan'] }}</td>
                                        <td class="text-end">{{ $dt['bobot'] }}</td>
                                        <td class="text-center">{{ $dt['progress_minggu_lalu'] }} %</td>
                                        <td class="text-end">{{ $dt['bobot_minggu_lalu'] }}</td>
                                        <td class="text-center">{{ $dt['progress_minggu_ini'] }} %</td>
                                        <td class="text-end">{{ $dt['bobot_minggu_ini'] }}</td>
                                        <td class="text-center">{{ $dt['progress_total'] }} %</td>
                                        <td class="text-end">{{ $dt['bobot_total'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
