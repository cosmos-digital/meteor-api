<?php

namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;

final class AccountCreateService implements IAccountCreateService
{
    private $userRepository;
    private $validator;

    /**
     * __construct
     *
     * @param App\Application\Service\IEntityValidateService $validator
     * @param App\Infrastructure\Repository\IUserRepository $userRepository
     *
     * @return void
     */
    public function __construct(
        IEntityValidateService $validator,
        IUserRepository $userRepository
    ) {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
    }

    /**
     * create
     *
     * @param App\Entity\User $user
     *
     * @return void
     */
    public function create(User $user): void
    {
        $this->validator->validate($user);
        $this->userRepository->save($user);
    }
}
