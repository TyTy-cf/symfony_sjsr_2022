<?php

namespace App\Controller\Back;

use App\Entity\Publisher;
use App\Form\PublisherType;
use App\Service\TextService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/publisher')]
class PublisherController extends AbstractController
{

    public function __construct(
        private TextService $textService
    ) { }

    #[Route('/new', name: 'app_publisher_admin_index')]
    public function new(): Response
    {
        $form = $this->createForm(PublisherType::class, new Publisher());

        return $this->render('back/publisher/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
