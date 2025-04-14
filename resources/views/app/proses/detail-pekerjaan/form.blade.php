<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['detail-pekerjaan.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['detail-pekerjaan.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Detail Pekerjaan</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('detail-pekerjaan.index')}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            {{ Form::text('id_proyek', $dataProyek->id, ['class' => 'form-control', 'placeholder' => 'Id Proyek', 'hidden']) }}
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama_proyek">Nama Proyek: <span class="text-danger">*</span></label>
                                {{ Form::text('nama_proyek', $dataProyek->nama, ['class' => 'form-control', 'placeholder' => 'Isi Data Nama Proyek', 'readonly']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="id_pekerjaan">Pilih Pekerjaan: <span class="text-danger">*</span></label>
                                {{ Form::select('id_pekerjaan', $dataPekerjaan->pluck('nama', 'id'), old('id_pekerjaan'), ['class' => 'form-control', 'placeholder' => 'Pilih Pekerjaan', 'required']) }}
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label" for="nama">Nama: <span class="text-danger">*</span></label>
                                {{ Form::text('nama', $data->nama ?? old('nama'), ['class' => 'form-control', 'id' => 'nama', 'placeholder' => 'Isi Data Nama', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="volume">Volume: <span class="text-danger">*</span></label>
                                {{ Form::text('volume', $data->volume ?? old('volume'), ['class' => 'form-control', 'id' => 'volume', 'placeholder' => 'Isi Data Volume', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="satuan">Satuan: <span class="text-danger">*</span></label>
                                {{ Form::text('satuan', $data->satuan ?? old('satuan'), ['class' => 'form-control', 'id' => 'satuan', 'placeholder' => 'Isi Data Satuan', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="harga_modal_material">RAB Modal Material:</label>
                                {{ Form::text('harga_modal_material', $data->harga_modal_material ?? old('harga_modal_material'), ['class' => 'form-control', 'id' => 'harga_modal_material', 'placeholder' => 'Isi Data RAB Modal Material']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="harga_modal_upah">RAB Modal Upah:</label>
                                {{ Form::text('harga_modal_upah', $data->harga_modal_upah ?? old('harga_modal_upah'), ['class' => 'form-control', 'id' => 'harga_modal_upah', 'placeholder' => 'Isi Data RAB Modal Upah']) }}
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label" for="harga_jual_satuan">RAB Jual Satuan:</label>
                                {{ Form::text('harga_jual_satuan', $data->harga_jual_satuan ?? old('harga_jual_satuan'), ['class' => 'form-control', 'id' => 'harga_jual_satuan', 'placeholder' => 'Isi Data RAB Jual Satuan']) }}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Detail Pekerjaan</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
 </x-app-layout>
 