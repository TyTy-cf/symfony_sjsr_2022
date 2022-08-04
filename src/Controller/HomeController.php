<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        GameRepository $gameRepository,
        CommentRepository $commentRepository,
        GenreRepository $genreRepository
    ): Response
    {
        return $this->render('front/home/index.html.twig', [
            'mostPlayedGames' => $gameRepository->getGroupedByGameByOrder(),
            'lastPublished' => $gameRepository->findBy([], ['publishedAt' => 'DESC'], 4),
            'lastComments' => $commentRepository->findBy([], ['createdAt' => 'DESC'], 4),
            'mostSellers' => $gameRepository->getGroupedByGameByOrder('COUNT(library.game)'),
            'genres' => $genreRepository->findBy([], ['name' => 'ASC'], 9),
        ]);
    }
}
