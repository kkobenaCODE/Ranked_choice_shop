<?php

namespace App\Controller\Main;

use App\Repository\CartRepository;
use App\Utils\Manager\OrderManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="main_cart_show")
     */
    public function show(Request $request , CartRepository $cartRepository): Response
    {
        $phpSessId = $request->cookies->get('PHPSESSID');
        $cart = $cartRepository->findOneBy(['sessionId' =>$phpSessId]);

        return $this->render('main/cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/create", name="main_cart_create")
     */
    public function create(Request $request ,OrderManager $orderManager): Response
    {
        $phpSessId = $request->cookies->get('PHPSESSID');
        $user = $this->getUser();
        $orderManager->createOrderFromCartBySessionId($phpSessId , $user);
        return $this->redirectToRoute('main_cart_show');
    }
}
