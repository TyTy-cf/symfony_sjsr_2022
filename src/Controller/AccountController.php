<?php

namespace App\Controller;

use App\Repository\AccountRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    public function __construct(
        private AccountRepository $accountRepository
    ) { }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/account/{slug}', name: 'app_account_show')]
    public function show(string $slug): Response {
        return $this->render('account/show.html.twig', [
            'account' => $this->accountRepository->getAccountBySlug($slug),
        ]);
    }

}
