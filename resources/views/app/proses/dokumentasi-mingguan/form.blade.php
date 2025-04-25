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
                            <div class="card mx-auto responsive-width">
                                <div class="card-header text-center">
                                    <h5 class="mb-0 fw-bold">Upload File Dokumentasi</h5>
                                </div>
                                <div class="card-body">
                                    <div id="upload-wrapper" class="mb-3">
                                        <div class="upload-group row justify-content-center align-items-center mb-3">
                                            <div class="col-md-5">
                                                <input type="file" name="file[]" class="form-control file-input mb-2" accept="image/*,application/pdf" required>
                                                <textarea name="keterangan[]" class="form-control" placeholder="Keterangan file" rows="2" required></textarea>
                                            </div>
                            
                                            <div class="col-md-3 d-flex justify-content-center mt-2">
                                                <div class="preview-wrapper border rounded p-2 text-center" style="height: 120px; width: 100%; overflow: hidden;">
                                                    <small class="text-muted">Belum ada gambar</small>
                                                </div>
                                            </div>
                            
                                            <div class="col-md-2 d-flex align-items-end mt-2">
                                                <button type="button" class="btn btn-success btn-add w-100">Tambah</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

    function updatePreview(input) {
        const previewWrapper = input.closest('.upload-group').querySelector('.preview-wrapper');
        previewWrapper.innerHTML = ''; // Kosongkan isi sebelumnya

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileType = file.type;

            if (fileType.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-fluid', 'rounded');
                    img.style.maxHeight = '100px';
                    previewWrapper.appendChild(img);
                }
                reader.readAsDataURL(file);
            } else {
                previewWrapper.innerHTML = '<small class="text-muted">File bukan gambar</small>';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('upload-wrapper');

        wrapper.addEventListener('change', function (e) {
            if (e.target.classList.contains('file-input')) {
                updatePreview(e.target);
            }
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-add')) {
                const group = e.target.closest('.upload-group');
                const clone = group.cloneNode(true);

                // Kosongkan input
                clone.querySelectorAll('input').forEach(input => input.value = '');
                clone.querySelector('textarea').value = '';
                clone.querySelector('.preview-wrapper').innerHTML = '<small class="text-muted">Belum ada gambar</small>';

                // Tombol + jadi -
                const btn = clone.querySelector('.btn-add');
                btn.classList.remove('btn-success', 'btn-add');
                btn.classList.add('btn-danger', 'btn-remove');
                btn.innerText = 'Hapus';

                wrapper.appendChild(clone);
            }

            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.upload-group').remove();
            }
        });
    });
</script>