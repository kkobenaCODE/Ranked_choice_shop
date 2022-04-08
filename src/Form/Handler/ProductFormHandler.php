<?php

namespace App\Form\Handler;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;

class ProductFormHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function processEditForm(Product $product, Form $form)
    {
        $this->$entityManager->persist($product);
        //TODO:ADD A NEW IMAGE WITH DIFFERENT SIZES TO THE PRODUCT
        //1. Save product's changes
        //2. Save uploaded file in temporary directory
        //3. Work with product (addProductImage) and ProductImage
        //3.1 Get path of folder with images
        //3.2 Work with ProductImage
        //3.2.1 Resize and image saving into folder (big small medium)
        //3.2.2 Create ProductImage and return to Product
        //3.3 Save Product with new ProductImage

        dd($product, $form->get('newImage')->getData());
        $this->$entityManager->flush();

        return $product;
    }
}