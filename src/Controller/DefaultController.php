<?php

namespace App\Controller;

use App\Entity\Product;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $prodList=$entityManager->getRepository(Product::class)->findAll();
        dd($prodList);
        return $this->render('main/default/index.html.twig',[]);
    }

    /**
     * @Route("/product-add", name="product_add")
     */
        public function productAdd(Request $request) :Response
        {
            $product = new Product();
            $product->setTitle('Product'.rand(1,100));
            $product->setDescription('smthh');
            $product->setPrice(222);
            $product->setQuantity(3);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }
}
