<?php

namespace App\Controller\Helpers;

class DataFormat
{
    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public static function trimData(array $data): array
    {
        $trimmedData = [];

        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $trimmedData[$key] = self::trimData($value);
            } elseif (\is_string($value)) {
                $trimmedData[$key] = \trim($value);
            } else {
                $trimmedData[$key] = $value;
            }
        }

        return $trimmedData;
    }
}
