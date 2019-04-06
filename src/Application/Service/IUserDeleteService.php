<?php

namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IUserDeleteService
{

    /**
     * __construct
     *
     * @param App\Infrastructure\Repository\IUserRepository $userRepository
     * @param Symfony\Component\HttpFoundation\JsonResponse $jsonResponse
     * @return void
     */
    public function __construct(IUserRepository $userRepository, JsonResponse $jsonResponse);

    /**
     * deleteByUid
     *
     * @param string $uid
     *
     * @return void
     */
    public function deleteByUid(string $uid): void;
}
