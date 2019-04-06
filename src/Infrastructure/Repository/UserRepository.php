<?php

namespace App\Infrastructure\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final class UserRepository extends AbstractRepositorySQL implements IUserRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->objectClass = User::class;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    /**
     * findUserByUsername
     *
     * @param string $username
     *
     * @return void
     */
    public function findUserByUsername(string $username): ?User
    {

        $this->query = $this->getInstance()->createQuery(
            sprintf(
                "SELECT u FROM %s u WHERE u.username = :username",
                $this->objectClass
            )
        );

        return $this->query->setParameter(
            'username',
            $username
        )->getOneOrNullResult();
    }
}
