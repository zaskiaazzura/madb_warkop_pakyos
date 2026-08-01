<?php

namespace App\Traits;

trait HasCustomId
{
    protected static function bootHasCustomId(): void
    {
        static::creating(function ($model) {
            $keyName = $model->getKeyName();
            if (empty($model->{$keyName})) {
                $prefix = property_exists($model, 'idPrefix') ? $model->idPrefix : 'ID';
                $padLength = property_exists($model, 'idPadLength') ? $model->idPadLength : 3;

                $latest = static::query()
                    ->where($keyName, 'LIKE', $prefix . '%')
                    ->orderByRaw("CAST(SUBSTRING({$keyName}, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
                    ->first();

                if ($latest) {
                    $number = (int) substr($latest->{$keyName}, strlen($prefix)) + 1;
                } else {
                    $number = 1;
                }

                $model->{$keyName} = $prefix . str_pad((string)$number, $padLength, '0', STR_PAD_LEFT);
            }
        });
    }
}
