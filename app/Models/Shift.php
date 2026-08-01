<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    use HasCustomId;

    protected $table = 'shift';
    protected $primaryKey = 'id_shift';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'SHF';

    protected $fillable = [
        'id_shift',
        'nama_shift',
        'jam_mulai',
        'jam_selesai',
    ];

    public function karyawan(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'id_shift', 'id_shift');
    }
}
