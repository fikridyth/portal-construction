<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $table = 'proyeks';
    protected $guarded = ['id'];

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_pm');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'user_spv');
    }

    public function purchasing()
    {
        return $this->belongsTo(User::class, 'user_purchasing');
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
