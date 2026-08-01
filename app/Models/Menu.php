<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasCustomId;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'M';

    protected $fillable = [
        'id_menu',
        'nama_menu',
        'kategori',
        'harga',
        'status_ketersediaan',
    ];

    public function resep(): HasMany
    {
        return $this->hasMany(Resep::class, 'id_menu', 'id_menu');
    }

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_menu', 'id_menu');
    }
}
