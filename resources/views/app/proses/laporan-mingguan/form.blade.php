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
                        <a href="{{route('laporan-mingguan.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label class="form-label" for="nama">Proyek: <span class="text-danger">*</span></label>
                                {{ Form::select('id_proyek', $dataProyek->pluck('nama', 'id'), old('id_proyek', $data->id_proyek ?? null), [
                                    'class' => 'form-control placeholder-grey',
                                    'placeholder' => 'Pilih Proyek',
                                    'required',
                                    'id' => 'id_proyek'
                                ]) }}
                            </div>
                            <div class="form-group col-md-1">
                                <label class="form-label" style="font-size: 14px;" for="minggu_ke">Minggu Ke:</label>
                                {{ Form::text('minggu_ke', $data->minggu_ke ?? old('minggu_ke'), ['class' => 'form-control placeholder-grey', 'id' => 'minggu_ke', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="dari">Dari: <span class="text-danger">*</span></label>
                                {{ Form::date('dari', $data->dari ?? old('dari'), ['class' => 'form-control placeholder-grey', 'id' => 'dari', 'placeholder' => 'Isi Tanggal', "required"]) }}
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="sampai">Sampai: <span class="text-danger">*</span></label>
                                {{ Form::date('sampai', $data->sampai ?? old('sampai'), ['class' => 'form-control placeholder-grey', 'id' => 'sampai', 'placeholder' => 'Isi Tanggal', "required"]) }}
                            </div>
                            <div class="form-group col-md-2">
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
    document.getElementById('id_proyek').addEventListener('change', function() {
        const proyekId = this.value;

        if (proyekId) {
            fetch(`/get-minggu-ke/${proyekId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('minggu_ke').value = data.minggu_ke;
                })
                .catch(error => {
                    console.error('Gagal mengambil data minggu ke:', error);
                    document.getElementById('minggu_ke').value = '';
                });
        } else {
            document.getElementById('minggu_ke').value = '';
        }
    });

    $(document).ready(function() {
        $('select[name="id_proyek"]').on('change', function() {
            let idProyek = $(this).val();
    
            if (idProyek) {
                $.ajax({
                    url: '/get-detail-pekerjaan/' + idProyek,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let grouped = {};
                        let data = response.detail;
                        let progressData = response.progress;

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
                                let progressSebelumnya = progressData[item.id] ?? 0;
                                let nilaiProgressSaatIni = progressSebelumnya;
                                let isReadonly = nilaiProgressSaatIni == 100 ? 'readonly' : '';

                                html += `
                                    <input type="text" class="form-control" name="detail_id_proyek[${item.id}]" value="${item.id_proyek}" hidden>
                                    <input type="text" class="form-control" name="detail_id_pekerjaan[${item.id}]" value="${item.id_pekerjaan}" hidden>
                                    <input type="text" class="form-control" name="detail_id_detail_pekerjaan[${item.id}]" value="${item.id}" hidden>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" style="font-size: 14px;" for="nama_pekerjaan_${groupIndex}_${index}">
                                            Nama Pekerjaan ${index + 1}
                                        </label>
                                        <input type="text" class="form-control" name="detail_nama_pekerjaan[${item.id}]" value="${item.nama}" readonly>
                                    </div>
                                    <div hidden class="form-group col-md-1">
                                        <label class="form-label" style="font-size: 14px;" for="volume_${groupIndex}_${index}">
                                            Volume
                                        </label>
                                        <input type="text" class="form-control" name="detail_volume[${item.id}]" value="${item.volume}" readonly>
                                    </div>
                                    <div hidden class="form-group col-md-1">
                                        <label class="form-label" style="font-size: 14px;" for="satuan_${groupIndex}_${index}">
                                            Satuan
                                        </label>
                                        <input type="text" class="form-control" name="detail_satuan[${item.id}]" value="${item.satuan}" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-label" style="font-size: 14px;" for="bobot_${groupIndex}_${index}">
                                            Bobot (%)
                                        </label>
                                        <input type="text" class="form-control" name="detail_bobot[${item.id}]" value="${item.bobot}" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-label" style="font-size: 14px;" for="last_progress_${groupIndex}_${index}">
                                            Progress Sebelumnya (%)
                                        </label>
                                        <input type="text" class="form-control" name="last_progress[${item.id}]" value="${progressSebelumnya}%" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="form-label" style="font-size: 14px;" for="detail_progress_${groupIndex}_${index}">
                                            Progress Saat Ini (%)
                                        </label>
                                        <input type="number" class="form-control detail-progress-input" 
                                            name="detail_progress[${item.id}]" 
                                            id="detail_progress_${item.id}" 
                                            value="${nilaiProgressSaatIni}" ${isReadonly} required>
                                        <div class="invalid-feedback">Nilai melebihi 100!</div>
                                    </div>
                                    <hr>
                                `;
                            });

                            html += `</div></div>`;
                        });

                        setTimeout(() => {
                            document.querySelectorAll('.detail-progress-input').forEach(input => {
                                input.addEventListener('input', function () {
                                    const maxVolume = 100;
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