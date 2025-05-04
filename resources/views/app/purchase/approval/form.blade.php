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
       {!! Form::model($data, ['route' => ['approval.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['approval.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Form Data Approval</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('approval.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama">Proyek: <span class="text-danger">*</span></label>
                                @if($id !== null)
                                    {{ Form::text('id_proyek', $data->laporanMingguan->proyek->nama, ['class' => 'form-control placeholder-grey', 'id' => 'id_proyek', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
                                @else
                                    {{ Form::select('id_proyek', $dataProyek->pluck('nama', 'id'), null, [
                                        'class' => 'form-control placeholder-grey',
                                        'placeholder' => 'Pilih Proyek',
                                        'required',
                                        'id' => 'id_proyek'
                                    ]) }}
                                @endif
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
                                    <h5 class="mb-0 fw-bold">List Preorder
                                </div>
                                <div class="card-body row preorder-wrapper">
                                    @foreach ($listPesanan as $i => $item)
                                        <div class="row preorder-item {{ $i > 0 ? 'mt-2' : '' }}">
                                            @if ($userRole == 'project_manager' || $userRole == 'owner')
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label">Nama: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::text("preorder[$i][nama]", $item['nama'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', $userRole == 'admin_purchasing' || $userRole == 'finance' ? 'readonly' : 'required']) }}
                                                </div>
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label">Volume: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::number("preorder[$i][volume]", $item['volume'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Volume', $userRole == 'admin_purchasing' || $userRole == 'finance' ? 'readonly' : 'required']) }}
                                                </div>
                                                <div class="col-md-2">
                                                    @if ($i == 0)
                                                        <label class="form-label">Satuan: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::text("preorder[$i][satuan]", $item['satuan'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Satuan', $userRole == 'admin_purchasing' || $userRole == 'finance' ? 'readonly' : 'required']) }}
                                                </div>
                                                <div class="{{ $userRole == 'admin_purchasing' || $userRole == 'finance' ? 'col-md-4' : 'col-md-3' }}">
                                                    @if ($i == 0)
                                                        <label class="form-label">Harga: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::number("preorder[$i][harga]", $item['harga'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Harga', $userRole == 'admin_purchasing' || $userRole == 'finance' ? 'readonly' : 'required']) }}
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    @if ($i == 0)
                                                        <button type="button" class="btn btn-success btn-add w-100">+</button>
                                                    @else
                                                        <button type="button" class="btn btn-danger btn-remove w-100">-</button>
                                                    @endif
                                                </div>
                                            @else
                                                {{ Form::text("preorder[$i][nama]", $item['nama'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'hidden']) }}
                                                {{ Form::number("preorder[$i][volume]", $item['volume'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Volume', 'hidden']) }}
                                                {{ Form::text("preorder[$i][satuan]", $item['satuan'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Satuan', 'hidden']) }}
                                                {{ Form::number("preorder[$i][harga]", $item['harga'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Harga', 'hidden']) }}
                                                <div class="col-md-6">
                                                    @if ($i == 0)
                                                        <label class="form-label">Nama: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::text("test", $item['nama'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'disabled']) }}
                                                </div>
                                                <div class="col-md-2">
                                                    @if ($i == 0)
                                                        <label class="form-label">Volume: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::text("test", $item['volume'] . ' ' . $item['satuan'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'disabled']) }}
                                                </div>
                                                <div class="col-md-2">
                                                    @if ($i == 0)
                                                        <label class="form-label">Harga: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::text("test", number_format($item['harga'], 0), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'disabled']) }}
                                                </div>
                                                <div class="col-md-2">
                                                    @if ($i == 0)
                                                        <label class="form-label">Total Harga: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::text("test", number_format($item['harga'] * $item['volume'], 0), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'disabled']) }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>  
                            </div>                          
                        </div>
                        @if ($userRole == 'finance')
                            <div class="d-flex items-center justify-content-center">
                                <span style="font-size: 18px;">Silahkan lakukan pembayaran dengan note: <b>{{ $data->kode_bayar }}</b></span>
                            </div>
                            <div class="d-flex items-center justify-content-center">
                                <span style="font-size: 18px;">Total bayar: <b>{{ number_format($data->total, 0) }}</b></span>
                            </div>
                            <div class="d-flex items-center justify-content-center mt-3">
                                <button type="submit" name="aksi" value="approve" class="btn btn-primary mx-5" style="width: 150px;">
                                    Selesai
                                </button>
                            </div>
                        @endif
                        @if ($userRole == 'project_manager' || $userRole == 'owner')
                            <div class="d-flex items-center justify-content-center">
                                <button type="submit" name="aksi" value="approve" class="btn btn-primary mx-5" style="width: 150px;">
                                    Approve
                                </button>
                            
                                <button type="submit" name="aksi" value="reject" class="btn btn-danger mx-5" style="width: 150px;">
                                    Reject
                                </button>
                            </div>
                        @endif
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
            fetch(`/get-preorder-minggu-ke/${proyekId}`)
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

    $(document).ready(function () {
        let index = {{ count($listPesanan) }};
        $(document).on('click', '.btn-add', function () {
            let newItem = `
                <div class="row preorder-item mt-2">
                    <div class="col-md-3">
                        <input type="text" name="preorder[${index}][nama]" class="form-control placeholder-grey" placeholder="Isi Nama" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="preorder[${index}][volume]" class="form-control placeholder-grey" placeholder="Isi Volume" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="preorder[${index}][satuan]" class="form-control placeholder-grey" placeholder="Isi Satuan" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="preorder[${index}][harga]" class="form-control placeholder-grey" placeholder="Isi Harga" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-remove w-100">-</button>
                    </div>
                </div>
            `;
            $('.preorder-wrapper').append(newItem);
            index++;
        });

        $(document).on('click', '.btn-remove', function () {
            $(this).closest('.preorder-item').remove();
        });
    });
</script>

