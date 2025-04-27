@push('styles')
    <style>
        .responsive-width {
            width: 100%;
        }

        @media (min-width: 768px) {
            .responsive-width {
                width: 90%;
            }
        }
    </style>
@endpush

<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['laporan-harian.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['laporan-harian.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Laporan Harian</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('laporan-harian.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
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
                                <label class="form-label" style="font-size: 15px;" for="minggu_ke">Minggu Ke: <span class="text-danger">*</span></label>
                                {{ Form::text('minggu_ke', $data->minggu_ke ?? old('minggu_ke'), ['class' => 'form-control placeholder-grey', 'id' => 'minggu_ke', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="hari">Hari: <span class="text-danger">*</span></label>
                                {{ Form::text('hari', $data->hari ?? old('hari'), ['class' => 'form-control placeholder-grey', 'id' => 'hari', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="tanggal">Tanggal: <span class="text-danger">*</span></label>
                                {{ Form::date('tanggal', $data->tanggal ?? old('tanggal'), ['class' => 'form-control placeholder-grey', 'id' => 'tanggal', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
                            </div>
                        </div>
                        <div class="d-flex flex-wrap align-items-start gap-3">
                            <div class="card mx-auto responsive-width" style="flex: 1 1 45%;">
                                <div class="card-header text-center">
                                    <h5 class="mb-0 fw-bold">List Tenaga Kerja</h5>
                                </div>
                                <div class="card-body row tenaga-kerja-wrapper">
                                    <div class="row tenaga-kerja-item">
                                        <div class="col-md-7">
                                            <label class="form-label" for="keahlian">Keahlian: <span class="text-danger">*</span></label>
                                            {{ Form::select('tenaga[0][keahlian]', $dataTenaga->pluck('nama', 'id'), null, [
                                                'class' => 'form-control placeholder-grey',
                                                'placeholder' => 'Pilih Tenaga Kerja',
                                                'required',
                                                'id' => 'id_tenaga'
                                            ]) }}
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="jumlah">Jumlah: <span class="text-danger">*</span></label>
                                            {{ Form::number('tenaga[0][jumlah]', null, ['class' => 'form-control placeholder-grey', 'placeholder' => 'Jumlah']) }}
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end mt-2">
                                            <button type="button" class="btn btn-success btn-add-tenaga w-100">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="card mx-auto responsive-width" style="flex: 1 1 45%;">
                                <div class="card-header text-center">
                                    <h5 class="mb-0 fw-bold">List Bahan Bangunan</h5>
                                </div>
                                <div class="card-body row bahan-bangunan-wrapper">
                                    <div class="row bahan-bangunan-item">
                                        <div class="col-md-7">
                                            <label class="form-label" for="bahan">Bahan: <span class="text-danger">*</span></label>
                                            {{ Form::select('bahan[0][bangunan]', $dataBahan->pluck('nama', 'id'), null, [
                                                'class' => 'form-control placeholder-grey',
                                                'placeholder' => 'Pilih Bahan Bangunan',
                                                'required',
                                                'id' => 'id_bahan'
                                            ]) }}
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="jumlah">Jumlah: <span class="text-danger">*</span></label>
                                            {{ Form::number('bahan[0][jumlah]', null, ['class' => 'form-control placeholder-grey', 'placeholder' => 'Jumlah']) }}
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end mt-2">
                                            <button type="button" class="btn btn-success btn-add-bahan w-100">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Laporan Harian</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
 </x-app-layout>

 <script>
    document.getElementById('id_proyek').addEventListener('change', function() {
        const proyekId = this.value;

        if (proyekId) {
            fetch(`/get-data-proyek/${proyekId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('minggu_ke').value = data.minggu_ke;
                    document.getElementById('hari').value = data.hari;
                    document.getElementById('tanggal').value = data.tanggal;
                })
                .catch(error => {
                    console.error('Gagal mengambil data harian:', error);
                    document.getElementById('minggu_ke').value = '';
                    document.getElementById('hari').value = '';
                    document.getElementById('tanggal').value = '';
                });
        } else {
            document.getElementById('minggu_ke').value = '';
            document.getElementById('hari').value = '';
            document.getElementById('tanggal').value = '';
        }
    });

    $(document).ready(function () {
        // Tenaga
        let indexT = 1;
        let dataTenaga = {!! json_encode($dataTenaga) !!};
        function createSelectTenaga(indexB) {
            let select = `<select name="tenaga[${indexB}][keahlian]" class="form-control placeholder-grey" required>`;
            select += `<option value="">Pilih Tenaga Kerja</option>`;
            dataTenaga.forEach(item => {
                select += `<option value="${item.id}">${item.nama}</option>`;
            });
            select += `</select>`;
            return select;
        }

        $(document).on('click', '.btn-add-tenaga', function () {
            let newItem = `
                <div class="row tenaga-kerja-item mt-2">
                    <div class="col-md-7">
                        ${createSelectTenaga(indexT)}
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="tenaga[${indexT}][jumlah]" class="form-control placeholder-grey" placeholder="Jumlah">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-remove-tenaga w-100">-</button>
                    </div>
                </div>
            `;
            $('.tenaga-kerja-wrapper').append(newItem);
            indexT++;
        });

        $(document).on('click', '.btn-remove-tenaga', function () {
            $(this).closest('.tenaga-kerja-item').remove();
        });

        // Bahan
        let indexB = 1;
        let dataBahan = {!! json_encode($dataBahan) !!};
        function createSelectBahan(indexB) {
            let select = `<select name="bahan[${indexB}][bangunan]" class="form-control placeholder-grey" required>`;
            select += `<option value="">Pilih Bahan Bangunan</option>`;
            dataBahan.forEach(item => {
                select += `<option value="${item.id}">${item.nama}</option>`;
            });
            select += `</select>`;
            return select;
        }

        $(document).on('click', '.btn-add-bahan', function () {
            let newItem = `
                <div class="row bahan-bangunan-item mt-2">
                    <div class="col-md-7">
                        ${createSelectBahan(indexB)}
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="bahan[${indexB}][jumlah]" class="form-control placeholder-grey" placeholder="Jumlah">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-remove-bahan w-100">-</button>
                    </div>
                </div>
            `;
            $('.bahan-bangunan-wrapper').append(newItem);
            indexB++;
        });

        $(document).on('click', '.btn-remove-bahan', function () {
            $(this).closest('.bahan-bangunan-item').remove();
        });
    });
 </script>