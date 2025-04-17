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
                        <a href="{{route('proyek.show', $data->id_proyek ?? $dataProyek->id)}}" class="btn btn-sm btn-primary" role="button">Kembali</a>
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
                                <label class="form-label" for="id_pekerjaan">Pilih Pekerjaan: <span class="text-danger">*</span></label>
                                {{ Form::select('id_pekerjaan', $dataPekerjaan->pluck('nama', 'id'), $data->id_pekerjaan ?? old('id_pekerjaan'), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Pilih Pekerjaan', 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama">Nama: <span class="text-danger">*</span></label>
                                {{ Form::text('nama', $data->nama ?? old('nama'), ['class' => 'form-control placeholder-grey', 'id' => 'nama', 'placeholder' => 'Isi Nama', 'required']) }}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label" for="volume">Volume: <span class="text-danger">*</span></label>
                                {{ Form::text('volume', $data->volume ?? old('volume'), ['class' => 'form-control placeholder-grey', 'id' => 'volume', 'placeholder' => 'Isi Volume', 'required']) }}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label" for="satuan">Satuan: <span class="text-danger">*</span></label>
                                {{ Form::text('satuan', $data->satuan ?? old('satuan'), ['class' => 'form-control placeholder-grey', 'id' => 'satuan', 'placeholder' => 'Isi Satuan', 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label" for="harga_modal_material">RAB Modal Material:</label>
                                {{ Form::text('harga_modal_material', $data->harga_modal_material ?? old('harga_modal_material'), ['class' => 'form-control placeholder-grey', 'id' => 'harga_modal_material', 'placeholder' => 'Isi RAB Modal Material', 'oninput' => "this.value = this.value.replace(/,/g, '')"]) }}
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label" for="harga_modal_upah">RAB Modal Upah:</label>
                                {{ Form::text('harga_modal_upah', $data->harga_modal_upah ?? old('harga_modal_upah'), ['class' => 'form-control placeholder-grey', 'id' => 'harga_modal_upah', 'placeholder' => 'Isi RAB Modal Upah', 'oninput' => "this.value = this.value.replace(/,/g, '')"]) }}
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label" for="harga_jual_satuan">RAB Jual Satuan:</label>
                                {{ Form::text('harga_jual_satuan', $data->harga_jual_satuan ?? old('harga_jual_satuan'), ['class' => 'form-control placeholder-grey', 'id' => 'harga_jual_satuan', 'placeholder' => 'Isi RAB Jual Satuan', 'oninput' => "this.value = this.value.replace(/,/g, '')"]) }}
                            </div>
                            <div class="form-group col-md-4">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="bahan" name="is_bahan" {{ isset($data) && $data->is_bahan == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bahan">Bahan</label>
                                </div>
                            </div>
                            <div class="toggle-on" id="formBahan" hidden>
                                <div class="card shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-4">
                                        <strong>Detail Bahan</strong>
                                        <button type="button" class="btn btn-sm btn-success" id="btnTambahBahan">+ Tambah</button>
                                    </div>
                                    <div class="card-body">
                                        <div id="bahanWrapper">
                                            {{-- Baris Pertama --}}
                                            <div class="row bahan-item mb-3">
                                                <div class="form-group col-md-5">
                                                    <label class="form-label label-bahan">Bahan: <span class="text-danger">*</span></label>
                                                    {{ Form::select('id_bahan[]', $dataBahan->pluck('nama', 'id'), null, [
                                                        'class' => 'form-control placeholder-grey',
                                                        'placeholder' => 'Pilih Bahan',
                                                        'required'
                                                    ]) }}
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label class="form-label">Volume: <span class="text-danger">*</span></label>
                                                    {{ Form::text('volume_bahan[]', null, [
                                                        'class' => 'form-control placeholder-grey',
                                                        'placeholder' => 'Isi Volume',
                                                        'required'
                                                    ]) }}
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm btnHapusBahan mb-4">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
 
 <script>
    function updateLabelBahan() {
        const labels = document.querySelectorAll('.label-bahan');
        labels.forEach((label, index) => {
            label.innerHTML = `Bahan ${index + 1}: <span class="text-danger">*</span>`;
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // checkbox bahan
        const checkbox = document.getElementById('bahan');
        const formSection = document.getElementById('formBahan');
        const bahanWrapper = document.getElementById('bahanWrapper');
        const btnTambah = document.getElementById('btnTambahBahan');
        const templateItem = bahanWrapper.querySelector('.bahan-item');
        const listBahan = JSON.parse(@json($data->list_bahan ?? '[]'));
        const isBahanChecked = {{ $data->is_bahan ?? 0 }};

        if (isBahanChecked) {
            checkbox.checked = true;
            formSection.removeAttribute('hidden');

            // Bersihkan semua elemen awal
            bahanWrapper.innerHTML = '';

            listBahan.forEach(item => {
                const newItem = templateItem.cloneNode(true);

                newItem.querySelector('[name="id_bahan[]"]').value = item.id_bahan;
                newItem.querySelector('[name="volume_bahan[]"]').value = item.volume;

                bahanWrapper.appendChild(newItem);
            });

            updateLabelBahan();
        }

        checkbox.addEventListener('change', function () {
            if (this.checked) {
                formSection.removeAttribute('hidden');
            } else {
                formSection.setAttribute('hidden', true);
            }
        });

        btnTambah.addEventListener('click', function () {
            const firstItem = bahanWrapper.querySelector('.bahan-item');
            const newItem = firstItem.cloneNode(true);

            // Kosongkan nilai input
            newItem.querySelectorAll('select, input').forEach(el => el.value = '');

            bahanWrapper.appendChild(newItem);
            updateLabelBahan();
        });

        bahanWrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('btnHapusBahan')) {
                const items = bahanWrapper.querySelectorAll('.bahan-item');
                if (items.length > 1) {
                    e.target.closest('.bahan-item').remove();
                    updateLabelBahan();
                } else {
                    alert('Minimal satu detail bahan harus ada.');
                }
            }
        });

        updateLabelBahan();
    });

 </script>
