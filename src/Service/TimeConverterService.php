<?php

namespace App\Service;

class TimeConverterService
{
    public function getTimeConverter(int $gameTime): string {
        $hours = floor($gameTime / 3600);
        $minutes = ($gameTime % 60);
        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }
        return $hours. 'h' . $minutes;
    }
}