<?php

namespace App\Http\Controllers;

use App\DataTables\RekapitulasiBiayaDataTable;
use App\Helpers\AuthHelper;
use App\Models\RekapitulasiBiaya;
use Illuminate\Http\Request;

class RekapitulasiBiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RekapitulasiBiayaDataTable $dataTable)
    {
        $pageHeader = 'Index Rekapitulasi Biaya';
        $pageTitle = 'List Rekapitulasi Biaya';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        return $dataTable->render('app.proses.rekapitulasi-biaya.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets'));
    }

    public function uploadRekapitulasiBiaya(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv'
        ], [
            'file.required' => 'Upload File Terlebih Dahulu!',
            'file.mimes' => 'File hanya boleh format CSV',
        ]);

        // Ambil path file
        $path = $request->file('file')->getRealPath();

        // Buka file CSV
        if (($handle = fopen($path, 'r')) !== false) {
            $metadata = [];
            $transactions = [];
            $summary = [];

            $section = 'meta';

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Bersihkan spasi
                $row = array_map(fn($val) => trim($val, " \t\n\r\0\x0B\"'"), $row);

                // Skip kalau semua kosong
                if (count(array_filter($row)) === 0) {
                    continue;
                }

                // Kalau ini header transaksi
                if ($row[0] === 'Date') {
                    $section = 'transaksi';
                    $headers = $row;
                    continue;
                }

                // Kalau ini summary (mulai dari Starting Balance dst)
                if (in_array($row[0], ['Starting Balance','Credit','Debet','Ending Balance'])) {
                    $section = 'summary';
                }

                // --- Klasifikasi ---
                if ($section === 'meta') {
                    if (isset($row[0], $row[2])) {
                        $metadata[$row[0]] = $row[2];
                    }
                } elseif ($section === 'transaksi') {
                    if (isset($headers) && count($row) >= count($headers)) {
                        // Cocokkan dengan header
                        $row = array_slice($row, 0, count($headers));
                        $transactions[] = array_combine($headers, $row);
                    }
                } elseif ($section === 'summary') {
                    if (isset($row[0], $row[2])) {
                        $summary[$row[0]] = $row[2];
                    }
                }
            }

            fclose($handle);

            $updatedTransactions = [];
            $year = date('Y');
            foreach ($transactions as $transaction) {
                // 1. Pecah description berdasarkan spasi
                $descriptionParts = preg_split('/\s+/', trim($transaction['Description']));
            
                // 2. Ganti key "" menjadi "Tipe"
                $transaction['Tipe'] = $transaction[""];
                unset($transaction[""]);
            
                // 3. Update Description jadi array kata-kata
                $transaction['Description'] = $descriptionParts;
            
                // 4. Tentukan Code dan Desc dari Description yang sudah dipisah
                if (isset($descriptionParts[3])) {
                    $transaction['Code'] = $descriptionParts[3];
                    $transaction['Desc'] = count($descriptionParts) > 4 ? implode(' ', array_slice($descriptionParts, 4)) : '';
                } else {
                    $transaction['Code'] = '-';
                    $parts = [];
                    if (isset($descriptionParts[0])) $parts[] = $descriptionParts[0];
                    if (isset($descriptionParts[1])) $parts[] = $descriptionParts[1];
                    $transaction['Desc'] = implode(' ', $parts);
                }
            
                // 5. Hapus key Description karena sudah diproses
                unset($transaction['Description']);
            
                // 6. Hapus semua angka sebelum titik dan 2 angka setelah titik di Desc
                $transaction['Desc'] = preg_replace('/\d+\.\d{2}/', '', $transaction['Desc']);
                $transaction['Desc'] = trim(preg_replace('/\s+/', ' ', $transaction['Desc'])); // bersihkan spasi ganda
            
                // 7. Ubah Date: dari "dd/mm" jadi "YYYY-mm-dd" dengan tahun sekarang
                list($day, $month) = explode('/', $transaction['Date']);
                $transaction['Date'] = date('Y-m-d', strtotime("$year-$month-$day"));
            
                // 8. Ubah Amount dan Balance jadi float (hilangkan koma)
                $amountNumber = str_replace(',', '', $transaction['Amount']);
                $balanceNumber = str_replace(',', '', $transaction['Balance']);
                $transaction['Amount'] = floatval($amountNumber);
                $transaction['Balance'] = floatval($balanceNumber);
            
                // Simpan ke hasil akhir
                $updatedTransactions[] = $transaction;
            }

            $startingBalance = str_replace(",", "", $summary['Starting Balance']);
            $credit = str_replace(",", "", $summary['Credit']);
            $debet = str_replace(",", "", $summary['Debet']);
            $endingBalance = str_replace(",", "", $summary['Ending Balance']);
            $data = [
                'account' => $metadata['Account No.'],
                'name' => $metadata['Name'],
                'currency' => $metadata['Currency'],
                'tanggal' => $updatedTransactions[0]['Date'],
                'data' => json_encode($updatedTransactions),
                'starting_balance' => floatval($startingBalance),
                'credit' => floatval($credit),
                'debet' => floatval($debet),
                'ending_balance' => floatval($endingBalance),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];
            // dd($data);

            RekapitulasiBiaya::create($data);
        }

        return back()->with('success', 'Data berhasil diimport!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = dekrip($id);
        $assets = ['data-table'];
        $pageHeader = 'Lihat Rekapitulasi Biaya';
        $data = RekapitulasiBiaya::findOrFail($id);
        $bulan = \Carbon\Carbon::parse($data->tanggal)->locale('id')->translatedFormat('F Y');

        return view('app.proses.rekapitulasi-biaya.show', compact('pageHeader', 'data', 'assets', 'bulan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
