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
    </style>
</head>
<body>
    <div class="text-center">
        <h1 class="mt-5" style="color: rgb(60, 60, 243);">CV. TRI CIPTA GEMILANG</h1>
        <h4 style="color: rgb(60, 60, 243);">General Contractor & Supplier</h4>
        <h5>DOKUMENTASI PROYEK MINGGU {{ $data->laporanMingguan->minggu_ke }} ({{ $range }})</h5>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-2"></div>
        <div class="col-2">Nama Proyek</div>
        <div class="col-8">: {{ strToUpper($data->laporanMingguan->proyek->nama) }}</div>
        <div class="col-2"></div>
        <div class="col-2">Kontraktor</div>
        <div class="col-8">: CV. TRI CIPTA GEMILANG</div>
        <div class="col-2"></div>
        <div class="col-2">Waktu Pelaksanaan</div>
        <div class="col-8">: {{ numberToText($data->laporanMingguan->proyek->waktu_pelaksanaan) }} ( {{ $data->laporanMingguan->proyek->waktu_pelaksanaan }} ) hari Kalender</div>
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
