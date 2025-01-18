<?php

namespace App\Controller\Helpers;

class DataFormat
{
    /**
     * @param array<string, string|mixed> $data
     * @return array<string, string|mixed>
     */
    public static function trimData(array $data): array
    {
        return \array_map(function ($value) {
            return \is_string($value) ? \trim($value) : $value;
        }, $data);
    }
}
