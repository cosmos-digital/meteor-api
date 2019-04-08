<?php

namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserUpdateService implements IUserUpdateService
{
    private $userRepository;
    private $jsonResponse;

    /**
     * __construct
     *
     * @param App\Infrastructure\Repository\IUserRepository $userRepository
     * @param Symfony\Component\HttpFoundation\JsonResponse $jsonResponse
     * @return void
     */
    public function __construct(
        IUserRepository $userRepository,
        JsonResponse $jsonResponse
    ) {
        $this->userRepository = $userRepository;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * updatePassword
     *
     * @param string $uid
     * @param string $password
     * @param string $new_password
     *
     * @return void
     */
    public function updatePassword(string $uid, string $password, string $new_password): void
    {
        $user = $this->userRepository->findById($uid);

        if (!password_verify($password, $user->getPassword())) {
            $this->jsonResponse->setData(
                [
                    "message" => "Current Password Invalid",
                    "property_path" => "password",
                ]
            )->setStatusCode(
                $this->jsonResponse::HTTP_BAD_REQUEST
            );

            throw new \InvalidArgumentException();
        }

        $user->setPassword($new_password);
        $this->userRepository->save($user);
    }
}
