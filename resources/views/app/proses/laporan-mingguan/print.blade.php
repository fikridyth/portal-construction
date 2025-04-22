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
            <b>LAPORAN PROGRESS MINGGUAN</b>
        </div>
        <div class="text-start mt-4">
            <div class="row">
                <div class="col-sm-4"><b>NAMA PEKERJAAN</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->proyek->nama }}</b></div>
                <div class="col-sm-4"><b>LOKASI PEKERJAAN</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->proyek->lokasi }}</b></div>
                <div class="col-sm-4"><b>TAHUN ANGGARAN</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->proyek->tahun_anggaran }}</b></div>
                <div class="col-sm-4"><b>KONTRAK</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->proyek->kontrak }}</b></div>
                <div class="col-sm-4"><b>PELAKSANA</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->proyek->pelaksana }}</b></div>
                <div class="col-sm-4"><b>DIREKTUR</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $data->proyek->direktur }}</b></div>
                <div class="col-sm-4"><b>MASA PELAKSANAAN</b></div>
                <div class="col-sm-8"><b>:&emsp14;&emsp14;&emsp14; {{ $masaPelaksanaan }}</b></div>
            </div>
        </div>
        <div class="text-right mt-1 mr-5">
            <b>Minggu Ke &emsp14;&emsp14;&emsp14;: {{ toRoman($data->minggu_ke) }}</b>
        </div>
        <table class="table table-bordered table-responsive table-hover mt-3" style="font-size: 12px; line-height: 0; border-collapse: collapse;">
            <tr>
              <th rowspan="2" class="text-center align-middle">NO</th>
              <th rowspan="2" class="text-center align-middle">URAIAN PEKERJAAN</th>
              <th rowspan="2" class="text-center align-middle">VOLUME</th>
              <th rowspan="2" class="text-center align-middle">SATUAN</th>
              <th class="text-center align-middle">BOBOT</th>
              <th colspan="2" class="text-center align-middle">TOTAL PROGRESS MINGGU LALU</th>
              <th colspan="2" class="text-center align-middle">TOTAL PROGRESS MINGGU INI</th>
              <th colspan="2" class="text-center align-middle">TOTAL PROGRESS</th>
            </tr>
            <tr>
                <th class="text-center align-middle">%</th>
                <th class="text-center align-middle">PRESTASI</th>
                <th class="text-center align-middle">BOBOT</th>
                <th class="text-center align-middle">PRESTASI</th>
                <th class="text-center align-middle">BOBOT</th>
                <th class="text-center align-middle">PRESTASI</th>
                <th class="text-center align-middle">BOBOT</th>
            </tr>
            @php 
                $totalBobot = 0;
                $totalBobotMingguLalu = 0;
                $totalBobotMingguIni = 0;
                $totalBobotSeluruh = 0;
            @endphp
            @foreach($dataPekerjaanById as $idPekerjaan => $data2)
                @php
                    $getNama = \App\Models\Pekerjaan::where('id', $idPekerjaan)->value('nama');
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
                    <td></td>
                    <td></td>
                </tr>

                {{-- Loop isi detail pekerjaan --}}
                @foreach(json_decode($data->list_pekerjaan, true) as $dt)
                    @if ($dt['id_pekerjaan'] == $idPekerjaan)
                        @php 
                            $totalBobot += (float) $dt['bobot'];
                            $totalBobotMingguLalu += (float) $dt['bobot_minggu_lalu'];
                            $totalBobotMingguIni += (float) $dt['bobot_minggu_ini'];
                            $totalBobotSeluruh += (float) $dt['bobot_total'];
                        @endphp
                        <tr>
                            <td class="text-right">{{ $loop->iteration }}</td>
                            <td>{{ $dt['nama_pekerjaan'] }}</td>
                            <td class="text-right">{{ $dt['volume'] }}</td>
                            <td class="text-center">{{ $dt['satuan'] }}</td>
                            <td class="text-right">{{ $dt['bobot'] }}</td>
                            <td class="text-center">{{ $dt['progress_minggu_lalu'] }} %</td>
                            <td class="text-right">{{ $dt['bobot_minggu_lalu'] }}</td>
                            <td class="text-center">{{ $dt['progress_minggu_ini'] }} %</td>
                            <td class="text-right">{{ $dt['bobot_minggu_ini'] }}</td>
                            <td class="text-center">{{ $dt['progress_total'] }} %</td>
                            <td class="text-right">{{ $dt['bobot_total'] }}</td>
                        </tr>
                    @endif
                @endforeach


                {{-- Tambahkan baris kosong antar grup --}}
                @if (!$loop->last)
                    <tr>
                        <td colspan="11"></td>
                    </tr>
                @endif
            @endforeach
            {{-- TOTAL --}}
            <tr>
                <td colspan="4" class="text-right"><b>TOTAL</b></td>
                <td class="text-right"><b>{{ number_format($totalBobot, 2) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($totalBobotMingguLalu, 3) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($totalBobotMingguIni, 3) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($totalBobotSeluruh, 3) }}</b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>PROGRESS MINGGU LALU</b></td>
                <td colspan="7" class="text-right"><b>{{ number_format($totalBobotMingguLalu, 3) }}</b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>PROGRESS MINGGU INI</b></td>
                <td colspan="7" class="text-right"><b>{{ number_format($totalBobotMingguIni, 3) }}</b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>PROGRESS RENCANA MINGGU INI</b></td>
                <td colspan="7" class="text-right"><b>{{ number_format($data->bobot_rencana, 3) }}</b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>DEVIASI PROGRESS</b></td>
                <td colspan="7" class="text-right"><b>{{ number_format($totalBobotSeluruh - $data->bobot_rencana, 3) }}</b></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>PROGRESS PERIODE MINGGU INI</b></td>
                <td colspan="7" class="text-right"><b>{{ number_format($totalBobotMingguIni, 3) }}</b></td>
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
