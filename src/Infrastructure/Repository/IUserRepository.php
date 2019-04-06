<?php

namespace App\Infrastructure\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

interface IUserRepository
{
    /**
     * __construct
     *
     * @param Doctrine\ORM\EntityManagerInterface $entityManager
     *
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager);

    /**
     * findUserByUsername
     *
     * @param string $username
     *
     * @return void
     */
    public function findUserByUsername(string $username): ?User;
}
