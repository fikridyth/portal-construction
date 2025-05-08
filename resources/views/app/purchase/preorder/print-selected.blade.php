1<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Cetak</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
        .dashed-line {
            border: 0;
            border-top: 1px dashed black; /* Ganti 'black' dengan warna yang diinginkan */
            margin: 10px 0; /* Sesuaikan margin sesuai kebutuhan */
        }
        .dashed-line-2 {
            border: 0;
            border-top: 1px dashed black; /* Ganti 'black' dengan warna yang diinginkan */
            margin: -5px 0; /* Sesuaikan margin sesuai kebutuhan */
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-6" style="font-size: 13px;">
                <div class="d-flex justify-content-between">
                    <span class="text-center" style="font-weight: 500;">
                        <p>CV. TRI CIPTA GEMILANG</p>
                        <p style="margin-top: -20px; font-size: 12px;">PROYEK MAISONETE</p>
                        <p style="margin-top: -20px; font-size: 12px;">SESKO AU, LEMBANG, BANDUNG</p>
                    </span>
                    <span class="text-center" style="font-weight: 500;">
                        <p style="margin-top: 12px;">Jakarta, {{ $now }}</p>
                        <p style="margin-top: -20px;">TB. ANUGRAH</p>
                    </span>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <h6>PURCHASE ORDER</h6>
                </div>
                <table class="tabletable-hover mb-5" style="width: 100%; font-size: 13px; line-height: 0; border-collapse: collapse;">
                    <tr style="height: 30px;">
                        <th></th>
                        <th class="text-center align-middle">Nama Barang</th>
                        <th class="text-center align-middle">Qty</th>
                        <th class="text-center align-middle">Harga @</th>
                        <th class="text-center align-middle">Total Harga</th>
                    </tr>
                    @php
                        $totalHarga = 0;
                    @endphp
                    @foreach($filteredPesanan as $pesanan)
                        @php
                            $totalHarga += $pesanan['total']
                        @endphp
                        <tr style="height: 18px;">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $pesanan['nama'] }}</td>
                            <td>{{ $pesanan['volume'] . ' ' . $pesanan['satuan'] }}</td>
                            <td class="text-right">{{ number_format($pesanan['harga']) }}</td>
                            <td class="text-right">{{ number_format($pesanan['total']) }}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="d-flex justify-content-between">
                    <span style="font-weight: 500;">
                        <p>BCA</p>
                        <p style="margin-top: -20px; font-size: 14px;">137-300-7688</p>
                        <p style="margin-top: -20px; font-size: 14px;">SAMUEL SUKIANTO</p>
                    </span>
                    <span class="text-center" style="font-weight: 500;">
                        <p>Total: <b>{{ number_format($totalHarga) }}</b></p>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6" style="font-size: 13px;">
                <div class="card mt-4">
                    <div class="card-body p-0">
                        <table class="table table-borderless table-sm mb-0 mt-2" style="width: 100%; font-size: 11px; line-height: 0; border-collapse: collapse;">
                            <tr>
                                <th class="text-center align-middle mb-5">Alokasi</th>
                                <th class="text-center align-middle"></th>
                                <th class="text-center align-middle"></th>
                                <th class="text-center align-middle"></th>
                            </tr>
                            <tr style="height: 30px;">
                                <th class="text-center align-middle mb-5"></th>
                                <th class="text-center align-middle">Qty</th>
                                <th class="text-center align-middle">Harga @</th>
                                <th class="text-center align-middle">Total Harga</th>
                            @foreach($filteredPesanan as $pesanan)
                                <tr style="height: 18px;">
                                    <td>{{ $pesanan['nama'] }}</td>
                                    <td>{{ $pesanan['volume'] . ' ' . $pesanan['satuan'] }}</td>
                                    <td class="text-right">{{ number_format($pesanan['harga'], 2) }}</td>
                                    <td class="text-right">{{ number_format($pesanan['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <hr>
                        <table class="table table-borderless table-sm" style="width: 100%; font-size: 11px; line-height: 0; border-collapse: collapse;">
                            <tr>
                                <th>TOTAL</th>
                                <th class="text-right">{{ number_format($totalHarga) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6" style="font-size: 13px;">
                <div class="card mt-4">
                    <div class="card-body p-0">
                        <table class="table table-borderless table-sm mb-0 mt-2" style="width: 100%; font-size: 11px; line-height: 0; border-collapse: collapse;">
                            <tr>
                                <th></th>
                                <th class="text-center align-middle mb-5">BUDGET RAB</th>
                                <th></th>
                            </tr>
                            <tr style="height: 30px;">
                                <th class="text-center align-middle mb-5"></th>
                                <th class="text-center align-middle">Qty</th>
                                <th class="text-center align-middle">Harga @</th>
                                <th class="text-center align-middle">Total Harga</th>
                            @foreach($filteredPesanan as $pesanan)
                                <tr style="height: 18px;">
                                    <td>{{ $pesanan['nama'] }}</td>
                                    <td>{{ $pesanan['volume'] . ' ' . $pesanan['satuan'] }}</td>
                                    <td class="text-right">{{ number_format($pesanan['harga'], 2) }}</td>
                                    <td class="text-right">{{ number_format($pesanan['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <hr>
                        <table class="table table-borderless table-sm" style="width: 100%; font-size: 11px; line-height: 0; border-collapse: collapse;">
                            <tr>
                                <th>TOTAL</th>
                                <th class="text-right">{{ number_format($totalHarga) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi ini akan dipanggil saat halaman selesai dimuat
        function autoPrint() {
            window.print();
        }

        // Menjalankan fungsi autoPrint setelah halaman dimuat sepenuhnya
        window.onload = autoPrint;

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' || event.key === 'Backspace') {
                window.history.back();
            }
        });
    </script>
    <script src="{{ asset('assets/js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>

</html>
