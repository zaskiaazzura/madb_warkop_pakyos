<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPembelianStok extends Model
{
    use HasCustomId;

    protected $table = 'detailpembelianstok';
    protected $primaryKey = 'id_detail_pembelian';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'DPB';

    protected $fillable = [
        'id_detail_pembelian',
        'id_pembelian',
        'id_bahan',
        'jumlah',
        'harga_satuan',
    ];

    public function pembelianStok(): BelongsTo
    {
        return $this->belongsTo(PembelianStok::class, 'id_pembelian', 'id_pembelian');
    }

    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan', 'id_bahan');
    }
}
