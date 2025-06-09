<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['cco-pekerjaan.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['cco-pekerjaan.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data CCO</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('proyek.show', $data->id_proyek ?? $dataProyek->id)}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            {{ Form::text('id_proyek', $data->id_proyek ?? $dataProyek->id, ['class' => 'form-control placeholder-grey', 'placeholder' => 'Id Proyek', 'hidden']) }}
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama_proyek">Nama Proyek: <span class="text-danger">*</span></label>
                                {{ Form::text('nama_proyek', $data->proyek->nama ?? $dataProyek->nama, ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama Proyek', 'readonly']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama">Nama: <span class="text-danger">*</span></label>
                                {{ Form::text('nama', $data->nama ?? old('nama'), ['class' => 'form-control placeholder-grey', 'id' => 'nama', 'placeholder' => 'Isi Nama', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="volume">Volume: <span class="text-danger">*</span></label>
                                {{ Form::text('volume', $data->volume ?? old('volume'), ['class' => 'form-control placeholder-grey', 'id' => 'volume', 'placeholder' => 'Isi Volume', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="harga">Harga:</label>
                                {{ Form::text('harga', (int)str_replace(',', '', $data->harga ?? '') ?? old('harga'), ['class' => 'form-control placeholder-grey', 'id' => 'harga', 'placeholder' => 'Isi Harga', 'oninput' => "this.value = this.value.replace(/,/g, '')"]) }}
                            </div>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-primary" disabled>{{$id !== null ? 'Ubah' : 'Tambah' }} Data CCO</button>
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