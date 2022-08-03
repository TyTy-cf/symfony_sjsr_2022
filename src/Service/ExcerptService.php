<?php

namespace App\Service;

class ExcerptService
{

    public function excerpt(string $value, int $length = 50): string
    {
        if (strlen($value) <= $length) return $value;
        return substr($value, 0, $length) . '...';
    }

}