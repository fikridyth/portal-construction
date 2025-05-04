<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Preorder</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        @media print {
            @page {
                size: landscape;
            }
            .no-print {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
        }

        .image-block {
            margin-bottom: 5px;
            page-break-inside: avoid;
        }

        .image-block img {
            width: 100%;
            max-height: 450px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .image-block p {
            margin-top: 5px;
            text-align: center;
            font-size: 14px;
        }

        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    </style>
</head>
<body>
    {{-- <div class="container"> --}}
        <div class="row mt-3 mb-1" style="font-size: 12px;">
            <div class="col-3">PROYEK</div>
            <div class="col-9">: {{ $data->laporanMingguan->proyek->nama }}</div>
            <div class="col-3">PERIODE</div>
            <div class="col-9">: {{ $now }} ( Minggu ke-{{ $data->minggu_ke }} Tgl {{ $range }} )</div>
            <div class="col-3">PELAKSANA PROYEK</div>
            <div class="col-9">: {{ $data->laporanMingguan->proyek->pelaksana }}</div>
            <div class="col-3">PURCHASING</div>
            <div class="col-9">: {{ $data->createdBy->first_name . ' ' . $data->createdBy->last_name }}</div>
        </div>
        <table class="table table-bordered table-hover mt-3" style="width: 99%; line-height: 0; border-collapse: collapse;">
            <tr style="font-size: 9px">
                <th rowspan="4" class="text-center align-middle wrap-text" style="width: 45px;">TANGGAL</th>
                <th colspan="12" class="text-center align-middle wrap-text">LAPORAN BELANJA PROYEK</th>
            </tr>
            <tr style="font-size: 9px">
                <th rowspan="3" class="text-center align-middle wrap-text">URAIAN</th>
                <th colspan="5" class="text-center align-middle wrap-text">MATERIAL & UPAH</th>
                <th colspan="5" class="text-center align-middle wrap-text">OPERASIONAL</th>
                <th rowspan="2" class="text-center align-middle wrap-text" style="width: 45px;">TOTAL</th>
            </tr>
            <tr style="font-size: 7px">
                <th class="text-center align-middle wrap-text" style="width: 50px; line-height: 1;">MATERIAL</th>
                <th class="text-center align-middle wrap-text" style="width: 80px; line-height: 1;">UPAH BORONG BANGUNAN</th>
                <th class="text-center align-middle wrap-text" style="width: 85px; line-height: 1;">UPAH BORONG NON BANGUNAN</th>
                <th class="text-center align-middle wrap-text" style="width: 50px; line-height: 1;">PARTISIPASI</th>
                <th class="text-center align-middle wrap-text" style="width: 45px; line-height: 1;">ONGKOS KIRIM</th>
                <th class="text-center align-middle wrap-text" style="width: 45px; line-height: 1;">OPERASIONAL PROYEK</th>
                <th class="text-center align-middle wrap-text" style="width: 80px; line-height: 1;">UANG MAKAN SUPERVISOR</th>
                <th class="text-center align-middle wrap-text" style="width: 50px; line-height: 1;">BIAYA KENDARAAN</th>
                <th class="text-center align-middle wrap-text" style="width: 45px; line-height: 1;">MOBILISASI</th>
                <th class="text-center align-middle wrap-text" style="width: 35px; line-height: 1;">ADM</th>
            </tr>
            <tr style="font-size: 7px">
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
                <th class="text-center align-middle wrap-text">Rp</th>
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
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach ($listPesanan as $pesan)
                <tr style="font-size: 10px;">
                    <td>{{ $loop->first ? $last : '' }}</td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <span>{{ $pesan['nama'] }}</span>
                            <span>{{ $pesan['volume'] . ' ' . $pesan['satuan'] }}</span>
                        </div>
                    </td>
                    @if ($pesan['type'] == 'Material')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Upah Borong Bangunan')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Upah Borong Non Bangunan')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Partisipasi')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Ongkos Kirim')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Operasional Proyek')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Uang Makan Supervisor')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Biaya Kendaraan')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Mobilisasi')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    @if ($pesan['type'] == 'Adm')
                        <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                    @else
                        <td></td>
                    @endif
                    <td class="text-right">{{ number_format($pesan['total'], 0) }}</td>
                </tr>

                @if ($loop->last)
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
            <tr style="font-size: 10px; font-weight: bold;">
                <td></td>
                <td></td>
                <td class="text-right">{{ number_format($totalPerType['Material'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Upah Borong Bangunan'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Upah Borong Non Bangunan'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Partisipasi'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Ongkos Kirim'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Operasional Proyek'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Uang Makan Supervisor'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Biaya Kendaraan'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Mobilisasi'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($totalPerType['Adm'] ?? 0) }}</td>
                <td class="text-right">{{ number_format($data->total, 0) }}</td>
            </tr>
            <tr style="font-size: 10px; font-weight: bold;">
                <td></td>
                <td colspan="11">JUMLAH PENGELUARAN</td>
                <td class="text-right">{{ number_format($data->total, 0) }}</td>
            </tr>
        </table>
    {{-- </div> --}}

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
