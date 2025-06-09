<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['bahan.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['bahan.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Bahan</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('bahan.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama">Nama Bahan: <span class="text-danger">*</span></label>
                                {{ Form::text('nama', $data->nama ?? old('nama'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama Bahan', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="satuan">Satuan: <span class="text-danger">*</span></label>
                                {{ Form::text('satuan', $data->satuan ?? old('satuan'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Satuan', 'required']) }}
                            </div>
                            <label class="form-label text-center" style="font-size: 18px;"><b>Input salah satu harga dibawah</b></label>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="harga_modal_material">Harga Modal Material:</label>
                                {{ Form::number('harga_modal_material', $data->harga_modal_material ?? old('harga_modal_material'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Harga Modal Material']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="harga_modal_upah">Harga Modal Upah:</label>
                                {{ Form::number('harga_modal_upah', $data->harga_modal_upah ?? old('harga_modal_upah'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Harga Modal Upah']) }}
                            </div>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-primary" disabled>{{$id !== null ? 'Ubah' : 'Tambah' }} Data Bahan</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
 </x-app-layout>
 
 <script>
    $(document).ready(function() {
        toggleSubmitButton();
    
        // Listen ke semua input yang required + harga_modal_material + harga_modal_upah
        $('input[required], input[name="harga_modal_material"], input[name="harga_modal_upah"]').on('input', function() {
            toggleSubmitButton();
        });
    
        function toggleSubmitButton() {
            let allRequiredFilled = true;
    
            // Pastikan semua required field terisi
            $('input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    allRequiredFilled = false;
                }
            });
    
            // Hitung berapa harga yang diisi
            let hargaMaterial = $('input[name="harga_modal_material"]').val().trim();
            let hargaUpah = $('input[name="harga_modal_upah"]').val().trim();
            let hargaTerisi = 0;
            if (hargaMaterial !== '') hargaTerisi++;
            if (hargaUpah !== '') hargaTerisi++;
    
            // Tombol aktif jika required terisi semua DAN hanya satu harga yang diisi
            if (allRequiredFilled && hargaTerisi === 1) {
                $('#submitButton').prop('disabled', false);
            } else {
                $('#submitButton').prop('disabled', true);
            }
        }
    });
 </script>