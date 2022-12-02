<?php

namespace App\Controller\Front;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart')]
    public function index(
        SessionInterface $session,
        GameRepository $gameRepository
    ): Response
    {
        $cartDatasHtml = [];
        if ($session->has(AjaxController::$CART)) {
            $cartSession = $session->get(AjaxController::$CART);
            // persist + flush (si nécessaire)
            foreach ($cartSession as $key => $qty) {
                $cartDatasHtml[] = [
                  'game' => $gameRepository->findOneBy(['id' => $key]),
                  'qty' => $qty
                ];
            }
        }

        return $this->render('front/cart/index.html.twig', [
            'games' => $cartDatasHtml
        ]);
    }

    #[Route('/delete', name: 'app_delete_cart')]
    public function delete(
        SessionInterface $session,
    ): Response
    {
        $session->remove(AjaxController::$CART);
        $session->remove(AjaxController::$QTY);
        return $this->redirectToRoute('app_home');
    }

    #[Route('/payment', name: 'app_payment_cart')]
    public function payment(
        SessionInterface $session,
    ): Response
    {
        dump('paiement');
        // Créer votre Order depuis Cart (celui en session)
        return $this->redirectToRoute('app_home');
    }

}
