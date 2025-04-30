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
       {!! Form::model($data, ['route' => ['preorder.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['preorder.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Preorder</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('preorder.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
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
                                <label class="form-label" for="minggu_ke">Minggu Ke: <span class="text-danger">*</span></label>
                                {{ Form::text('minggu_ke', $data->minggu_ke ?? old('minggu_ke'), ['class' => 'form-control placeholder-grey', 'id' => 'minggu_ke', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="dari">Dari: <span class="text-danger">*</span></label>
                                {{ Form::date('dari', $data->dari ?? old('dari'), ['class' => 'form-control placeholder-grey', 'id' => 'dari', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="sampai">Sampai: <span class="text-danger">*</span></label>
                                {{ Form::date('sampai', $data->sampai ?? old('sampai'), ['class' => 'form-control placeholder-grey', 'id' => 'sampai', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
                            </div>
                            <div class="card mx-auto responsive-width">
                                <div class="card-header text-center">
                                    <h5 class="mb-0 fw-bold">List Preorder
                                </div>
                                <div class="card-body row preorder-wrapper">
                                    <div class="row preorder-item">
                                        <div class="col-md-3">
                                            <label class="form-label" for="nama_preorder">Nama: <span class="text-danger">*</span></label>
                                            {{ Form::text('preorder[0][nama]', null, ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'required']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="volume">Volume: <span class="text-danger">*</span></label>
                                            {{ Form::number('preorder[0][volume]', null, ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Volume', 'required']) }}
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label" for="satuan">Satuan: <span class="text-danger">*</span></label>
                                            {{ Form::text('preorder[0][satuan]', null, ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Satuan', 'required']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="harga">Harga: <span class="text-danger">*</span></label>
                                            {{ Form::number('preorder[0][harga]', null, ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Harga', 'required']) }}
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end mt-2">
                                            <button type="button" class="btn btn-success btn-add w-100">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>                          
                        </div>
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Preorder</button>
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
            fetch(`/get-preorder-minggu-ke/${proyekId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('minggu_ke').value = data.minggu_ke;
                    document.getElementById('dari').value = data.dari;
                    document.getElementById('sampai').value = data.sampai;
                })
                .catch(error => {
                    console.error('Gagal mengambil data minggu ke:', error);
                    document.getElementById('minggu_ke').value = '';
                    document.getElementById('dari').value = '';
                    document.getElementById('sampai').value = '';
                });
        } else {
            document.getElementById('minggu_ke').value = '';
            document.getElementById('dari').value = '';
            document.getElementById('sampai').value = '';
        }
    });

    $(document).ready(function () {
        let index = 1;
        $(document).on('click', '.btn-add', function () {
            let newItem = `
                <div class="row preorder-item mt-2">
                    <div class="col-md-3">
                        <input type="number" name="preorder[${index}][nama]" class="form-control placeholder-grey" placeholder="Isi Nama" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="preorder[${index}][volume]" class="form-control placeholder-grey" placeholder="Isi Volume" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="preorder[${index}][satuan]" class="form-control placeholder-grey" placeholder="Isi Satuan" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="preorder[${index}][harga]" class="form-control placeholder-grey" placeholder="Isi Harga" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-remove w-100">-</button>
                    </div>
                </div>
            `;
            $('.preorder-wrapper').append(newItem);
            index++;
        });

        $(document).on('click', '.btn-remove', function () {
            $(this).closest('.preorder-item').remove();
        });
    });
</script>