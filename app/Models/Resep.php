<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resep extends Model
{
    use HasCustomId;

    protected $table = 'resep';
    protected $primaryKey = 'id_resep';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'RSP';

    protected $fillable = [
        'id_resep',
        'id_menu',
        'id_bahan',
        'jumlah_dibutuhkan',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahan', 'id_bahan');
    }
}
