<?php

namespace App\Utils\Manager;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\Persistence\ObjectRepository;

class CartManager
{
    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Cart::class);
    }
}