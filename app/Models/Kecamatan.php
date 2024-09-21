<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    protected $primaryKey = 'kecamatan_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'kecamatan_id',
        'nama_kecamatan',
    ];

    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class, 'kecamatan_id', 'kecamatan_id');
    }
}
