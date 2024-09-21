<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Calon extends Model
{
    use HasFactory, HasUuids;

    // Nama tabel di database
    protected $table = 'calon';

    // Primary key
    protected $primaryKey = 'calon_id';

    // Jenis primary key
    protected $keyType = 'string';

    // Non-incremental primary key
    public $incrementing = false;

    // Mass assignable attributes
    protected $fillable = [
        'nama',
        'no_urut',
        'partai',
        'foto',
    ];

    // Timestamps
    public $timestamps = true;
}
