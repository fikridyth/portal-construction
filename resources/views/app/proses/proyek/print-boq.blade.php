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
            <b>BILL OF QUANTITY</b>
        </div>
        <div class="text-center">
            <b>{{ strtoupper($dataProyek->nama) }}</b>
        </div>
        <table class="table table-bordered table-hover mt-3" style="width: 100%; font-size: 12px; line-height: 0; border-collapse: collapse;">
            <tr>
              <th rowspan="2" class="text-center align-middle">NO</th>
              <th rowspan="2" class="text-center align-middle">URAIAN PEKERJAAN</th>
              <th rowspan="2" class="text-center align-middle">VOLUME</th>
              <th rowspan="2" class="text-center align-middle">SATUAN</th>
              <th colspan="2" class="text-center align-middle">HARGA SATUAN</th>
              <th colspan="3" class="text-center align-middle">JUMLAH HARGA</th>
              <th rowspan="2" class="text-center align-middle">KETERANGAN</th>
            </tr>
            <tr>
                <th class="text-center align-middle">BAHAN</th>
                <th class="text-center align-middle">UPAH</th>
                <th class="text-center align-middle">BAHAN</th>
                <th class="text-center align-middle">UPAH</th>
                <th class="text-center align-middle">TOTAL</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $totalHargaJualFinal = 0;
                $firstLoop = null;
                $lastLoop = null;
            @endphp
            {{-- @dd($dataPekerjaanById) --}}
            @foreach($dataPekerjaanById as $idPekerjaan => $data)
                @php
                    $getNama = \App\Models\Pekerjaan::where('id', $idPekerjaan)->value('nama');
                    $totalHargaJual = 0;
                    if (is_null($firstLoop)) {
                        $firstLoop = $loop->iteration;
                    }
                    $lastLoop = $loop->iteration;

                    foreach($data as $detail) {
                        $totalHargaJual += $detail->harga_jual_total;
                        $totalHargaJualFinal += $detail->harga_jual_total;
                    }
                @endphp
                <tr style="background-color: lightblue">
                    <td class="text-center"><b>{{ toAlphabet($loop->iteration) }}</b></td>
                    <td><b>{{ $getNama }}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><b>{{ number_format($totalHargaJual, 2) }}</b></td>
                    <td></td>
                    <td class="text-right"><b>{{ number_format($totalHargaJual, 2) }}</b></td>
                    <td></td>
                </tr>

                {{-- Loop isi detail pekerjaan --}}
                @foreach($data as $detail)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $detail->nama }}</td>
                        <td class="text-right">{{ $detail->volume }}</td>
                        <td class="text-center">{{ $detail->satuan }}</td>
                        <td class="text-right">{{ number_format($detail->harga_jual_satuan, 2) }}</td>
                        <td class="text-right">-</td>
                        <td class="text-right">{{ number_format($detail->harga_jual_total, 2) }}</td>
                        <td class="text-right">-</td>
                        <td class="text-right">{{ number_format($detail->harga_jual_total, 2) }}</td>
                        <td></td>
                    </tr>
                    {{-- Loop bahan bila ada di detail --}}
                    @if($detail->list_bahan)
                        @foreach(json_decode($detail->list_bahan, true) as $bahan)
                            <tr>
                                <td></td>
                                <td style="color: red">{{ $bahan['nama_bahan'] }}</td>
                                <td class="text-right" style="color: red">{{ number_format($bahan['volume'], 2) }}</td>
                                <td class="text-center" style="color: red">{{ $bahan['satuan'] }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach


                {{-- Tambahkan baris kosong antar grup --}}
                @if (!$loop->last || $loop->last)
                    <tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tr>
                @endif
            @endforeach
            @php
                $jasaKontraktor = ($totalHargaJualFinal * 10) / 100;
                $totalHarga = $jasaKontraktor + $totalHargaJualFinal;
                $pembualatan = round($totalHarga, -3);;
                $hargaMeter = $pembualatan / $dataProyek->total_meter;
            @endphp
            <tr>
                <td colspan="3" class="text-right" style="border-right: none;"><b>TOTAL BAHAN DAN UPAH</b></td>
                <td colspan="3" style="border-left: none;"></td>
                <td class="text-right"><b>{{ number_format($totalHargaJualFinal, 0) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($totalHargaJualFinal, 0) }}</b></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="border-right: none;"><b>JASA KONTRAKTOR (10%)</b></td>
                <td colspan="3" style="border-left: none;"></td>
                <td></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($jasaKontraktor, 0) }}</b></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="border-right: none;"><b>TOTAL HARGA</b></td>
                <td colspan="3" style="border-left: none;"></td>
                <td></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($totalHarga, 0) }}</b></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="border-right: none;"><b>DIBULATKAN</b></td>
                <td colspan="3" style="border-left: none;"></td>
                <td></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($pembualatan,0) }}</b></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right" style="border-right: none;"><b>HARGA PERMETER</b></td>
                <td colspan="3" style="border-left: none;"></td>
                <td></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($hargaMeter, 0) }}</b></td>
                <td></td>
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
