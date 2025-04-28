<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cco extends Model
{
    use HasFactory;

    protected $table = 'ccos';
    protected $guarded = ['id'];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'id_proyek');
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
