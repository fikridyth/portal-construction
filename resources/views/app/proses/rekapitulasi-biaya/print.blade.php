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
            <b>LAPORAN REKAPITULASI BIAYA {{ strToUpper($bulan) }}</b>
        </div>
        <div class="text-start mt-4">
            <div class="row">
                <div class="col-sm-4"><b>NAMA</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->name }}</b></div>
                <div class="col-sm-4"><b>NO ACCOUNT</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->account }}</b></div>
                <div class="col-sm-4"><b>SATUAN</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->currency }}</b></div>
            </div>
        </div>
        <table class="table table-bordered table-hover mt-3" style="width: 100%; font-size: 12px; line-height: 0; border-collapse: collapse;">
            <tr style="font-size: 10px;">
              <th class="text-center align-middle">NO</th>
              <th class="text-center align-middle">TANGGAL</th>
              <th class="text-center align-middle">BRANCH</th>
              <th class="text-center align-middle">TIPE</th>
              <th class="text-center align-middle">KODE</th>
              <th class="text-center align-middle">DESKRIPSI</th>
              <th class="text-center align-middle">JUMLAH</th>
              <th class="text-center align-middle">SISA SALDO</th>
            </tr>
            @foreach(json_decode($data->data, true) as $dt)
                <tr>
                    <td class="text-center"><b>{{ $loop->iteration }}</b></td>
                    <td class="text-center"><b>{{ $dt['Date'] }}</b></td>
                    <td class="text-center"><b>{{ $dt['Branch'] }}</b></td>
                    <td class="text-center"><b>{{ $dt['Tipe'] }}</b></td>
                    <td class="text-center"><b>{{ $dt['Code'] }}</b></td>
                    <td><b>{{ $dt['Desc'] }}</b></td>
                    <td class="text-right"><b>{{ number_format($dt['Amount'], 2) }}</b></td>
                    <td class="text-right"><b>{{ number_format($dt['Balance'], 2) }}</b></td>
                    </tr>
            @endforeach
            {{-- TOTAL --}}
            <tr>
                <td colspan="7" class="text-right"><b>SALDO AWAL</b></td>
                <td class="text-right"><b>{{ number_format($data->starting_balance, 2) }}</b></td>
            </tr>
            <tr>
                <td colspan="7" class="text-right"><b>CREDIT</b></td>
                <td class="text-right"><b>{{ number_format($data->credit, 2) }}</b></td>
            </tr>
            <tr>
                <td colspan="7" class="text-right"><b>DEBET</b></td>
                <td class="text-right"><b>{{ number_format($data->debet, 2) }}</b></td>
            </tr>
            <tr>
                <td colspan="7" class="text-right"><b>SALDO AKHIR</b></td>
                <td class="text-right"><b>{{ number_format($data->ending_balance, 2) }}</b></td>
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
