<!DOCTYPE html>
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
            }
            .no-print {
                display: none;
            }
        }
        .dashed-line {
            border: 0;
            border-top: 1px dashed black; /* Ganti 'black' dengan warna yang diinginkan */
            margin: 2px 0; /* Sesuaikan margin sesuai kebutuhan */
        }
        .dashed-line-2 {
            border: 0;
            border-top: 1px dashed black; /* Ganti 'black' dengan warna yang diinginkan */
            margin: 0; /* Sesuaikan margin sesuai kebutuhan */
        }
        .text-center-compact {
            text-align: center;
            margin-bottom: 0;
            line-height: 1.2; /* Bisa diatur agar teks tidak terlalu rapat atau terlalu renggang */
        }
        .table td {
            vertical-align: top; /* Agar konten tetap di atas sel */
        }
        .multi-line {
            line-height: 1.2; /* Sesuaikan jarak antar baris */
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="text-center-compact" style="font-size: 12px;"><b>{{ strToUpper($data->proyek->pelaksana) }}</b></div>
        <div class="text-center-compact" style="font-size: 12px;">Jl. Manggis Dalam Blok B No. 1K Kel. Mangga Besar</div>
        <div class="text-center-compact mb-2" style="font-size: 12px;">Kec. Taman Sari Jakarta Barat</div>
        <hr class="dashed-line-2">
        <div class="text-center mt-1"><h5><b>LAPORAN HARIAN</b></h5></div>
        <hr class="dashed-line-2">
        <div class="text-center mt-1"><h5><b>MINGGU {{ $data->minggu_ke }}</b></h5></div>
        <div class="text-start mt-4" style="margin-bottom: 0; line-height: 1.2; font-size: 12px;">
            <div class="row">
                <div class="col-sm-2"><b>Hari</b></div>
                <div class="col-sm-10"><b>:&emsp14;&emsp14;&emsp14; {{ $data->hari }}</b></div>
                <div class="col-sm-2"><b>Tanggal</b></div>
                <div class="col-sm-10"><b>:&emsp14;&emsp14;&emsp14; {{ $dataTanggal }}</b></div>
                <div class="col-sm-2"><b>Pekerjaan</b></div>
                <div class="col-sm-10"><b>:&emsp14;&emsp14;&emsp14; {{ strToUpper($data->proyek->nama) }}</b></div>
                <div class="col-sm-2"><b>Lokasi</b></div>
                <div class="col-sm-10"><b>:&emsp14;&emsp14;&emsp14; DI {{ strToUpper($data->proyek->lokasi) }}</b></div>
            </div>
        </div>
        <table class="table table-bordered table-hover mt-3" style="width: 100%; font-size: 12px; line-height: 0; border-collapse: collapse;">
            <tr>
              <th colspan="2" class="text-center align-middle" style="width: 25%">TENAGA KERJA</th>
              <th colspan="2" class="text-center align-middle" style="width: 25%">BAHAN BANGUNAN</th>
              <th class="text-center" style="border-bottom: none;">Jumlah</th>
              <th class="text-center" style="border-bottom: none;">Jumlah</th>
              <th colspan="2" class="text-center" style="width: 20%">Peralatan</th>
              <th class="text-center" style="border-bottom: none; width: 20%">Pekerjaan yang</th>
            <tr>
                <th class="text-center align-middle">Jumlah</th>
                <th class="text-center align-middle">Keahlian</th>
                <th colspan="2" class="text-center align-middle" style="font-size: 10px;">Jenis barang yang didatangkan</th>
                <th class="text-center align-middle" style="border-top: none;">diterima</th>
                <th class="text-center align-middle" style="border-top: none;">ditolak</th>
                <th class="text-center align-middle">Jenis</th>
                <th class="text-center align-middle">Jumlah</th>
                <th class="text-center align-middle" style="border-top: none;">diselenggarakan pada hari</th>
            </tr>
            <tr style="height: 150px;">
                <td class="text-center multi-line">
                    @foreach(json_decode($data->list_tenaga, true) as $tenaga)
                        {{ $tenaga['jumlah'] }} <br>
                    @endforeach
                </td>
                <td class="text-center multi-line">
                    @foreach(json_decode($data->list_tenaga, true) as $tenaga)
                        {{ $tenaga['nama'] }} <br>
                    @endforeach
                </td>
                <td class="multi-line">
                    @foreach(json_decode($data->list_bahan, true) as $bahan)
                        {{ $bahan['nama'] }} <br>
                    @endforeach
                </td>
                <td class="text-center multi-line">
                    @foreach(json_decode($data->list_bahan, true) as $bahan)
                        bh <br>
                    @endforeach
                </td>
                <td class="text-center multi-line">
                    @foreach(json_decode($data->list_bahan, true) as $bahan)
                        {{ $bahan['jumlah'] }} <br>
                    @endforeach
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="9">
                    <div class="row">
                        <div class="col-6">Pekerjaan dimulai jam: 08.00 WIB</div>
                        <div class="col-6">Selesai jam: 17.00 WIB</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="multi-line">
                    Hari ini: <br><br>
                    Karena: <br>
                </td>
                <td colspan="2" class="multi-line">
                    <br>
                    Pagi <br>
                    Siang <br>
                    Sore
                </td>
                <td colspan="2"></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="6">Catatan tentang pekerjaan/perintah pemilik/direksi</td>
                <td colspan="2" class="text-center multi-line">
                    <b>Kasubsi BTB Lanud SIM</b> <br>
                    selaku Anggota Tim Direksi,
                </td>
                <td colspan="2" class="text-center multi-line">
                    <b>{{ strToUpper($data->proyek->pelaksana) }}</b> <br><br><br><br><br>
                    <b>Parmin</b> <br>
                    Site Manager
                </td>
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
