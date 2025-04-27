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
            <b>RENCANA ANGGARAN BIAYA</b>
        </div>
        <div class="text-center">
            <b>{{ strtoupper($dataProyek->nama) }}</b>
        </div>
        <table class="table table-bordered table-hover mt-3" style="width: 100%; font-size: 12px; line-height: 0; border-collapse: collapse;">
            <tr>
                <th colspan="4" class="text-center align-middle" style="border: none;"></th>
                <th colspan="3" class="text-center align-middle" style="border: none; background-color: orange;">RAB MODAL</th>
                <th colspan="2" class="text-center align-middle" style="border: none; background-color: rgb(49, 208, 49);">RAB JUAL</th>
            </tr>
            <tr>
              <th rowspan="2" class="text-center align-middle">NO</th>
              <th rowspan="2" class="text-center align-middle">URAIAN PEKERJAAN</th>
              <th rowspan="2" class="text-center align-middle">VOLUME</th>
              <th rowspan="2" class="text-center align-middle">SATUAN</th>
              <th colspan="2" class="text-center align-middle">TOTAL HARGA SATUAN</th>
              <th class="text-center align-middle">TOTAL HARGA</th>
              <th class="text-center align-middle">HARGA SATUAN</th>
              <th class="text-center align-middle">TOTAL HARGA</th>
            </tr>
            <tr>
                <th class="text-center align-middle">MATERIAL</th>
                <th class="text-center align-middle">UPAH</th>
                <th class="text-center align-middle">Rp.</th>
                <th class="text-center align-middle">Rp.</th>
                <th class="text-center align-middle">Rp.</th>
            </tr>
            @php
                $totalHargaModalFinal = 0;
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
                @endphp
                <tr>
                    <td><b>{{ toRoman($loop->iteration) }}</b></td>
                    <td><b>{{ $getNama }}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                {{-- Loop isi detail pekerjaan --}}
                @foreach($data as $detail)
                @php
                    $totalModal = $detail->harga_modal_upah ? number_format($detail->harga_modal_upah, 2) : ($detail->harga_modal_material ? number_format($detail->harga_modal_material, 2) : '-');
                    $totalModalNumber = (int) str_replace([','], '', $totalModal);
                    $totalHargaModalFinal += $totalModalNumber;
                    $totalHargaJual += $detail->harga_jual_total;
                    $totalHargaJualFinal += $detail->harga_jual_total;
                @endphp
                    <tr>
                        <td class="text-right">{{ $loop->iteration }}</td>
                        <td>{{ $detail->nama }}</td>
                        <td class="text-right">{{ $detail->volume }}</td>
                        <td class="text-center">{{ $detail->satuan }}</td>
                        <td class="text-right">{{ $detail->harga_modal_material ? number_format($detail->harga_modal_material, 2) : '-' }}</td>
                        <td class="text-right">{{ $detail->harga_modal_upah ? number_format($detail->harga_modal_upah, 2) : '-' }}</td>
                        <td class="text-right">{{ $totalModal }}</td>
                        <td class="text-right">{{ number_format($detail->harga_jual_satuan, 2) }}</td>
                        <td class="text-right">{{ number_format($detail->harga_jual_total, 2) }}</td>
                    </tr>
                    {{-- Loop bahan bila ada di detail --}}
                    @if($detail->list_bahan)
                        @foreach(json_decode($detail->list_bahan, true) as $bahan)
                        @php
                            $totalModalNumber = (int) str_replace([','], '', $bahan['total']);
                            $totalHargaModalFinal += $totalModalNumber;
                        @endphp
                            <tr>
                                <td></td>
                                <td style="color: red">{{ $bahan['nama_bahan'] }}</td>
                                <td class="text-right" style="color: red">{{ number_format($bahan['volume'], 2) }}</td>
                                <td class="text-center" style="color: red">{{ $bahan['satuan'] }}</td>
                                <td class="text-right" style="color: red">{{ $bahan['harga_modal_material'] ? number_format($bahan['harga_modal_material'] * number_format($bahan['volume']), 2) : '-' }}</td>
                                <td class="text-right" style="color: red">{{ $bahan['harga_modal_upah'] ? number_format($bahan['harga_modal_upah'] * number_format($bahan['volume']), 2) : '-' }}</td>
                                <td class="text-right" style="color: red">{{ $bahan['total'] ? number_format($bahan['total'], 2) : '-' }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach


                {{-- Tambahkan baris kosong antar grup --}}
                @if (!$loop->last || $loop->last)
                    <tr>
                        <td colspan="4" class="text-right"><b>Total {{ toRoman($loop->iteration) }} {{ $getNama }}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><b>{{ number_format($totalHargaJual, 2) }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="9"></td>
                    </tr>
                @endif
            @endforeach
            @php
                $upahMandor = $totalHargaModalFinal * 10 / 100;
                $ongkosMandor = $totalHargaModalFinal * 20 / 100;
                $operasional = $totalHargaModalFinal * 30 / 100;
            @endphp
            <tr>
                <td colspan="4" class="text-right"><b>TOTAL PEKERJAAN ({{ toRoman($firstLoop) }} - {{ toRoman($lastLoop) }})</b></td>
                <td colspan="3" class="text-right"><b>{{ number_format($totalHargaModalFinal, 2) }}</b></td>
                <td colspan="2" class="text-right"><b>{{ number_format($totalHargaJualFinal, 2) }}</b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>UPAH MANDOR</b></td>
                <td colspan="3" class="text-right"><b>{{ number_format($upahMandor, 2) }}</b></td>
                <td colspan="2" class="text-right"><b></b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>ONGKOS MANDOR 1 + TUKANG 1</b></td>
                <td colspan="3" class="text-right"><b>{{ number_format($ongkosMandor, 2) }}</b></td>
                <td colspan="2" class="text-right"><b></b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>OPERASIONAL + TIKET + UM SPV</b></td>
                <td colspan="3" class="text-right"><b>{{ number_format($operasional, 2) }}</b></td>
                <td colspan="2" class="text-right"><b></b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>PPN 11%</b></td>
                <td colspan="3" class="text-right"><b></b></td>
                <td colspan="2" class="text-right"><b>{{ number_format($totalHargaJualFinal * 11 / 100, 2) }}</b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>JUMLAH</b></td>
                <td colspan="3" class="text-right"><b>{{ number_format($totalHargaModalFinal + $upahMandor + $ongkosMandor + $operasional, 2) }}</b></td>
                <td colspan="2" class="text-right"><b>{{ number_format($totalHargaJualFinal * 11 / 100 + $totalHargaJualFinal, 2) }}</b></td>
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
