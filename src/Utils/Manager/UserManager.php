<?php

namespace App\Utils\Manager;

use App\Exception\Security\EmptyUserPlainPasswordException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager extends AbstractBaseManager
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager , UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($entityManager);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(User::class);
    }

    public function encodePassword(User $user , string $plainPassword)
    {
        $newPassword = trim($plainPassword);
        if(!$newPassword) {
            throw new EmptyUserPlainPasswordException('Empty user password');
        }
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user , $newPassword)
        );
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