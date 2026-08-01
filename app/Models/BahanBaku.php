<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BahanBaku extends Model
{
    use HasCustomId;

    protected $table = 'bahanbaku';
    protected $primaryKey = 'id_bahan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'BHN';

    protected $fillable = [
        'id_bahan',
        'nama_bahan',
        'kategori',
        'stok',
        'satuan',
    ];

    public function resep(): HasMany
    {
        return $this->hasMany(Resep::class, 'id_bahan', 'id_bahan');
    }

    public function detailPembelianStok(): HasMany
    {
        return $this->hasMany(DetailPembelianStok::class, 'id_bahan', 'id_bahan');
    }
}
