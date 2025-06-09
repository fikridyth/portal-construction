<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['tenaga-kerja.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['tenaga-kerja.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Tenaga Kerja</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('tenaga-kerja.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label" for="nama">Nama tenaga-kerja: <span class="text-danger">*</span></label>
                                {{ Form::text('nama', $data->nama ?? old('nama'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama Tenaga Kerja', 'required']) }}
                            </div>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-primary" disabled>{{$id !== null ? 'Ubah' : 'Tambah' }} Data Tenaga Kerja</button>
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