<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Cetak</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        @media print {
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
        <div class="text-center">
            <h4>REKAPITULASI BIAYA</h4>
        </div>
        <div class="text-center mb-4">
            <h4>{{ strtoupper($dataProyek->nama) }}</h4>
        </div>
        <table class="table table-bordered table-hover mt-3" style="width: 100%; font-size: 18px; line-height: 0; border-collapse: collapse;">
            <tr style="height: 50px;">
                <th class="text-center align-middle">NO</th>
                <th class="text-center align-middle">URAIAN PEKERJAAN</th>
                <th class="text-center align-middle">TOTAL BIAYA</th>
            </tr>
            @php
                $totalHargaJualFinal = 0;
                $firstLoop = null;
                $lastLoop = null;
            @endphp
            @foreach($dataPekerjaanById as $idPekerjaan => $data)
                @php
                    $getNama = \App\Models\Pekerjaan::where('id', $idPekerjaan)->value('nama');
                    $totalHargaJual = 0;
                    if (is_null($firstLoop)) {
                        $firstLoop = $loop->iteration;
                    }
                    $lastLoop = $loop->iteration;
                @endphp

                {{-- Loop isi detail pekerjaan --}}
                @foreach($data as $detail)
                    @php
                        $totalHargaJual += $detail->harga_jual_total;
                        $totalHargaJualFinal += $detail->harga_jual_total;
                    @endphp
                @endforeach


                {{-- Tambahkan baris kosong antar grup --}}
                @if ($loop->first)
                    <tr style="height: 30px;">
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
                    <tr style="height: 30px;">
                        <td class="text-center">-</td>
                        <td><b>{{ $getNama }}</b></td>
                        <td class="text-right"><b>{{ number_format($totalHargaJual, 0) }}</b></td>
                    </tr>
                @if ($loop->last)
                    <tr style="height: 30px;">
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
            @php
                $jasaKontraktor = ($totalHargaJualFinal * 10) / 100;
                $totalHarga = $jasaKontraktor + $totalHargaJualFinal;
                $pembualatan = round($totalHarga, -3);;
                $hargaMeter = $pembualatan / $dataProyek->total_meter;
            @endphp
            <tr style="height: 30px;">
                <td></td>
                <td class="text-right"><b>TOTAL BAHAN DAN UPAH</b></td>
                <td class="text-right"><b>{{ number_format($totalHargaJualFinal, 0) }}</b></td>
            </tr>
            <tr style="height: 30px;">
                <td></td>
                <td class="text-right"><b>JASA KONTRAKTOR (10%)</b></td>
                <td class="text-right"><b>{{ number_format($jasaKontraktor, 0) }}</b></td>
            </tr>
            <tr style="height: 30px;">
                <td></td>
                <td class="text-right"><b>TOTAL HARGA</b></td>
                <td class="text-right"><b>{{ number_format($totalHarga, 0) }}</b></td>
            </tr>
            <tr style="height: 30px;">
                <td></td>
                <td class="text-right"><b>DIBULATKAN</b></td>
                <td class="text-right"><b>{{ number_format($pembualatan,0) }}</b></td>
            </tr>
            <tr style="height: 30px;">
                <td></td>
                <td class="text-right"><b>HARGA PERMETER={{ $dataProyek->total_meter }} M2</b></td>
                <td class="text-right"><b>{{ number_format($hargaMeter, 2) }}</b></td>
            </tr>
        </table>
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
