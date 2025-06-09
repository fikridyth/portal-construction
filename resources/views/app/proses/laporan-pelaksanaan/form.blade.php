<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['laporan-pelaksanaan.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['laporan-pelaksanaan.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Laporan Pelaksanaan</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('laporan-pelaksanaan.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama">Proyek: <span class="text-danger">*</span></label>
                                {{ Form::select('id_proyek', $dataProyek->pluck('nama', 'id'), null, [
                                    'class' => 'form-control placeholder-grey',
                                    'placeholder' => 'Pilih Proyek',
                                    'required',
                                    'id' => 'id_proyek'
                                ]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" style="font-size: 14px;" for="bulan_ke">Bulan Ke:</label>
                                {{ Form::text('bulan_ke', $data->bulan_ke ?? old('bulan_ke'), ['class' => 'form-control placeholder-grey', 'id' => 'bulan_ke', 'placeholder' => 'Isi Bulan Ke', "required"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="dari">Dari: <span class="text-danger">*</span></label>
                                {{ Form::date('dari', $data->dari ?? old('dari'), ['class' => 'form-control placeholder-grey', 'id' => 'dari', 'placeholder' => 'Isi Tanggal', "required"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="sampai">Sampai: <span class="text-danger">*</span></label>
                                {{ Form::date('sampai', $data->sampai ?? old('sampai'), ['class' => 'form-control placeholder-grey', 'id' => 'sampai', 'placeholder' => 'Isi Tanggal', "required"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="keadaan_tenaga">Keadaan Tenaga Kerja: <span class="text-danger">*</span></label>
                                <div class="form-check form-switch d-flex align-items-center gap-2">
                                    {{ Form::checkbox('keadaan_tenaga', 1, $data->keadaan_tenaga ?? old('keadaan_tenaga', true), [
                                        'class' => 'form-check-input',
                                        'id' => 'keadaan_tenaga',
                                    ]) }}
                                    <span id="keadaan_tenaga_label">Terlampir</span>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="keadaan_bahan">Keadaan Bahan: <span class="text-danger">*</span></label>
                                <div class="form-check form-switch d-flex align-items-center gap-2">
                                    {{ Form::checkbox('keadaan_bahan', 1, $data->keadaan_bahan ?? old('keadaan_bahan', true), [
                                        'class' => 'form-check-input',
                                        'id' => 'keadaan_bahan',
                                    ]) }}
                                    <span id="keadaan_bahan_label">Terlampir</span>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="keadaan_keuangan">Keadaan Keuangan: <span class="text-danger">*</span></label>
                                <div class="form-check form-switch d-flex align-items-center gap-2">
                                    {{ Form::checkbox('keadaan_keuangan', 1, $data->keadaan_keuangan ?? old('keadaan_keuangan', true), [
                                        'class' => 'form-check-input',
                                        'id' => 'keadaan_keuangan',
                                    ]) }}
                                    <span id="keadaan_keuangan_label">Terlampir</span>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label" for="realisasi">Realisasi Kemajuan (%): <span class="text-danger">*</span></label>
                                {{ Form::text('realisasi', $data->realisasi ?? old('realisasi'), ['class' => 'form-control placeholder-grey', 'id' => 'realisasi', 'placeholder' => 'Isi Realisasi', 'required', 'onkeypress' => "return event.key !== ','"]) }}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label" for="rencana">Rencana Pekerjaan (%): <span class="text-danger">*</span></label>
                                {{ Form::text('rencana', $data->rencana ?? old('rencana'), ['class' => 'form-control placeholder-grey', 'id' => 'rencana', 'placeholder' => 'Isi Rencana', 'required', 'onkeypress' => "return event.key !== ','"]) }}
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label" for="keterangan">Keterangan:</label>
                                {{ Form::textarea('keterangan', $data->keterangan ?? old('keterangan'), ['class' => 'form-control placeholder-grey', 'id' => 'keterangan', 'placeholder' => 'Isi Keterangan', 'rows' => 3]) }}
                            </div>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-primary" disabled>{{$id !== null ? 'Ubah' : 'Tambah' }} Data Laporan Pelaksanaan</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
 </x-app-layout>
 
 <script>
    $(document).ready(function() {
        // Panggil fungsi cek validasi pertama kali
        toggleSubmitButton();
    
        // Event listener untuk setiap input yang required
        $('input[required]').on('input', function() {
            toggleSubmitButton();
        });
    
        function toggleSubmitButton() {
            let allFilled = true;
            $('input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    allFilled = false;
                }
            });
    
            $('#submitButton').prop('disabled', !allFilled);
        }
    });
 </script>