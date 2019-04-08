<?php

namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IUserUpdateService
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
     * updatePassword
     *
     * @param string $uid
     * @param string $password
     * @param string $new_password
     *
     * @return void
     */
    public function updatePassword(string $uid, string $password, string $new_password): void;
}
