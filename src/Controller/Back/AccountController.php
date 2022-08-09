<?php

namespace App\Controller\Back;

use App\Form\Filter\AccountFilterType;
use App\Repository\AccountRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;

#[Route('/admin/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'app_admin_account_index')]
    public function index(
        AccountRepository $accountRepository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request
    ): Response
    {
        $qb = $accountRepository->getQbAll();

        $filterForm = $this->createForm(AccountFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
            // ->where('country.nationality = 'Chinois')
            // ->andWhere('account.name LIKE '%7%')
            // ->andWhere('account.email LIKE '%hotmail%')
        }

        $accounts = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('back/account/index.html.twig', [
            'accounts' => $accounts,
            'filters' => $filterForm->createView(),
        ]);
    }
}
