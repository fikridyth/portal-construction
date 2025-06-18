<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKomparasi extends Model
{
    use HasFactory;

    protected $table = 'laporan_komparasis';
    protected $guarded = ['id'];

    public function preorder()
    {
        return $this->belongsTo(Preorder::class, 'id_preorder');
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
