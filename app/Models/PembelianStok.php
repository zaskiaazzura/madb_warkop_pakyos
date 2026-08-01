<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembelianStok extends Model
{
    use HasCustomId;

    protected $table = 'pembelianstok';
    protected $primaryKey = 'id_pembelian';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'PBL';

    protected $fillable = [
        'id_pembelian',
        'id_supplier',
        'tanggal_pembelian',
        'total_pembelian',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function detailPembelianStok(): HasMany
    {
        return $this->hasMany(DetailPembelianStok::class, 'id_pembelian', 'id_pembelian');
    }
}
