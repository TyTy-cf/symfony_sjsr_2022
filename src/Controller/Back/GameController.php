<?php

namespace App\Controller\Back;

use App\Entity\Game;
use App\Form\Filter\GameFilterType;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Service\TextService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/game')]
class GameController extends AbstractController
{

    public function __construct(
        private TextService $textService,
        private EntityManagerInterface $em
    ) { }

    #[Route('/', name: 'app_admin_game_index')]
    public function index(
        GameRepository $gameRepository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request
    ): Response
    {
        $qb = $gameRepository->getQbAll();

        $filterForm = $this->createForm(GameFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }

        $games = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('back/game/index.html.twig', [
            'games' => $games,
            'filters' => $filterForm->createView(),
        ]);
    }

    #[Route('/new', name: 'app_admin_game_new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(GameType::class, new Game());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Game $data */
            $data = $form->getData();
            $data->setSlug($this->textService->slugify($data->getName()));
            $this->em->persist($data);
            $this->em->flush();
            return $this->redirectToRoute('app_admin_game_index');
        }

        return $this->render('back/game/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}