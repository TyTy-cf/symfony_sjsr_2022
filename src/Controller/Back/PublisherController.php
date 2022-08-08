<?php

namespace App\Controller\Back;

use App\Entity\Publisher;
use App\Form\PublisherType;
use App\Repository\PublisherRepository;
use App\Service\TextService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/publisher')]
class PublisherController extends AbstractController
{

    public function __construct(
        private TextService $textService,
        private PublisherRepository $publisherRepository
    ) { }

    #[Route('/', name: 'app_publisher_admin_index')]
    public function index(
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $publishers = $paginator->paginate(
            $this->publisherRepository->getQbAll(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('back/publisher/index.html.twig', [
            'publishers' => $publishers
        ]);
    }

    #[Route('/new', name: 'app_publisher_admin_new')]
    public function new(): Response
    {
        $form = $this->createForm(PublisherType::class, new Publisher());

        return $this->render('back/publisher/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
