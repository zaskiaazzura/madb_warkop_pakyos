<?php

namespace App\Policies;

use App\Models\DetailPesanan;
use App\Models\User;

class DetailPesananPolicy
{
    /**
     * Determine whether the user can update the detail pesanan status_item.
     */
    public function update(User $user, DetailPesanan $detailPesanan): bool
    {
        return !empty($user->id_karyawan) && $detailPesanan->id_petugas === $user->id_karyawan;
    }
}
