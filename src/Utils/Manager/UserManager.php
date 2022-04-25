<?php

namespace App\Utils\Manager;

use Doctrine\Persistence\ObjectRepository;
use App\Entity\User;

class UserManager extends AbstractBaseManager
{
    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(User::class);
    }

    /**
     * @param User $user
     */
    public function remove(object $user)
    {
        $user->setIsDeleted(true);
        $this->save($user);
    }
}