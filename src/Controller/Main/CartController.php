<?php

namespace App\Controller\Main;

use App\Repository\CartRepository;
use App\Utils\Manager\OrderManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="main_cart_show")
     */
    public function show(Request $request , CartRepository $cartRepository): Response
    {
        $cartToken = $request->cookies->get('CART_TOKEN');
        $cart = $cartRepository->findOneBy(['token' =>$cartToken]);

        return $this->render('main/cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/create", name="main_cart_create")
     */
    public function create(Request $request ,OrderManager $orderManager): Response
    {
        $cartToken = $request->cookies->get('CART_TOKEN');
        $user = $this->getUser();
        $orderManager->createOrderFromCartBySessionId($cartToken , $user);

        $redirectUrl = $this->generateUrl('main_cart_show');

        $response = new RedirectResponse($redirectUrl);
        $response->headers->clearCookie('CART_TOKEN' ,'/' ,null);
    }
}
