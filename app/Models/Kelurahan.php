<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'kelurahans';
    protected $primaryKey = 'kelurahan_id';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'kelurahan_id',
        'kecamatan_id',
        'nama_kelurahan',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'kecamatan_id');
    }

    public function tps()
    {
        return $this->hasMany(Tps::class, 'kelurahan_id', 'kelurahan_id');
    }
}