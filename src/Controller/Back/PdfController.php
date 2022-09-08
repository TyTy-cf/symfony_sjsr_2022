<?php

namespace App\Controller\Back;

use App\Entity\Account;
use App\Repository\PublisherRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{

    #[Route('/pdf/{slug}', name: 'app_pdf_library')]
    public function pdfAction(
        Pdf $knpSnappyPdf,
        Account $account
    ): Response
    {

        $html = $this->renderView('back/pdf/library.html.twig', [
            'account'  => $account
        ]);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            $account->getName().uniqid().'.pdf'
        );
    }

    #[Route('/pdf/publisher/turnover', name: 'app_pdf_publisher_turnover')]
    public function pdfPublisherTurnover(
        Pdf $knpSnappyPdf,
        PublisherRepository $publisherRepository
    ): Response
    {

        $html = $this->renderView('back/pdf/publisher.html.twig', [
            'publishers'  => $publisherRepository->getPublisherTurnover()
        ]);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'publisher_turnover_'.uniqid().'.pdf'
        );
    }

}