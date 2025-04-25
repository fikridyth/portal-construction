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

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #444;
            padding: 4px;
        }
        th {
            background-color: #f0f0f0;
        }
        .title {
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="title">
        <h5>REKAP MINGGUAN</h5>
        <h5>KEADAAN CUACA</h5>
    </div>

    <div class="row mt-5 mb-4">
        <div class="col-1"></div>
        <div class="col-3">NAMA PEKERJAAN</div>
        <div class="col-8">: {{ strToUpper($data->laporanMingguan->proyek->nama) }}</div>
        <div class="col-1"></div>
        <div class="col-3">LOKASI PEKERJAAN</div>
        <div class="col-8">: {{ strToUpper($data->laporanMingguan->proyek->lokasi) }}</div>
        <div class="col-1"></div>
        <div class="col-3">TAHUN ANGGARAN</div>
        <div class="col-8">: {{ strToUpper($data->laporanMingguan->proyek->tahun_anggaran) }}</div>
        <div class="col-1"></div>
        <div class="col-3">KONTRAK</div>
        <div class="col-8">: {{ strToUpper($data->laporanMingguan->proyek->kontrak) }}</div>
        <div class="col-1"></div>
        <div class="col-3">PELAKSANA</div>
        <div class="col-8">: {{ strToUpper($data->laporanMingguan->proyek->pelaksana) }}</div>
        <div class="col-1"></div>
        <div class="col-3">DIREKTUR</div>
        <div class="col-8">: {{ strToUpper($data->laporanMingguan->proyek->direktur) }}</div>
        <div class="col-1"></div>
        <div class="col-3">MASA PELAKSANAAN</div>
        <div class="col-8">: {{ $range }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">HARI</th>
                @for ($j = 6; $j <= 20; $j++)
                    <th class="text-center">{{ $j }}:00</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>.</td>
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
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $namaHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $simbol = ['Baik' => 'O', 'Hujan' => 'X', 'Berawan' => 'V'];
            @endphp
            @foreach ($namaHari as $hari)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-start">{{ strToUpper($hari) }}</td>
                    @for ($j = 6; $j <= 20; $j++)
                        @php
                            $cuaca = $listCuaca[$hari][$j] ?? '-';
                        @endphp
                        <td class="text-center">{{ $simbol[$cuaca] ?? '-' }}</td>
                    @endfor
                </tr>
                <tr>
                    <td>.</td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row mt-1 mb-5">
        <div class="col-1"></div>
        <div class="col-3">O = BAIK</div>
        <div class="col-8"></div>
        <div class="col-1"></div>
        <div class="col-3">X = HUJAN</div>
        <div class="col-8"></div>
        <div class="col-1"></div>
        <div class="col-3">V = BERAWAN</div>
        <div class="col-8"></div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="text-center w-100">
            <h6>KasiFasint Lanud SIM</h6>
        </div>
        <div class="text-center w-100">
            <h6>{{ strToUpper($data->laporanMingguan->proyek->pelaksana) }}</h6>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div class="text-center w-100">
            <h6>Selaku Anggota Tim Direksi,</h6>
        </div>
        <div class="text-center w-100" style="margin-top: 150px;">
            <h6>PARMUN</h6>
            <h6>Site Manager</h6>
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
