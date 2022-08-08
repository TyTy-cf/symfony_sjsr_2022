<?php

namespace App\Controller\Back;

use App\Entity\Publisher;
use App\Form\PublisherType;
use App\Repository\PublisherRepository;
use App\Service\TextService;
use Doctrine\ORM\EntityManagerInterface;
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
        private EntityManagerInterface $em,
        private PublisherRepository $publisherRepository
    ) { }

    #[Route('/', name: 'app_admin_publisher_index')]
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

    #[Route('/new', name: 'app_admin_publisher_new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(PublisherType::class, new Publisher());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Publisher $data */
            $data = $form->getData();
            $data->setSlug($this->textService->slugify($data->getName()));
            $this->em->persist($data);
            $this->em->flush();
            return $this->redirectToRoute('app_publisher_admin_index');
        }

        return $this->render('back/publisher/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{slug}', name: 'app_publisher_admin_edit')]
    public function edit(Request $request, Publisher $publisher): Response
    {
        $form = $this->createForm(PublisherType::class, $publisher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Publisher $data */
            $data = $form->getData();
            $data->setSlug($this->textService->slugify($data->getName()));
            $this->em->persist($data);
            $this->em->flush();
            return $this->redirectToRoute('app_publisher_admin_index');
        }

        return $this->render('back/publisher/new.html.twig', [
            'form' => $form->createView(),
            'publisher' => $publisher
        ]);
    }
}
