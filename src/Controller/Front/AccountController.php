<?php

namespace App\Controller\Front;

use App\Entity\Account;
use App\Form\AccountRegisterType;
use App\Repository\AccountRepository;
use App\Service\TextService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    public function __construct(
        private AccountRepository $accountRepository,
        private EntityManagerInterface $em,
        private TextService $textService
    ) { }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/account/{slug}', name: 'app_account_show')]
    public function show(string $slug): Response {
        return $this->render('front/account/show.html.twig', [
            'account' => $this->accountRepository->getAccountBySlug($slug),
        ]);
    }

    #[Route('/register', name: 'app_account_register')]
    public function register(Request $request): Response {
        $form = $this->createForm(AccountRegisterType::class, new Account());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Account $data */
            $data = $form->getData();
            $data->setSlug($this->textService->slugify($data->getName()));
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('front/account/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
