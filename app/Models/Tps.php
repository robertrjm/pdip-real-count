<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tps extends Model
{
    use HasFactory;

    protected $primaryKey = 'tps_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['kelurahan_id', 'nama_tps'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($tps) {
            if (empty($tps->tps_id)) {
                $tps->tps_id = (string) Str::uuid();
            }
        });
    }
}
