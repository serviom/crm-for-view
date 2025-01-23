<?php
namespace App\Enums;

class ClientStatus extends BaseEnum
{
    const STATUS_ARCHIVE = 1;

    public function get($model, $key, $value, $attributes) :array
    {
        return [
            'value' => $value,
            'is_archive' => self::isArchive($value),
        ];
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value === self::STATUS_ARCHIVE ? $value : null;
    }

    /**
     * @return bool
     */
    public static function isArchive($status) :bool
    {
        return $status === self::STATUS_ARCHIVE;
    }
}
