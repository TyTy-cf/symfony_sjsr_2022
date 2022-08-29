<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ajax')]
class AjaxController extends AbstractController
{

    public static string $CART = 'CART';
    public static string $QTY = 'QTY';

    #[Route('/addItemToCart/{datas}', name: 'ajax_add_item_to_cart')]
    public function index(
        Request $request,
        SessionInterface $session
    ): Response
    {
//        $currentSession = [];
//        $cart = null;
//        if (!$session->has(self::$CART)) {
//            $cart = new Cart();
//            $em->persist($cart);
//        } else {
//            $cart = $session->get(self::$CART)
//        }
//        $product = $productRepository->findOneBy(['id' => $datas['id']])
//        if (!isset($currentSession[$datas['gameId']])) {
//              $lineProduct = $currentSession[$datas['gameId']];
//              $lineProduct->setQuantity($lineProduct->getQuantity() + $datas['qty']);
//         } else {
//              $datas = new Line()
//              $datas->setProduct($product)
//              $datas->setQuantity($datas['qty'])
//         }
        $datas = json_decode($request->get('datas'), true);
        $currentSession = [];
        if ($session->has(self::$CART)) {
            $currentSession = $session->get(self::$CART);
        }
        if (!isset($currentSession[$datas['gameId']])) {
            $currentSession[$datas['gameId']] = $datas['qty'];
        } else {
            $currentSession[$datas['gameId']] += $datas['qty'];
        }
        $session->set(self::$CART, $currentSession);

        $qtyTotal = 0;
        foreach ($currentSession as $item) {
            $qtyTotal += $item;
        }
        $session->set(self::$QTY, $qtyTotal);

        return new JsonResponse(['qtyTotale' => $qtyTotal]);
    }

}
