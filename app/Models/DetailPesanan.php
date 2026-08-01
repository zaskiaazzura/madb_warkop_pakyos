<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPesanan extends Model
{
    use HasCustomId;

    protected $table = 'detailpesanan';
    protected $primaryKey = 'id_detail_pesanan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'DPS';

    protected $fillable = [
        'id_detail_pesanan',
        'id_pesanan',
        'id_menu',
        'id_petugas',
        'jumlah',
        'subtotal',
        'status_item',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_petugas', 'id_karyawan');
    }
}
