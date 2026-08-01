<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    use HasCustomId;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'KRW';

    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'peran',
        'no_telepon',
        'id_shift',
    ];

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'id_shift', 'id_shift');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_karyawan', 'id_karyawan');
    }

    public function pesananKasir(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_kasir', 'id_karyawan');
    }

    public function detailPesananPetugas(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_petugas', 'id_karyawan');
    }
}
