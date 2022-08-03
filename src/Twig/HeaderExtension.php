<?php

namespace App\Twig;

use App\Repository\GenreRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class HeaderExtension extends AbstractExtension
{

    public function __construct(
        private GenreRepository $genreRepository
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('functionTwigGetGenres', [$this, 'bebou']),
        ];
    }

    public function bebou(): array
    {
        return $this->genreRepository->findAll();
    }
}
