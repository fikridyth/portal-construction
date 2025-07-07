<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['proyek.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['proyek.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Proyek</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('proyek.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama">Nama Proyek: <span class="text-danger">*</span></label>
                                {{ Form::text('nama', $data->nama ?? old('nama'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Data Nama Proyek', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="lokasi">Lokasi Proyek: <span class="text-danger">*</span></label>
                                {{ Form::text('lokasi', $data->lokasi ?? old('lokasi'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Data Lokasi Proyek' ,'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="tahun_anggaran">Tahun Anggaran: <span class="text-danger">*</span></label>
                                {{ Form::text('tahun_anggaran', $data->tahun_anggaran ?? old('tahun_anggaran'), ['class' => 'form-control placeholder-grey', 'id' => 'tahun_anggaran', 'placeholder' => 'Isi Data Tahun Anggaran', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="kontrak">Kontrak: <span class="text-danger">*</span></label>
                                {{ Form::text('kontrak', $data->kontrak ?? old('kontrak'), ['class' => 'form-control placeholder-grey', 'id' => 'kontrak', 'placeholder' => 'Isi Data Kontrak', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="pelaksana">Pelaksana: <span class="text-danger">*</span></label>
                                {{ Form::text('pelaksana', $data->pelaksana ?? old('pelaksana'), ['class' => 'form-control placeholder-grey', 'id' => 'pelaksana', 'placeholder' => 'Isi Data Pelaksana', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="direktur">Direktur: <span class="text-danger">*</span></label>
                                {{ Form::text('direktur', $data->direktur ?? old('direktur'), ['class' => 'form-control placeholder-grey', 'id' => 'direktur', 'placeholder' => 'Isi Data Direktur', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="dari">Tanggal Mulai: <span class="text-danger">*</span></label>
                                {{ Form::date('dari', $data->dari ?? old('dari'), ['class' => 'form-control placeholder-grey', 'id' => 'dari', 'placeholder' => 'Isi Data Tanggal Mulai', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="sampai">Tanggal Selesai: <span class="text-danger">*</span></label>
                                {{ Form::date('sampai', $data->sampai ?? old('sampai'), ['class' => 'form-control placeholder-grey', 'id' => 'sampai', 'placeholder' => 'Isi Data Tanggal Selesai', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="total_meter">Total Meter: <span class="text-danger">*</span></label>
                                {{ Form::text('total_meter', $data->total_meter ?? old('total_meter'), ['class' => 'form-control placeholder-grey', 'id' => 'total_meter', 'placeholder' => 'Isi Data Total Meter', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nilai_kontrak">Nilai Kontrak: <span class="text-danger">*</span></label>
                                {{ Form::number('nilai_kontrak', floor($data->nilai_kontrak ?? 0) ?? old('nilai_kontrak'), ['class' => 'form-control placeholder-grey', 'id' => 'nilai_kontrak', 'placeholder' => 'Isi Data Nilai Kontrak', 'required']) }}
                            </div>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-primary" disabled>{{$id !== null ? 'Ubah' : 'Tambah' }} Data Proyek</button>
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