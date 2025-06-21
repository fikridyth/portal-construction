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
            <h4>LAPORAN KOMPARASI</h4>
        </div>
        <div class="text-center mt-2">
            <h5>{{ strtoupper($data->preorder->proyek->nama) }} - MINGGU KE {{ $data->preorder->minggu_ke }}</h5>
        </div>
        <div class="text-center mb-4">
            <h6>{{ $masaPelaksanaan }}</h6>
        </div>
        <table class="table table-bordered table-hover mt-3" style="width: 100%; font-size: 18px; border-collapse: collapse;">
            <tr style="height: 50px;">
                <th class="text-center align-middle">NO</th>
                <th class="text-center align-middle">NAMA</th>
                <th class="text-center align-middle">VOLUME</th>
                <th class="text-center align-middle">PENGGUNAAN</th>
                <th class="text-center align-middle">BOBOT</th>
            </tr>
            @foreach($listPesanan as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item['nama'] ?? '-' }}</td>
                <td>{{ $item['volume'] . ' ' . $item['satuan'] ?? '-' }}</td>
                <td>{{ $item['progress'] . ' ' . $item['satuan'] ?? '-' }}</td>
                <td class="text-center">{{ number_format($item['bobot'],0) . '%' ?? '-' }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right"><b>TOTAL BOBOT</b></td>
                <td class="text-center">{{ number_format($data->total_progress,0) . '%' ?? '-' }}</td>
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
