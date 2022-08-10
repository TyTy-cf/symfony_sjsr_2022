<?php

namespace App\Controller\Front;

use App\Form\Filter\GameSearchFilterType;
use App\Repository\CommentRepository;
use App\Repository\GameRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game')]
class GameController extends AbstractController
{

    public function __construct(
        private GameRepository $gameRepository
    ) { }

    #[Route('/', name: 'app_game_index')]
    public function index(
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request
    ): Response {

        $qb = $this->gameRepository->getQbAll();

        $filterForm = $this->createForm(
            GameSearchFilterType::class,
            null,
            ['method' => 'GET']
        );

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }

        $games = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('front/game/index.html.twig', [
            'gamesArray' => $games,
            'filterForm' => $filterForm->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'app_game_show')]
    public function show(
        string $slug,
        Request $request,
        PaginatorInterface $paginator,
        CommentRepository $commentRepository
    ): Response
    {
        $comments = $paginator->paginate(
            $commentRepository->getQueryBuilderByGame($slug),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('front/game/show.html.twig', [
            'game' => $this->gameRepository->findBySlugRelations($slug),
            'comments' => $comments
        ]);
    }
}
