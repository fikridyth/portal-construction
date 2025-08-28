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
       {!! Form::model($data, ['route' => ['payment.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
       @else
       {!! Form::open(['route' => ['payment.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
       @endif
       <div>
            <div class="card mt-2">
                <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Form Data Payment</h4>
                </div>
                <div class="card-action">
                        <a href="{{route('payment.index')}}" class="btn btn-sm btn-warning" role="button">Kembali</a>
                </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="nama">Proyek: <span class="text-danger">*</span></label>
                                @if($id !== null)
                                    {{ Form::text('id_proyek', $data->proyek->nama, ['class' => 'form-control placeholder-grey', 'id' => 'id_proyek', 'placeholder' => 'Otomatis terisi', "readonly"]) }}
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
                                <div class="card-body row preorder-wrapper">
                                    @foreach ($listPesanan as $i => $item)
                                        <div class="row preorder-item {{ $i > 0 ? 'mt-2' : '' }}">
                                            @if ($userRole == 'project_manager' || $userRole == 'owner')
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label" style="font-size: 14px;">Nama:</label>
                                                    @endif
                                                    {{ Form::text("preorder[$i][nama]", $item['nama'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', $userRole == 'admin_purchasing' || $userRole == 'finance' ? 'readonly' : 'required']) }}
                                                </div>
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label" style="font-size: 14px;">Volume:</label>
                                                    @endif
                                                    {{ Form::number("preorder[$i][volume]", $item['volume'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Volume', $userRole == 'admin_purchasing' || $userRole == 'finance' ? 'readonly' : 'required']) }}
                                                </div>
                                                <div class="col-md-2">
                                                    @if ($i == 0)
                                                        <label class="form-label" style="font-size: 14px;">Satuan:</label>
                                                    @endif
                                                    {{ Form::text("preorder[$i][satuan]", $item['satuan'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Satuan', $userRole == 'admin_purchasing' || $userRole == 'finance' ? 'readonly' : 'required']) }}
                                                </div>
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label" style="font-size: 14px;">Harga:</label>
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
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label" style="font-size: 14px;">Nama:</label>
                                                    @endif
                                                    {{ Form::text("test", $item['nama'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'disabled']) }}
                                                </div>
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label" style="font-size: 14px;">Volume:</label>
                                                    @endif
                                                    {{ Form::text("test", $item['volume'] . ' ' . $item['satuan'], ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'disabled']) }}
                                                </div>
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label" style="font-size: 14px;">Harga:</label>
                                                    @endif
                                                    {{ Form::text("test", number_format($item['harga'], 0), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'disabled']) }}
                                                </div>
                                                <div class="col-md-3">
                                                    @if ($i == 0)
                                                        <label class="form-label" style="font-size: 14px;">Total Harga: <span class="text-danger">*</span></label>
                                                    @endif
                                                    {{ Form::text("test", number_format($item['harga'] * $item['volume'], 0), ['class' => 'form-control placeholder-grey', 'placeholder' => 'Isi Nama', 'disabled']) }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>  
                            </div>                          
                        </div>
                        {{ Form::text('kode_bayar', $data->kode_bayar ?? old('kode_bayar'), ['class' => 'form-control placeholder-grey', 'id' => 'kode_bayar', 'placeholder' => 'Isi kode bayar', 'hidden']) }}
                        {{ Form::text('total', floor($data->total) ?? old('total'), ['class' => 'form-control placeholder-grey', 'id' => 'total', 'placeholder' => 'Isi total bayar', 'hidden']) }}
                        <div class="alert alert-info text-center mt-n3">
                            <p><strong>📌 Informasi Pembayaran:</strong></p>
                            <p>Silakan lakukan pembayaran sejumlah</p>
                            <h5 class="text-primary mt-n3 mb-2"><strong>Rp {{ number_format($data->total, 0) }}</strong></h5>
                            <p>Menggunakan kode bayar berikut:</p>
                            <h5 class="text-primary mt-n3 mb-2"><strong>{{ $data->kode_bayar }}</strong></h5>
                            <p>Berikut nomor rekening pembayaran:</p>
                            <h5 class="text-primary mt-n3 mb-2"><strong>{{ $data->supplier->nama_rekening . ' - ' . $data->supplier->nomor_rekening }}</strong></h5>
                            <p>Tekan selesai bila sudah melakukan pembayaran.</p>
                            <button type="submit" name="aksi" value="approve" class="btn btn-primary mx-5" style="width: 150px;">
                                Selesai
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
 </x-app-layout>
 
 <script>
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

