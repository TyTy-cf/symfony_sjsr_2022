<?php

namespace App\Twig;

use App\Controller\Front\AjaxController;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class HeaderExtension extends AbstractExtension
{

    public function __construct(
        private GenreRepository $genreRepository,
        private SessionInterface $session
    ) { }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('functionTwigGetGenres', [$this, 'bebou']),
            new TwigFunction('functionGetQuantitySession', [$this, 'getQuantitySession']),
        ];
    }

    public function bebou(): array
    {
        return $this->genreRepository->findAll();
    }

    public function getQuantitySession(): string {
        $qtyValue = $this->session->get(AjaxController::$QTY);
        if ($qtyValue === null) {
            $qtyValue = '';
        }
        return $qtyValue;
    }
}
