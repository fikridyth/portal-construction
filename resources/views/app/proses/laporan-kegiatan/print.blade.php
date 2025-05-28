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
    @php
        $bulan = [
            'Jan' => 'Januari',
            'Feb' => 'Februari',
            'Mar' => 'Maret',
            'Apr' => 'April',
            'May' => 'Mei',
            'Jun' => 'Juni',
            'Jul' => 'Juli',
            'Aug' => 'Agustus',
            'Sep' => 'September',
            'Oct' => 'Oktober',
            'Nov' => 'November',
            'Dec' => 'Desember',
        ];
        $tgl = $mulai->format('d');
        $bln = $bulan[$mulai->format('M')];
        $thn = $mulai->format('Y');
        $tglS = $sampai->format('d');
        $blnS = $bulan[$sampai->format('M')];
        $thnS = $sampai->format('Y');
    @endphp
    <div class="title mt-2 mb-4">
        <h5>LAPORAN KEGIATAN BULANAN</h5>
        <h5>{{ strToUpper($data->proyek->nama) }}</h5>
        <h5>DI {{ strToUpper($data->proyek->lokasi) }}</h5>
    </div>

    <div class="container" style="font-size: 13px;">
        <div class="row mb-4">
            <div class="col-12 mb-2"><b>1 &emsp14;&emsp14;&emsp14;&emsp14;&emsp14; DASAR</b></div>
            <div class="col-1">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; a)</div>
            <div class="col-11">Kontrak Kerja Konstruksi Nomor {{ preg_replace('/^[^\/]+/', 'KPK', strToUpper($data->proyek->kontrak)) }}</div>
            <div class="col-1"></div>
            <div class="col-11">Tanggal {{ "$tgl $bln $thn" }}</div>
            <div class="col-1">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; b)</div>
            <div class="col-11">Surat Perintah Mulai Kerja Nomor {{ preg_replace('/^[^\/]+/', 'SPMK', strToUpper($data->proyek->kontrak)) }}</div>
            <div class="col-1"></div>
            <div class="col-11">Tanggal {{ "$tgl $bln $thn" }}</div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-2"><b>2 &emsp14;&emsp14;&emsp14;&emsp14;&emsp14; DATA UMUM KEGIATAN</b></div>
            <div class="col-1">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; a)</div>
            <div class="col-11">Pelaksana : {{ $data->proyek->pelaksana }}</div>
            <div class="col-1">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; b)</div>
            <div class="col-11">Nilai Kontrak : {{ number_format($data->proyek->nilai_kontrak, 0) }}</div>
            <div class="col-1">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; c)</div>
            <div class="col-11">Waktu Pelaksanaan : {{ $waktu }} ({{ numberToText($waktu) }}) hari Kalender</div>
            <div class="col-1">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; d)</div>
            <div class="col-11">Pekerjaan Dimulai : {{ "$tgl $bln $thn" }}</div>
            <div class="col-1">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; e)</div>
            <div class="col-11">Periode Pelaksanaan Pekerjaan Bulan Ke {{ $data->bulan_ke }} Tanggal {{ $proyekRange }}</div>
        </div>
        <table class="table table-bordered table-hover mt-3" style="width: 100%; line-height: 0; border-collapse: collapse;">
            <tr>
                <th class="text-center align-middle" style="width: 5%;">NO</th>
                <th class="text-center align-middle">URAIAN PEKERJAAN</th>
                <th class="text-center align-middle">KETERANGAN</th>
            </tr>
            @foreach($dataPekerjaanById as $idPekerjaan => $data2)
                @php
                    $getNama = \App\Models\Pekerjaan::where('id', $idPekerjaan)->value('nama');
                    $no = 1;
                @endphp
                <tr>
                    <td class="text-center"><b>{{ toRoman($loop->iteration) }}</b></td>
                    <td><b>{{ $getNama }}</b></td>
                    <td></td>
                </tr>

                {{-- Loop isi detail pekerjaan --}}
                @foreach(json_decode($data->list_pekerjaan, true) as $dt)
                    @if ($dt['id_pekerjaan'] == $idPekerjaan)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $dt['nama_pekerjaan'] }}</td>
                            <td class="text-center">{{ number_format($dt['bobot_total'],0) ?? 0 }}%</td>
                        </tr>
                    @endif
                @endforeach


                {{-- Tambahkan baris kosong antar grup --}}
                @if (!$loop->last)
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="2" class="text-center"><b>REALISASI</b></td>
                <td class="text-center">{{ $data->realisasi }}%</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center"><b>KEMAJUAN PEKERJAAN</b></td>
                <td class="text-center">{{ $data->kemajuan }}%</td>
            </tr>
        </table>
        <div class="row mb-4">
            <div class="col-12 mb-2"><b>3 &emsp14;&emsp14;&emsp14;&emsp14;&emsp14; PRESTASI PELAKSANAAN PEKERJAAN</b></div>
            <div class="col-12">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; Prestasi Pelaksanaan {{ strToUpper($data->proyek->nama) }} yang bertempat di {{ strToUpper($data->proyek->lokasi) }}</div>
            <div class="col-12">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; Sampai dengan tanggal {{ "$tglS $blnS $thnS" }} adalah {{ $data->realisasi }}% sedangkan prestasi rencana sebesar {{ $data->rencana }}% sehingga terjadi kemajuan sebesar {{ $data->kemajuan }}%</div>
            <div class="col-12">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; dari yang direncanakan</div>
        </div>
        <div class="row mb-4 mt-3">
            <div class="col-12 mb-2"><b>4 &emsp14;&emsp14;&emsp14;&emsp14;&emsp14; SITUASI PEKERJAAN</b></div>
            <div class="col-12">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; {{ $data->situasi_pekerjaan }}</div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-2"><b>5 &emsp14;&emsp14;&emsp14;&emsp14;&emsp14; PERMASALAHAN</b></div>
            <div class="col-12">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; {{ $data->permasalahan }}</div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-2"><b>6 &emsp14;&emsp14;&emsp14;&emsp14;&emsp14; PENUTUP</b></div>
            <div class="col-12">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; Demikian Laporan Kegiatan {{ strToUpper($data->proyek->nama) }} yang bertempat</div>
            <div class="col-12">&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;&emsp14; di {{ strToUpper($data->proyek->lokasi) }}</div>
        </div>

        <div class="d-flex justify-content-end mx-5" style="margin-top: 25px;">
            <span><b>Dibuat Oleh,</b></span>
        </div>
    
        <div class="d-flex justify-content-end mx-3" style="height: 10px;">
            <span><b>{{ strToUpper($data->proyek->pelaksana) }}</b></span>
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
