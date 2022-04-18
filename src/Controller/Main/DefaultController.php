<?php

namespace App\Controller\Main;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="main_homepage")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $prodList = $entityManager->getRepository(Product::class)->findAll();
        return $this->render('main/default/index.html.twig', []);
    }
}
