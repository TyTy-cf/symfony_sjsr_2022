<?php

namespace App\Controller;

use App\Repository\GameRepository;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    public function __construct(
        private GameRepository $gameRepository
    ) { }

    #[Route('/game', name: 'app_game_index')]
    public function index(): Response {
        return $this->render('game/index.html.twig', [
            'gamesArray' => $this->gameRepository->findBy([], ['publishedAt' => 'DESC']),
        ]);
    }

    #[Route('/game/{slug}', name: 'app_game_show')]
    public function show(string $slug): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $this->gameRepository->findBySlugRelations($slug),
        ]);
    }
}
