<?php

namespace App\Twig;

use App\Service\ExcerptService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ExcerptExtension extends AbstractExtension
{

    public function __construct(
        private ExcerptService $excerptService
    ) { }

    public function getFilters(): array
    {
        return [
            // Premier param : nom dans le twig
            // Deuxième param : l'action à effectuer, on indique où se situe la fonction puis le nom de celle-ci
            new TwigFilter('excerpt', [$this, 'excerpt']),
        ];
    }

    /**
     * @param string $value => le type du paramètre est celui sur lequel vous appliquez le filtre (dans le twig)
     * @return string
     */
    public function excerpt(string $value): string
    {
        return $this->excerptService->excerpt($value);
    }
}
