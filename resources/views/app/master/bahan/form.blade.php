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
                        <a href="{{route('bahan.index')}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama">Nama Bahan: <span class="text-danger">*</span></label>
                                {{ Form::text('nama', $data->nama ?? old('nama'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama Bahan', 'required']) }}
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label class="form-label" for="volume">Volume: <span class="text-danger">*</span></label>
                                {{ Form::text('volume', $data->volume ?? old('volume'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Volume', 'required']) }}
                            </div> --}}
                            <div class="form-group col-md-6">
                                <label class="form-label" for="satuan">Satuan: <span class="text-danger">*</span></label>
                                {{ Form::text('satuan', $data->satuan ?? old('satuan'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Satuan', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="harga_modal_material">Harga Modal Material:</label>
                                {{ Form::text('harga_modal_material', $data->harga_modal_material ?? old('harga_modal_material'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Harga Modal Material']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="harga_modal_upah">Harga Modal Upah:</label>
                                {{ Form::text('harga_modal_upah', $data->harga_modal_upah ?? old('harga_modal_upah'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Harga Modal Upah']) }}
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label class="form-label" for="harga_jual">Harga Jual: <span class="text-danger">*</span></label>
                                {{ Form::text('harga_jual', $data->harga_jual ?? old('harga_jual'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Harga Jual', 'required']) }}
                            </div> --}}
                        </div>
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Bahan</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
 </x-app-layout>
 