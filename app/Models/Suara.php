<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str for UUID generation

class Suara extends Model
{
    use HasFactory;

    protected $table = 'suara';
    protected $primaryKey = 'suara_id';
    public $incrementing = false; // Set incrementing to false since suara_id is a UUID
    protected $keyType = 'string'; // Set key type to string for UUID

    // Automatically generate UUID for suara_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid(); // Generate UUID for suara_id
            }
        });
    }

    protected $fillable = [
        'suara_id',
        'tps_id',
        'kelurahan_id',
        'calon_id',
        'jumlah_suara',
    ];

    // Define relationship with TPS
    public function tps()
    {
        return $this->belongsTo(Tps::class, 'tps_id', 'tps_id');
    }

    // Define relationship with Calon
    public function calon()
    {
        return $this->belongsTo(Calon::class, 'calon_id', 'calon_id');
    }

    // Define relationship with Kelurahan (if needed)
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'kelurahan_id');
    }
}
