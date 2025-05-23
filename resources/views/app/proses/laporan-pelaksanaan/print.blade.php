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
    
    <div class="title mt-2 mb-4">
        <h5>LAPORAN BULANAN</h5>
        <h5>PELAKSANAAN PEKERJAAN</h5>
    </div>

    <div class="container" style="font-size: 13px;">
        <div class="row mb-4">
            <div class="col-7"></div>
            <div class="col-2">BULAN KE</div>
            <div class="col-3">:&emsp14;&emsp14;&emsp14; {{ $data->bulan_ke }} ({{ numberToText($data->bulan_ke) }})</div>
            <div class="col-7"></div>
            <div class="col-2">TANGGAL</div>
            <div class="col-3">:&emsp14;&emsp14;&emsp14; {{ $range }}</div>
        </div>
        <div class="row border p-4">
            <div class="col-3">PEKERJAAN</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ strToUpper($data->proyek->nama) }}</div>
            <div class="col-3">LOKASI</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ strToUpper($data->proyek->lokasi) }}</div>
            <div class="col-3">KONTRAK PEKERJAAN</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ strToUpper($data->proyek->kontrak) }}</div>
            <div class="col-3">NILAI KONTRAK</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; Rp.{{ number_format($data->proyek->nilai_kontrak, 0) }}</div>
            <div class="col-3">PELAKSANA</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ strToUpper($data->proyek->pelaksana) }}</div>
            <div class="col-3">MASA PELAKSANAAN</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ $range }}</div>
        </div>
        <div class="row border p-4">
            <div class="col-3">PEKERJAAN DIMULAI TANGGAL</div>
            <div class="col-9" style="height: 50px;">:&emsp14;&emsp14;&emsp14; {{ $mulai }}</div>
            <div class="col-3">KEADAAN TENAGA KERJA</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ $data->keadaan_tenaga == 1 ? 'TERLAMPIR' : 'TIDAK TERLAMPIR' }}</div>
            <div class="col-3">KEADAAN BAHAN BANGUNAN</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ $data->keadaan_bahan == 1 ? 'TERLAMPIR' : 'TIDAK TERLAMPIR' }}</div>
            <div class="col-3">KEADAAN KEUANGAN</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ $data->keadaan_keuangan == 1 ? 'TERLAMPIR' : 'TIDAK TERLAMPIR' }}</div>
            <div class="col-12" style="height: 50px;">EVALUASI DIREKSI</div>
            <div class="col-3">REALISASI KEMAJUAN PEKERJAAN</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ $data->realisasi }}%</div>
            <div class="col-3">RENCANA PEKERJAAN</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ $data->rencana }}%</div>
            <div class="col-3">DEVIASI</div>
            <div class="col-9">:&emsp14;&emsp14;&emsp14; {{ $data->deviasi }}%</div>
        </div>
        <div class="row border p-4">
            <div class="col-3" style="height: 150px;">KETERANGAN</div>
        </div>
        <span>*) CORET YANG TIDAK PERLU</span>

        <div class="d-flex justify-content-between mx-5" style="margin-top: 100px;">
            <span>Kasubdis Sarpras Diskonsau</span>
            <span>{{ strToUpper($data->proyek->pelaksana) }}</span>
        </div>
    
        <div class="d-flex justify-content-between mx-5" style="height: 120px;">
            <span>&emsp14;&emsp14;Selaku Wakil Tim Direksi,</span>
        </div>

        <div class="d-flex justify-content-between mx-3">
            <span><u><b>I Dewa Agung Agus Miartha, S.T.,M.Si.</b></u></span>
            <span style="margin-right: 50px;"><u><b>Ananto Pratama Z</b></u></span>
        </div>

        <div class="d-flex justify-content-between mx-3">
            <span style="margin-left: 40px;"><b>Kolonel Sus NRP 525880</b></span>
            <span style="margin-right: 80px;"><b>Direktur</b></span>
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
