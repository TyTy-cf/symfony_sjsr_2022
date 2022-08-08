<?php

namespace App\Controller\Back;

use App\Repository\AccountRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'app_admin_account_index')]
    public function index(
        AccountRepository $accountRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $accounts = $paginator->paginate(
            $accountRepository->getQbAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('back/account/index.html.twig', [
            'accounts' => $accounts,
        ]);
    }
}
