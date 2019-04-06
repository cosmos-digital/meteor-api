<?php

namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IAccountCreateService
{
    /**
     * __construct
     *
     * @param App\Application\Service\IEntityValidateService $validator
     * @param App\Infrastructure\Repository\IUserRepository $userRepository
     * @param Symfony\Component\HttpFoundation\JsonResponse $jsonResponse
     *
     * @return void
     */
    public function __construct(IEntityValidateService $validator, IUserRepository $userRepository, JsonResponse $jsonResponse);

    /**
     * create
     *
     * @param App\Entity\User $user
     *
     * @return void
     */
    public function create(User $user): void;
}
