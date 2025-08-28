<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['laporan-komparasi.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['laporan-komparasi.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Laporan Komparasi</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('laporan-komparasi.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-8" style="margin-top: 2px;">
                                <label class="form-label" for="nama">Proyek: <span class="text-danger">*</span></label>
                                {{ Form::select('id_proyek', $dataProyek->mapWithKeys(function ($item) {
                                    return [$item->id => $item->proyek->nama . ' - Minggu ke ' . $item->minggu_ke . ' - Kode ' . $item->kode_bayar];
                                }), old('id_proyek', $data->id_proyek ?? null), [
                                    'class' => 'form-control select2',
                                    'placeholder' => 'Pilih Proyek',
                                    'required',
                                    'id' => 'id_proyek'
                                ]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="dari">Dari: <span class="text-danger">*</span></label>
                                {{ Form::date('dari', $data->dari ?? old('dari'), ['class' => 'form-control placeholder-grey', 'id' => 'dari', 'placeholder' => 'Isi Tanggal', "required"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="sampai">Sampai: <span class="text-danger">*</span></label>
                                {{ Form::date('sampai', $data->sampai ?? old('sampai'), ['class' => 'form-control placeholder-grey', 'id' => 'sampai', 'placeholder' => 'Isi Tanggal', "required"]) }}
                            </div>
                        </div>
                        <div class="toggle-on" id="formBahan">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center py-4">
                                    <strong>Detail Bahan</strong>
                                </div>
                                <div class="card-body">
                                    <div id="pekerjaanWrapper">
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Laporan Komparasi</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
 </x-app-layout>
 
<script>
    $(function() {
        $('#id_proyek').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Proyek',
            allowClear: true,
            dropdownParent: $('#id_proyek').parent() // agar tidak conflict di modal atau nested form
        });

        // Autofocus ke search saat dropdown terbuka
        $('#id_proyek').on('select2:open', function() {
            setTimeout(() => {
                document.querySelector('.select2-container--bootstrap4 .select2-search__field').focus();
            }, 0);
        });
    });

    $(document).ready(function() {
        $('select[name="id_proyek"]').on('change', function() {
            let idProyek = $(this).val();
    
            if (idProyek) {
                $.ajax({
                    url: '/get-detail-bahan/' + idProyek,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let html = '';
                        let rawData = response.detail;
                        let data = typeof rawData === 'string' ? JSON.parse(rawData) : rawData;

                        data.forEach((item,index) => {
                            let isReadonly = item.progress == item.volume ? 'readonly' : '';
                            html += `
                                <div class="card mb-3">
                                    <div class="card-body row">
                                        <input type="text" class="form-control" name="volume[${index}]" value="${item.volume}" id="volume_${index}" hidden readonly>
                                        <input type="text" class="form-control" name="satuan[${index}]" value="${item.satuan}" hidden readonly>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" style="font-size: 14px;" for="nama_${index}">
                                                Nama Bahan
                                            </label>
                                            <input type="text" class="form-control" name="nama[${index}]" value="${item.nama}" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="form-label" style="font-size: 14px;" for="volume_${index}">
                                                Volume Bahan
                                            </label>
                                            <input type="text" class="form-control" value="${item.volume + ' ' + item.satuan}" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="form-label" style="font-size: 14px;" for="previous_progress_${index}">
                                                Penggunaan Sebelumnya
                                            </label>
                                            <input type="text" class="form-control" name="previous_progress[${index}]" value="${item.progress ?? 0}" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="form-label" for="detail_progress_${index}" style="font-size: 14px;">
                                                Progress Penggunaan Bahan
                                            </label>
                                            <input type="number" class="form-control detail-progress-input" 
                                                name="detail_progress[${index}]" 
                                                id="detail_progress_${index}" 
                                                data-volume="${item.volume}"
                                                value="${item.progress ?? 0}" ${isReadonly} required>
                                            <div class="invalid-feedback">Nilai melebihi volume</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        setTimeout(() => {
                            document.querySelectorAll('.detail-progress-input').forEach(input => {
                                input.addEventListener('input', function () {
                                    const maxVolume = parseFloat(this.dataset.volume);
                                    const value = parseFloat(this.value);
                                    if (value > maxVolume) {
                                        this.classList.add('is-invalid');
                                    } else {
                                        this.classList.remove('is-invalid');
                                    }
                                });
                            });
                        }, 0);

                        $('#pekerjaanWrapper').html(html);
                    },
                    error: function() {
                        $('#pekerjaanWrapper').html('<div class="alert alert-danger">Gagal mengambil data.</div>');
                    }
                });
            } else {
                $('#pekerjaanWrapper').empty();
            }
        });

        // Jalankan auto-fetch jika sebelumnya sudah dipilih
        const oldProyekId = '{{ old("id_proyek", $data->id_proyek ?? "") }}';
        if (oldProyekId) {
            $('#id_proyek').val(oldProyekId).trigger('change');
        }
    });
</script>