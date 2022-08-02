<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    public function __construct(
        private GameRepository $gameRepository
    ) { }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/game/{slug}', name: 'app_game_show')]
    public function show(string $slug): Response
    {
        dump($this->gameRepository->findBySlugRelations($slug));

        return $this->render('game/index.html.twig', [
            'game' => $this->gameRepository->findBySlugRelations($slug),
        ]);
    }
}
