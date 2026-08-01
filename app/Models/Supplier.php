<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasCustomId;

    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'SUP';

    protected $fillable = [
        'id_supplier',
        'nama_supplier',
        'kontak',
        'alamat',
    ];

    public function pembelianStok(): HasMany
    {
        return $this->hasMany(PembelianStok::class, 'id_supplier', 'id_supplier');
    }
}
