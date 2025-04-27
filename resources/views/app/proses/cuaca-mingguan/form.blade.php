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
       {!! Form::model($data, ['route' => ['cuaca-mingguan.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['cuaca-mingguan.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Cuaca</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('cuaca-mingguan.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
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
                            <div class="row mt-4">
                                @php
                                    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                    $jam = range(6, 20);
                                @endphp

                                @foreach($hari as $h)
                                <div class="col-md-12 mb-3">
                                    <label class="fw-bold mb-2">{{ $h }}</label>
                                    <div class="row">
                                        @foreach($jam as $j)
                                        <div class="col-12 col-md-3 col-lg-2 mb-2 d-flex align-items-center justify-content-between">
                                            <div class="card py-4 px-4">
                                                <div class="text-center mb-1">
                                                    <label class="form-label mb-0 fw-bold">{{ $j }}:00</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cuaca[{{ $h }}][{{ $j }}]" value="Baik" id="{{ $h }}_{{ $j }}_baik" required checked>
                                                    <label class="form-check-label" for="{{ $h }}_{{ $j }}_baik">Baik</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cuaca[{{ $h }}][{{ $j }}]" value="Hujan" id="{{ $h }}_{{ $j }}_hujan" required>
                                                    <label class="form-check-label" for="{{ $h }}_{{ $j }}_hujan">Hujan</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cuaca[{{ $h }}][{{ $j }}]" value="Berawan" id="{{ $h }}_{{ $j }}_berawan" required>
                                                    <label class="form-check-label" for="{{ $h }}_{{ $j }}_berawan">Berawan</label>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <hr>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Cuaca</button>
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
            fetch(`/get-cuaca-minggu-ke/${proyekId}`)
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
