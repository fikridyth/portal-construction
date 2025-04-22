<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumentasiMingguan extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_mingguans';
    protected $guarded = ['id'];

    public function laporanMingguan()
    {
        return $this->belongsTo(LaporanMingguan::class, 'id_laporan_mingguans');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
