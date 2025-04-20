<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div>
       <?php
          $id = $id ?? null;
       ?>
       @if(isset($id))
       {!! Form::model($data, ['route' => ['laporan-mingguan.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['laporan-mingguan.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Laporan Mingguan</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('laporan-mingguan.index')}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
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
                                    'required'
                                ]) }}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label" for="minggu_ke">Minggu Ke: <span class="text-danger">*</span></label>
                                {{ Form::text('minggu_ke', $data->minggu_ke ?? old('minggu_ke'), ['class' => 'form-control placeholder-grey', 'id' => 'minggu_ke', 'placeholder' => 'Isi Minggu Ke', 'oninput' => "this.value = this.value.replace(/,/g, '')", "required"]) }}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label" for="bobot_rencana">Bobot Rencana (%): <span class="text-danger">*</span></label>
                                {{ Form::text('bobot_rencana', $data->bobot_rencana ?? old('bobot_rencana'), ['class' => 'form-control placeholder-grey', 'id' => 'bobot_rencana', 'placeholder' => 'Isi Bobot Rencana', 'oninput' => "this.value = this.value.replace(/,/g, '')", "required"]) }}
                            </div>
                        </div>
                        <div class="toggle-on" id="formBahan">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center py-4">
                                    <strong>Detail Pekerjaan</strong>
                                </div>
                                <div class="card-body">
                                    <div id="pekerjaanWrapper">
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-primary">{{$id !== null ? 'Ubah' : 'Tambah' }} Data Laporan Mingguan</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
 </x-app-layout>
 
<script>
    $(document).ready(function() {
        $('select[name="id_proyek"]').on('change', function() {
            let idProyek = $(this).val();
    
            if (idProyek) {
                $.ajax({
                    url: '/get-detail-pekerjaan/' + idProyek,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let grouped = {};

                        // Grouping berdasarkan nama pekerjaan
                        data.forEach(item => {
                            let groupName = item.pekerjaan?.nama || 'Lainnya';

                            if (!grouped[groupName]) {
                                grouped[groupName] = [];
                            }

                            grouped[groupName].push(item);
                        });

                        let html = '';

                        // Tampilkan setiap group hanya sekali
                        Object.keys(grouped).forEach((groupName, groupIndex) => {
                            html += `
                                <div class="card mb-3">
                                    <div class="card-header bg-success text-white py-4">
                                        ${groupName}
                                    </div>
                                    <div class="card-body row">
                            `;

                            grouped[groupName].forEach((item, index) => {
                                html += `
                                    <input type="text" class="form-control" name="detail_id_proyek[${item.id}]" value="${item.id_proyek}" hidden>
                                    <input type="text" class="form-control" name="detail_id_pekerjaan[${item.id}]" value="${item.id_pekerjaan}" hidden>
                                    <input type="text" class="form-control" name="detail_id_detail_pekerjaan[${item.id}]" value="${item.id}" hidden>
                                    <div class="form-group col-md-4">
                                        <label class="form-label" for="nama_pekerjaan_${groupIndex}_${index}">
                                            Nama Pekerjaan ${index + 1}
                                        </label>
                                        <input type="text" class="form-control" name="detail_nama_pekerjaan[${item.id}]" value="${item.nama}" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-label" for="volume_${groupIndex}_${index}">
                                            Volume
                                        </label>
                                        <input type="text" class="form-control" name="detail_volume[${item.id}]" value="${item.volume}" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-label" for="satuan_${groupIndex}_${index}">
                                            Satuan
                                        </label>
                                        <input type="text" class="form-control" name="detail_satuan[${item.id}]" value="${item.satuan}" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-label" for="bobot_${groupIndex}_${index}">
                                            Bobot (%)
                                        </label>
                                        <input type="text" class="form-control" name="detail_bobot[${item.id}]" value="${item.bobot}" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-label" for="bobot_${groupIndex}_${index}">
                                            Progress (%)
                                        </label>
                                        <input type="text" class="form-control" name="detail_progress[${item.id}]" required>
                                    </div>
                                    <hr>
                                `;
                            });

                            html += `</div></div>`;
                        });

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
    });
</script>