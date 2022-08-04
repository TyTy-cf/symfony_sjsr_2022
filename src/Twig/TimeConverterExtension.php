<?php

namespace App\Twig;

use App\Service\TimeConverterService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TimeConverterExtension extends AbstractExtension
{

    public function __construct(
        private TimeConverterService $timeConverterService
    ) { }

    public function getFilters(): array
    {
        return [
            new TwigFilter('time_converter', [$this, 'getTimeConverter']),
        ];
    }

    public function getTimeConverter(int $value): string
    {
       return $this->timeConverterService->getTimeConverter($value);
    }
}
