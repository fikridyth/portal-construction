<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
        <div class="card mt-2">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Lihat Data Rekapitulasi Biaya</h4>
                </div>
                <div class="card-action">
                    <a href="{{ route('rekapitulasi-biaya.show', enkrip($data->id)) }}" class="btn btn-sm btn-success mx-2"
                        style="min-width: 100px;" role="button">Print</a>
                    <a href="{{ route('rekapitulasi-biaya.index') }}" class="btn btn-sm btn-primary mx-2" style="min-width: 100px;"
                        role="button">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="new-user-info">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="form-label" for="nama">Bulan:</label>
                            {{ Form::text('nama', $bulan ?? old('nama'), ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="lokasi">Nama:</label>
                            {{ Form::text('lokasi', $data->name ?? old('lokasi'), ['class' => 'form-control', 'placeholder' => 'Isi Data Lokasi Proyek', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="tahun_anggaran">No Account:</label>
                            {{ Form::text('tahun_anggaran', $data->account ?? old('tahun_anggaran'), ['class' => 'form-control', 'id' => 'tahun_anggaran', 'placeholder' => 'Isi Data Tahun Anggaran', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="kontrak">Satuan:</label>
                            {{ Form::text('kontrak', $data->currency ?? old('kontrak'), ['class' => 'form-control', 'id' => 'kontrak', 'placeholder' => 'Isi Data Kontrak', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="pelaksana">Saldo Awal:</label>
                            {{ Form::text('pelaksana', number_format($data->starting_balance, 2) ?? old('pelaksana'), ['class' => 'form-control', 'id' => 'pelaksana', 'placeholder' => 'Isi Data Pelaksana', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="direktur">Credit:</label>
                            {{ Form::text('direktur', number_format($data->credit, 2) ?? old('direktur'), ['class' => 'form-control', 'id' => 'direktur', 'placeholder' => 'Isi Data Direktur', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="test">Debet:</label>
                            {{ Form::text('test', number_format($data->debet, 2) ?? old('test'), ['class' => 'form-control', 'id' => 'test', 'placeholder' => 'Isi Data test', 'disabled']) }}
                        </div>
                        <div class="form-group col-md-3">
                            <label class="form-label" for="test2">Saldo Akhir:</label>
                            {{ Form::text('test2', number_format($data->ending_balance, 2) ?? old('test2'), ['class' => 'form-control', 'id' => 'test2', 'placeholder' => 'Isi Data test2', 'disabled']) }}
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive mt-4">
                        <label class="form-label" for="test2">Detail Transaksi:</label>
                        <table class="table table-bordered yajra-datatable" id="pekerjaanTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Branch</th>
                                    <th>Tipe</th>
                                    <th>Kode</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                    <th>Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($data->data, true) as $dt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dt['Date'] }}</td>
                                        <td>{{ $dt['Branch'] }}</td>
                                        <td>{{ $dt['Tipe'] }}</td>
                                        <td>{{ $dt['Code'] }}</td>
                                        <td>{{ $dt['Desc'] }}</td>
                                        <td>{{ number_format($dt['Amount'], 2) }}</td>
                                        <td>{{ number_format($dt['Balance'], 2) }}</td>
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
