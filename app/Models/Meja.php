<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meja extends Model
{
    use HasCustomId;

    protected $table = 'meja';
    protected $primaryKey = 'id_meja';
    public $incrementing = false;
    protected $keyType = 'string';
    public $idPrefix = 'MJ';

    protected $fillable = [
        'id_meja',
        'nomor_meja',
        'status_meja',
    ];

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_meja', 'id_meja');
    }
}
