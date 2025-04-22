<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['dokumentasi-mingguan.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['dokumentasi-mingguan.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Dokumentasi</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('dokumentasi-mingguan.index')}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
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
                        </div>
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Dokumentasi</button>
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
            fetch(`/get-dok-minggu-ke/${proyekId}`)
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
</script>